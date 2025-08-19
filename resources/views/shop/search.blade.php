{{-- resources/views/search-results.blade.php --}}
@extends('layouts.app')
@section('title', 'Search Results')

@section('content')
<main class="page-main">
    <div class="mb-4 pb-4"></div>
    <br><br>
    
    <section class="shop-main container">
        <div class="d-flex justify-content-between mb-4 pb-md-2">
            <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                <a href="{{ route('home.index') }}" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
                <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                <span class="fs-base fw-medium">Search Results</span>
            </div>
        </div>

        <!-- Search Header -->
        <div class="mb-5">
            <h1 class="section-title text-center mb-3">
                Search Results for: <span class="text-primary">"{{ $keyword }}"</span>
            </h1>
            
            @if($products->count() > 0)
                <p class="text-center text-secondary mb-4">
                    Found <strong>{{ $products->count() }}</strong> product(s) matching your search
                </p>
            @endif

            <!-- Search Again Form -->
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <form action="{{ route('products.search') }}" method="GET" class="search-field position-relative">
                        <div class="position-relative">
                            <input class="form-control form-control-lg border-2 rounded-pill ps-4 pe-5" 
                                type="text" name="search-keyword"
                                value="{{ $keyword }}" 
                                placeholder="Search products..." 
                                autocomplete="off" />
                            <button class="btn btn-primary position-absolute end-0 top-0 h-100 px-4 rounded-pill" type="submit">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <use href="#icon_search" />
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Live Search Results Container -->
                        <div class="position-absolute start-0 top-100 w-100" style="z-index: 1000;">
                            <div class="search-result bg-white border rounded shadow-sm mt-2" style="display: none;"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if($products->count() > 0)
            <!-- Filters & Sort (Optional) -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <span class="text-secondary me-3">Sort by:</span>
                        <select class="form-select form-select-sm" style="width: auto;" onchange="sortProducts(this.value)">
                            <option value="name_asc">Name (A-Z)</option>
                            <option value="name_desc">Name (Z-A)</option>
                            <option value="price_asc">Price (Low to High)</option>
                            <option value="price_desc">Price (High to Low)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 text-md-end">
                    <span class="text-secondary">Showing {{ $products->count() }} results</span>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="products-grid row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 g-md-4" id="products-grid">
                @foreach($products as $product)
                    @php
                        $wishlistItem = \App\Models\Wishlist::where('user_id', Auth::id())
                                                          ->where('product_id', $product->id)
                                                          ->first();
                        $cartItem = \App\Models\Cart::where('user_id', Auth::id())
                                                   ->where('product_id', $product->id)
                                                   ->first();
                    @endphp

                    <div class="product-card-wrapper" data-name="{{ $product->name }}" 
                         data-price="{{ $product->sale_price ?: $product->regular_price }}">
                        <div class="product-card mb-3 mb-md-4 mb-xxl-5 h-100 shadow-sm">
                            <div class="pc__img-wrapper position-relative">
                                <div class="swiper-container background-img js-swiper-slider"
                                    data-settings='{"resizeObserver": true}'>
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <a href="{{ route('shop.product.details', $product->slug) }}">
                                                <img loading="lazy" 
                                                     src="{{ asset('uploads/products') }}/{{ $product->image }}" 
                                                     width="330" height="400" 
                                                     alt="{{ $product->name }}" 
                                                     class="pc__img"
                                                     onerror="this.src='{{ asset('assets/images/default-product.jpg') }}'">
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stock Status Badge -->
                                @if($product->stock_status === 'outofstock')
                                    <span class="position-absolute top-0 start-0 bg-danger text-white px-2 py-1 small rounded-end">
                                        Out of Stock
                                    </span>
                                @elseif($product->featured)
                                    <span class="position-absolute top-0 start-0 bg-warning text-dark px-2 py-1 small rounded-end">
                                        Featured
                                    </span>
                                @endif

                                <!-- Product Actions -->
                                <div class="pc__atc">
                                    @if($product->stock_status === 'instock')
                                        <button class="btn-link btn-link_lg text-uppercase fw-medium js-cart-toggle btn-addtocart
                                            {{ $cartItem ? 'filled' : '' }}"
                                            data-product-id="{{ $product->id }}"
                                            data-name="{{ $product->name }}"
                                            data-price="{{ $product->sale_price ?: $product->regular_price }}"
                                            data-row-id="{{ $cartItem ? $cartItem->rowId : '' }}"
                                            data-action="{{ $cartItem ? 'remove' : 'add' }}"
                                            title="{{ $cartItem ? 'Remove from Cart' : 'Add To Cart' }}">
                                            {{ $cartItem ? 'Remove from Cart' : 'Add To Cart' }}
                                        </button>
                                    @else
                                        <button class="btn-link btn-link_lg text-uppercase fw-medium" disabled>
                                            Out of Stock
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <div class="pc__info position-relative p-3"> 
                                <p class="pc__category text-secondary small mb-2">
                                    {{ $product->category->name ?? 'Uncategorized' }}
                                </p>
                                
                                <h6 class="pc__title mb-2">
                                    <a href="{{ route('shop.product.details', $product->slug) }}" 
                                       class="text-decoration-none">{{ $product->name }}</a>
                                </h6>

                                <!-- Product Rating (if available) -->
                                @if($product->reviews && $product->reviews->count() > 0)
                                    <div class="pc__rating d-flex align-items-center mb-2">
                                        @php
                                            $avgRating = $product->reviews->avg('rating');
                                        @endphp
                                        <div class="reviews-group d-flex">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="review__star {{ $i <= $avgRating ? 'review__star--active' : '' }}" 
                                                     viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_star" />
                                                </svg>
                                            @endfor
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-2 small">
                                            ({{ $product->reviews->count() }})
                                        </span>
                                    </div>
                                @endif

                                <div class="product-card__price d-flex align-items-center">
                                    <span class="money price text-primary fw-bold">
                                        ${{ number_format($product->sale_price ?: $product->regular_price, 2) }}
                                    </span>
                                    @if($product->sale_price && $product->regular_price > $product->sale_price)
                                        <span class="money price price-old text-decoration-line-through text-secondary ms-2">
                                            ${{ number_format($product->regular_price, 2) }}
                                        </span>
                                        @php
                                            $discount = round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100);
                                        @endphp
                                        <span class="badge bg-danger ms-2">-{{ $discount }}%</span>
                                    @endif
                                </div>

                                <!-- Wishlist Button -->
                                <button class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-wishlist-toggle
                                    {{ $wishlistItem ? 'filled' : '' }}"
                                    data-product-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}"
                                    data-price="{{ $product->sale_price ?: $product->regular_price }}"
                                    data-row-id="{{ $wishlistItem ? $wishlistItem->rowId : '' }}"
                                    data-action="{{ $wishlistItem ? 'remove' : 'add' }}"
                                    title="{{ $wishlistItem ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
                                        <use href="#icon_heart" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Results Summary -->
            <div class="text-center mt-5 pt-4 border-top">
                <p class="text-secondary mb-3">
                    Showing all <strong>{{ $products->count() }}</strong> results for "<strong>{{ $keyword }}</strong>"
                </p>
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <a href="{{ route('shop.index') }}" class="btn btn-outline-primary">
                        <svg style="display:none;">
                            <symbol id="icon_cart_super" viewBox="0 0 24 24" fill="currentColor">
                               <path d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm10 
                                0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM7.16 
                                14l.84-2h7.45c.75 0 1.41-.41 1.75-1.03L21 4H6.21L5.27 
                                2H1v2h3l3.6 7.59-1.35 2.44C5.52 15.37 6.48 17 8 
                                17h12v-2H8l-.84-1z"/>
                            </symbol>
                        </svg>

                        <svg width="20" height="20" viewBox="0 0 24 24" class="me-1">
                        <use href="#icon_cart_super"></use>
                        </svg>
                        Browse All Products
                    </a>
                    <button class="btn btn-outline-secondary" onclick="window.history.back()">
                        ← Go Back
                    </button>
                </div>
            </div>

        @else
            <!-- No Results Found -->
            <div class="no-results text-center py-5">
                <div class="mb-4">
                    <svg width="80" height="80" viewBox="0 0 20 20" fill="none" class="text-secondary opacity-50">
                        <use href="#icon_search" />
                    </svg>
                </div>
                
                <h3 class="mb-3">No products found</h3>
                <p class="text-secondary mb-4 lead">
                    Sorry, we couldn't find any products matching "<strong>{{ $keyword }}</strong>".
                </p>
                
                <!-- Search Tips -->
                <div class="search-tips mb-5 p-4 bg-light rounded">
                    <h5 class="mb-3">Search Tips:</h5>
                    <div class="row text-start">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2">✓ Check your spelling</li>
                                <li class="mb-2">✓ Try broader search terms</li>
                                <li class="mb-2">✓ Use fewer keywords</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2">✓ Search by brand name</li>
                                <li class="mb-2">✓ Try category names</li>
                                <li class="mb-2">✓ Use product features</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Popular Search Terms -->
                <div class="suggestions mb-5">
                    <h5 class="mb-3">Popular searches:</h5>
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        @php
                            $suggestions = ['iPhone', 'Samsung', 'MacBook', 'Headphones', 'Watch', 'Camera', 'Laptop', 'Tablet'];
                        @endphp
                        
                        @foreach($suggestions as $suggestion)
                            <a href="{{ route('products.search', ['search-keyword' => $suggestion]) }}" 
                               class="btn btn-outline-secondary btn-sm">{{ $suggestion }}</a>
                        @endforeach
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-4">
                    <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg me-3">
                        <svg width="18" height="18" viewBox="0 0 18 18" class="me-2">
                            <use href="#icon_hanger" />
                        </svg>
                        Browse All Products
                    </a>
                    <a href="{{ route('home.index') }}" class="btn btn-outline-primary btn-lg">
                        <svg width="18" height="18" viewBox="0 0 18 18" class="me-2">
                            <use href="#icon_home" />
                        </svg>
                        Back to Home
                    </a>
                </div>
            </div>
        @endif

        <!-- Popular Categories (always show) -->
        <section class="mt-5 pt-5 border-top">
            <h4 class="text-center mb-4">Popular Categories</h4>
            <div class="row row-cols-2 row-cols-md-4 g-3">
                @php
                    $categories = \App\Models\Category::withCount('products')
                                                    ->having('products_count', '>', 0)
                                                    ->orderBy('products_count', 'desc')
                                                    ->limit(8)
                                                    ->get();
                @endphp
                
                @foreach($categories as $category)
                    <div class="col">
                        <div class="card text-center h-100 border-0 shadow-sm hover-card">
                            <div class="card-body p-3">
                                <h6 class="card-title mb-2 fw-bold">{{ $category->name }}</h6>
                                <p class="card-text text-secondary small mb-3">
                                    {{ $category->products_count }} product{{ $category->products_count > 1 ? 's' : '' }}
                                </p>
                                <a href="{{ route('shop.index', array_merge(request()->query(), ['categories' => $category->id])) }}" 
                                class="btn btn-sm btn-outline-primary">View Products</a>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </section>
</main>

<div class="mb-5 pb-xl-5"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sort functionality
    window.sortProducts = function(sortBy) {
        const grid = document.getElementById('products-grid');
        const products = Array.from(grid.children);
        
        products.sort((a, b) => {
            const aName = a.dataset.name.toLowerCase();
            const bName = b.dataset.name.toLowerCase();
            const aPrice = parseFloat(a.dataset.price);
            const bPrice = parseFloat(b.dataset.price);
            
            switch(sortBy) {
                case 'name_asc':
                    return aName.localeCompare(bName);
                case 'name_desc':
                    return bName.localeCompare(aName);
                case 'price_asc':
                    return aPrice - bPrice;
                case 'price_desc':
                    return bPrice - aPrice;
                default:
                    return 0;
            }
        });
        
        grid.innerHTML = '';
        products.forEach(product => grid.appendChild(product));
    };
    
    // Hover effects
    const cards = document.querySelectorAll('.hover-card, .product-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.transition = 'transform 0.3s ease, box-shadow 0.3s ease';
            this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '';
        });
    });

    // Search input enhancements
    const searchInput = document.querySelector('.search-field input[name="search-keyword"]');
    
    if (searchInput) {
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                this.closest('form').submit();
            }
        });
        
        // Auto-focus on search input
        searchInput.focus();
        
        // Select text when focused
        searchInput.addEventListener('focus', function() {
            this.select();
        });
    }

    // Lazy loading for images
    const images = document.querySelectorAll('.pc__img');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.style.opacity = '1';
                img.style.filter = 'none';
                observer.unobserve(img);
            }
        });
    });

    images.forEach(img => {
        img.style.opacity = '0.7';
        img.style.filter = 'blur(2px)';
        img.style.transition = 'opacity 0.3s ease, filter 0.3s ease';
        imageObserver.observe(img);
    });
    
    // Add loading animation for better UX
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach((card, index) => {
        card.style.animationDelay = `${index * 100}ms`;
        card.classList.add('fade-in-up');
    });
});
</script>

<style>
.hover-card {
    transition: all 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.fade-in-up {
    animation: fadeInUp 0.6s ease forwards;
    opacity: 0;
    transform: translateY(20px);
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.search-tips ul li::before {
    content: none;
}

.no-results {
    min-height: 400px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

@media (max-width: 768px) {
    .products-grid .col {
        margin-bottom: 1rem;
    }
    
    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
    }
}
</style>
@endsection