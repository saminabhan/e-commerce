@extends('layouts.app')
@section('title', 'Sami Store | Shopping')
@section('content')
<style>
  .brand-list li, .category-list li{
    line-height: 40px;
  }
  .brand-list li .chk-brand , .category-list li .chk-category{
    width: 1rem;
    height: 1rem;
    color: #e4e4e4;
    border: 0.125rem solid currentColor;
    border-radius: 0;
    margin-right: 0.75rem;
  }
  .filled-heart{
    color: #4062B1;
  }
</style>

<main class="pt-90">
    <section class="shop-main container d-flex pt-4 pt-xl-5">
      <div class="shop-sidebar side-sticky bg-body" id="shopFilter">
        <div class="aside-header d-flex d-lg-none align-items-center">
          <h3 class="text-uppercase fs-6 mb-0">Filter By</h3>
          <button class="btn-close-lg js-close-aside btn-close-aside ms-auto"></button>
        </div>

        <div class="pt-4 pt-lg-0"></div>

        <div class="accordion" id="categories-list">
          <div class="accordion-item mb-4 pb-3">
            <h5 class="accordion-header" id="accordion-heading-1">
              <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
                data-bs-target="#accordion-filter-1" aria-expanded="true" aria-controls="accordion-filter-1">
                Product Categories
                <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                  <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                    <path
                      d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                  </g>
                </svg>
              </button>
            </h5>
            <div id="accordion-filter-1" class="accordion-collapse collapse show border-0"
              aria-labelledby="accordion-heading-1" data-bs-parent="#categories-list">
              <div class="accordion-body px-0 pb-0 pt-3 category-list">
                <ul class="list list-inline mb-0">
                  @foreach ($categories as $category)
                  <li class="list-item">
                    <span class="menu-link py-1">
                      <input type="checkbox" class="chk-category form-check-input" name="categories" value="{{$category->id}}" @if (in_array($category->id ,explode(',',$f_categories))) checked="checked" @endif>
                      {{$category->name}}
                    </span>
                    <span class="text-right float-end">
                      {{$category->products->count()}}
                    </span>
                  </li>
                  @endforeach
                 
                </ul>
              </div>
            </div>
          </div>
        </div>


        <!-- <div class="accordion" id="color-filters">
          <div class="accordion-item mb-4 pb-3">
            <h5 class="accordion-header" id="accordion-heading-1">
              <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
                data-bs-target="#accordion-filter-2" aria-expanded="true" aria-controls="accordion-filter-2">
                Color
                <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                  <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                    <path
                      d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                  </g>
                </svg>
              </button>
            </h5>
            <div id="accordion-filter-2" class="accordion-collapse collapse show border-0"
              aria-labelledby="accordion-heading-1" data-bs-parent="#color-filters">
              <div class="accordion-body px-0 pb-0">
                <div class="d-flex flex-wrap">
                  <a href="#" class="swatch-color js-filter" style="color: #0a2472"></a>
                  <a href="#" class="swatch-color js-filter" style="color: #d7bb4f"></a>
                  <a href="#" class="swatch-color js-filter" style="color: #282828"></a>
                  <a href="#" class="swatch-color js-filter" style="color: #b1d6e8"></a>
                  <a href="#" class="swatch-color js-filter" style="color: #9c7539"></a>
                  <a href="#" class="swatch-color js-filter" style="color: #d29b48"></a>
                  <a href="#" class="swatch-color js-filter" style="color: #e6ae95"></a>
                  <a href="#" class="swatch-color js-filter" style="color: #d76b67"></a>
                  <a href="#" class="swatch-color swatch_active js-filter" style="color: #bababa"></a>
                  <a href="#" class="swatch-color js-filter" style="color: #bfdcc4"></a>
                </div>
              </div>
            </div>
          </div>
        </div> -->

        <div class="accordion" id="brand-filters">
          <div class="accordion-item mb-4 pb-3">
            <h5 class="accordion-header" id="accordion-heading-brand">
              <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
                data-bs-target="#accordion-filter-brand" aria-expanded="true" aria-controls="accordion-filter-brand">
                Brands
                <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                  <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                    <path
                      d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                  </g>
                </svg>
              </button>
            </h5>
            <div id="accordion-filter-brand" class="accordion-collapse collapse show border-0"
              aria-labelledby="accordion-heading-brand" data-bs-parent="#brand-filters">
              <div class="search-field multi-select accordion-body px-0 pb-0">
                <ul class="list list-inline mb-0 brand-list">
                  @foreach ($brands as $brand)
                  <li class="list-item">
                    <span class="menu-link py-1">
                      <input type="checkbox" name="brands" id="" value="{{$brand->id}}" class="chk-brand form-check-input" @if (in_array($brand->id,explode(',',$f_brands))) checked="checked" @endif>
                      {{$brand->name}}
                    </span>
                    <span class="text-right float-end">
                      {{$brand->products->count()}}
                    </span>
                  </li>
                  @endforeach
                </ul>               
              </div>
            </div>
          </div>
        </div>


        <div class="accordion" id="price-filters">
          <div class="accordion-item mb-4">
            <h5 class="accordion-header mb-2" id="accordion-heading-price">
              <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
                data-bs-target="#accordion-filter-price" aria-expanded="true" aria-controls="accordion-filter-price">
                Price
                <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                  <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                    <path
                      d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                  </g>
                </svg>
              </button>
            </h5>
            <div id="accordion-filter-price" class="accordion-collapse collapse show border-0"
              aria-labelledby="accordion-heading-price" data-bs-parent="#price-filters">
              <input class="price-range-slider" type="text" name="price_range" value="" data-slider-min="10"
                data-slider-max="7000" data-slider-step="5" data-slider-value="[{{$min_price}},{{$max_price}}]" data-currency="$" />
              <div class="price-range__info d-flex align-items-center mt-2">
                <div class="me-auto">
                  <span class="text-secondary">Min Price: </span>
                  <span class="price-range__min">$1</span>
                </div>
                <div>
                  <span class="text-secondary">Max Price: </span>
                  <span class="price-range__max">$7000</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="shop-list flex-grow-1">
        <div class="swiper-container js-swiper-slider slideshow slideshow_small slideshow_split" data-settings='{
            "autoplay": {
              "delay": 5000
            },
            "slidesPerView": 1,
            "effect": "fade",
            "loop": true,
            "pagination": {
              "el": ".slideshow-pagination",
              "type": "bullets",
              "clickable": true
            }
          }'>
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                <div class="slide-split_text position-relative d-flex align-items-center"
                  style="background-color: #e5e6ea85;">
                  <div class="slideshow-text container p-3 p-xl-5">
                    <h2
                      class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                      Mobiles <br /><strong style="color: #4062B1;">COLLECTIONS</strong></h2>
                    <p class="mb-0 animate animate_fade animate_btt animate_delay-5">Accessories are the best way to
                      update your phone look. Add a title edge with new styles and new colors, or go for timeless pieces.</h6>
                  </div>
                </div>
                <div class="slide-split_media position-relative">
                  <div class="slideshow-bg" style="background-color: #dddddd;">
                    <img loading="lazy" src="assets/images/shop/shop_banner1.png" width="630" height="450"
                      alt="Women's accessories" class="slideshow-bg__img object-fit-cover" />
                  </div>
                </div>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                <div class="slide-split_text position-relative d-flex align-items-center"
                  style="background-color: #e5e6ea85;">
                  <div class="slideshow-text container p-3 p-xl-5">
                    <h2
                      class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                      Watches <br /><strong style="color: #4062B1;">COLLECTIONS</strong></h2>
                    <p class="mb-0 animate animate_fade animate_btt animate_delay-5">Accessories are the best way to
                      update your phone look. Add a title edge with new styles and new colors, or go for timeless pieces.</h6>
                  </div>
                </div>
                <div class="slide-split_media position-relative">
                  <div class="slideshow-bg" style="background-color: #dddddd;">
                    <img loading="lazy" src="assets/images/shop/shop_banner2.png" width="630" height="450"
                      alt="Women's accessories" class="slideshow-bg__img object-fit-cover" />
                  </div>
                </div>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                <div class="slide-split_text position-relative d-flex align-items-center"
                  style="background-color: #e5e6ea85;">
                  <div class="slideshow-text container p-3 p-xl-5">
                    <h2
                      class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                      Speakers <br /><strong style="color: #4062B1;">COLLECTIONS</strong></h2>
                    <p class="mb-0 animate animate_fade animate_btt animate_delay-5">Accessories are the best way to
                      update your phone look. Add a title edge with new styles and new colors, or go for timeless pieces.</h6>
                  </div>
                </div>
                <div class="slide-split_media position-relative">
                  <div class="slideshow-bg" style="background-color: #dddddd;">
                    <img loading="lazy" src="assets/images/shop/shop_banner3.png" width="630" height="450"
                      alt="Women's accessories" class="slideshow-bg__img object-fit-cover" />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="container p-3 p-xl-5">
            <div class="slideshow-pagination d-flex align-items-center position-absolute bottom-0 mb-4 pb-xl-2"></div>

          </div>
        </div>

        <div class="mb-3 pb-2 pb-xl-3"></div>

        <div class="d-flex justify-content-between mb-4 pb-md-2">
          <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
            <a href="{{ route('home.index') }}" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
            <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
            <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">The Shop</a>
          </div>

          <div class="shop-acs d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
            <select class="shop-acs__select form-select w-auto border-0 py-0 order-1 order-md-0" aria-label="Page Size" id="pagesize" name="pagesize" style="margin-right: 20px;">
              <option value="12" {{ $size== 12 ? 'selected' : ''}}>Show</option>
              <option value="24" {{ $size== 24 ? 'selected' : ''}}>24</option>
              <option value="48" {{ $size== 48 ? 'selected' : ''}}>48</option>
              <option value="102" {{ $size== 102 ? 'selected' : ''}}>102</option>
            </select>
            
            <select class="shop-acs__select form-select w-auto border-0 py-0 order-1 order-md-0" aria-label="Sort Items" name="orderby" id="orderby">
              <option value="-1" {{ $order== -1 ? 'selected' : ''}}>Default Sorting</option>
              <option value="1" {{ $order== 1 ? 'selected' : ''}}>Date, New To Old</option>
              <option value="2" {{ $order== 2 ? 'selected' : ''}}>Date, Old To New</option>
              <option value="3" {{ $order== 3 ? 'selected' : ''}}>Price, Low To High</option>
              <option value="4" {{ $order== 4 ? 'selected' : ''}}>Price, High To Low</option>
            </select>

            <div class="shop-asc__seprator mx-3 bg-light d-none d-md-block order-md-0"></div>

            <div class="col-size align-items-center order-1 d-none d-lg-flex">
              <span class="text-uppercase fw-medium me-2">View</span>
              <button class="btn-link fw-medium me-2 js-cols-size" data-target="products-grid" data-cols="2">2</button>
              <button class="btn-link fw-medium me-2 js-cols-size" data-target="products-grid" data-cols="3">3</button>
              <button class="btn-link fw-medium js-cols-size" data-target="products-grid" data-cols="4">4</button>
            </div>

            <div class="shop-filter d-flex align-items-center order-0 order-md-3 d-lg-none">
              <button class="btn-link btn-link_f d-flex align-items-center ps-0 js-open-aside" data-aside="shopFilter">
                <svg class="d-inline-block align-middle me-2" width="14" height="10" viewBox="0 0 14 10" fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_filter" />
                </svg>
                <span class="text-uppercase fw-medium d-inline-block align-middle">Filter</span>
              </button>
            </div>
          </div>
        </div>

       <div class="products-grid row row-cols-2 row-cols-md-3" id="products-grid">
 @foreach ($products as $product)
 <div class="product-card-wrapper">
   <div class="product-card mb-3 mb-md-4 mb-xxl-5" data-product-id="{{ $product->id }}">
     <div class="pc__img-wrapper">
       <div class="swiper-container background-img js-swiper-slider" data-settings='{"resizeObserver": true}'>
         <div class="swiper-wrapper" id="swiper-{{ $product->id }}">
           <div class="swiper-slide">
             <a href="{{ route('shop.product.details', ['product_slug'=>$product->slug]) }}">
               <img loading="lazy" src="{{ asset('uploads/products') }}/{{ $product->image }}"
                    width="330" height="400" alt="{{ $product->name }}" class="pc__img">
             </a>
           </div>
           @if($product->images)
           @foreach (explode(',', $product->images) as $gimg)
           <div class="swiper-slide">
             <a href="{{ route('shop.product.details', ['product_slug'=>$product->slug]) }}">
               <img loading="lazy" src="{{ asset('uploads/products') }}/{{ trim($gimg) }}"
                    width="330" height="400" alt="{{ $product->name }}" class="pc__img">
             </a>
           </div>
           @endforeach
           @endif
         </div>
         <span class="pc__img-prev"><svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
           <use href="#icon_prev_sm" /></svg></span>
         <span class="pc__img-next"><svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
           <use href="#icon_next_sm" /></svg></span>
       </div>

       @php
         $cartItem = null;
         if (auth()->check()) {
           $cartItem = \App\Models\Cart::where('user_id', auth()->id())
                         ->where('product_id', $product->id)
                         ->first();
         }
       @endphp

       @if (auth()->check())
         <button
           class="cart-btn pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium js-cart-toggle {{ $cartItem ? 'filled' : '' }}"
           data-product-id="{{ $product->id }}"
           data-name="{{ $product->name }}"
           data-price="{{ $product->sale_price ?: $product->regular_price }}"
           data-action="{{ $cartItem ? 'remove' : 'add' }}"
           data-row-id="{{ $cartItem->id ?? '' }}"
           title="{{ $cartItem ? 'Remove from Cart' : 'Add to Cart' }}">
           {{ $cartItem ? 'Remove from Cart' : 'Add To Cart' }}
         </button>
       @else
         <a href="{{ route('login') }}"
           class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium"
           title="Please login to add to cart">Add To Cart</a>
       @endif
     </div>

     <div class="pc__info position-relative">
       <div class="d-flex align-items-center justify-content-between mb-1">
         <p class="pc__category mb-0">{{ $product->category->name }}</p>
       </div>

       <h6 class="pc__title">
         <a href="{{ route('shop.product.details', ['product_slug'=>$product->slug]) }}">{{ $product->name }}</a>
       </h6>

       {{-- Colors Section - moved under title --}}
       @if($product->variants->count() > 0)
         @php
           $uniqueColors = $product->variants->map(function($variant) {
             return $variant->attributeValues->where('attribute.type', 'color')->first();
           })->filter()->unique('id');
         @endphp

         @if($uniqueColors->count() > 0)
           <div class="product-color-variants-inline d-flex align-items-center gap-1 mt-2">
             @foreach($uniqueColors->take(4) as $colorValue)
               <button
                 class="color-variant-btn-small"
                 data-product-id="{{ $product->id }}"
                 data-color-id="{{ $colorValue->id }}"
                 data-color-name="{{ $colorValue->value }}"
                 style="background: {{ $colorValue->color_code ?? '#ccc' }};"
                 title="{{ $colorValue->value }}">
               </button>
             @endforeach
             @if($uniqueColors->count() > 4)
               <span class="color-more-text">+{{ $uniqueColors->count() - 4 }}</span>
             @endif
           </div>
         @endif
       @endif

       <div class="product-card__price d-flex mt-2">
         <span class="money price">
           @if ($product->sale_price)
             <s>${{ $product->regular_price }}</s> ${{ $product->sale_price }}
           @else
             ${{ $product->regular_price }}
           @endif
         </span>
       </div>

       <div class="product-card__review d-flex align-items-center">
         <div class="reviews-group d-flex">
           <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg"><use href="#icon_star" /></svg>
           <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg"><use href="#icon_star" /></svg>
           <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg"><use href="#icon_star" /></svg>
           <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg"><use href="#icon_star" /></svg>
           <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg"><use href="#icon_star" /></svg>
         </div>
         <span class="reviews-note text-lowercase text-secondary ms-1">8k+ reviews</span>
       </div>

       @php
         $wishlistItem = null;
         if (auth()->check()) {
           $wishlistItem = \App\Models\Wishlist::where('user_id', auth()->id())
                           ->where('product_id', $product->id)
                           ->first();
         }
       @endphp

       @if (auth()->check())
         <button
           class="wishlist-btn position-absolute top-0 end-0 bg-transparent border-0 js-wishlist-toggle {{ $wishlistItem ? 'filled' : '' }}"
           data-product-id="{{ $product->id }}"
           data-name="{{ $product->name }}"
           data-price="{{ $product->sale_price ?: $product->regular_price }}"
           data-action="{{ $wishlistItem ? 'remove' : 'add' }}"
           data-row-id="{{ $wishlistItem->id ?? '' }}"
           title="{{ $wishlistItem ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
           <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
             <use href="#icon_heart" />
           </svg>
         </button>
       @else
         <a href="{{ route('login') }}"
           class="wishlist-btn position-absolute top-0 end-0 bg-transparent border-0"
           title="Please login to add to wishlist">
           <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
             <use href="#icon_heart" />
           </svg>
         </a>
       @endif
     </div>
   </div>
 </div>
 @endforeach
</div>

       

        <!-- <nav class="shop-pages d-flex justify-content-between mt-3" aria-label="Page navigation">
          <a href="#" class="btn-link d-inline-flex align-items-center">
            <svg class="me-1" width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
              <use href="#icon_prev_sm" />
            </svg>
            <span class="fw-medium">PREV</span>
          </a>
          <ul class="pagination mb-0">
            <li class="page-item"><a class="btn-link px-1 mx-2 btn-link_active" href="#">1</a></li>
            <li class="page-item"><a class="btn-link px-1 mx-2" href="#">2</a></li>
            <li class="page-item"><a class="btn-link px-1 mx-2" href="#">3</a></li>
            <li class="page-item"><a class="btn-link px-1 mx-2" href="#">4</a></li>
          </ul>
          <a href="#" class="btn-link d-inline-flex align-items-center">
            <span class="fw-medium me-1">NEXT</span>
            <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
              <use href="#icon_next_sm" />
            </svg>
          </a>
        </nav> -->
        <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{$products->withQueryString()->links('pagination::bootstrap-5')}}
            </div>
      </div>
      
    </section>
  </main>

  <form id="frmfilter" method="GET" action="{{ route('shop.index') }}">
    <!-- start page size number -->
    <input type="hidden" name="page" value="{{$products->currentPage()}}">
    <input type="hidden" name="size" id="size" value="{{$size}}">
    <!-- end page size number -->

    <!-- start page order by  -->
    <input type="hidden" name="order" id="order" value="{{$order}}">
    <!-- end page order by  -->

    <!-- start brands sort  -->
    <input type="hidden" name="brands" id="hdnBrands">
    <!-- end page brands sort  -->

    <!-- start categories sort  -->
    <input type="hidden" name="categories" id="hdnCategories">
    <!-- end categories sort  -->

    <!-- start price sort  -->
    <input type="hidden" name="min" id="hdnMinPrice" value="{{$min_price}}">
    <input type="hidden" name="max" id="hdnMaxPrice" value="{{$max_price}}">
    <!-- end price sort  -->
     
  </form>
@endsection

@push('scripts')
  <script>
    $(function(){
      $("#pagesize").on("change",function(){
        $("#size").val($("#pagesize option:selected").val());
        $("#frmfilter").submit();
      });

      $("#orderby").on("change",function(){
        $("#order").val($("#orderby option:selected").val());
        $("#frmfilter").submit();
      });

      $("input[name='brands']").on("change",function(){
        var brands = "";
        $("input[name='brands']:checked").each(function(){
          if(brands == ""){
            brands += $(this).val();
          }else{
            brands += "," + $(this).val();
          }
          });
          $("#hdnBrands").val(brands);
          $("#frmfilter").submit();
        });

        $("input[name='categories']").on("change",function(){
        var categories = "";
        $("input[name='categories']:checked").each(function(){
          if(categories == ""){
            categories += $(this).val();
          }else{
            categories += "," + $(this).val();
          }
          });
          $("#hdnCategories").val(categories);
          $("#frmfilter").submit();
        });

        $("input[name='price_range']").on("change",function(){
          var min = $(this).val().split(',')[0];
          var max = $(this).val().split(',')[1];
          $("#hdnMinPrice").val(min);
          $("#hdnMaxPrice").val(max);
          setTimeout(() => {
          $("#frmfilter").submit();
          },2000);
        });

    });
  </script>

 <!-- <script>
document.addEventListener('DOMContentLoaded', function () {
    const token = document.querySelector('meta[name="csrf-token"]').content;

    document.querySelectorAll('.js-wishlist-toggle').forEach(button => {
        button.addEventListener('click', async function () {
            const id = this.dataset.productId;
            const name = this.dataset.name;
            const price = this.dataset.price;
            const action = this.dataset.action;
            const rowId = this.dataset.rowId;

            const route = action === 'add'
                ? '{{ route("wishlist.add") }}'
                : `/wishlist/remove/${rowId}`;

            const method = action === 'add' ? 'POST' : 'DELETE';

            const body = action === 'add'
                ? JSON.stringify({ id, name, price, quantity: 1 })
                : null;

            try {
                const response = await fetch(route, {
                    method,
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body
                });

                if (response.ok) {
                    const result = await response.json();

                    if (action === 'add') {
                        this.classList.add('filled');
                        this.dataset.action = 'remove';
                        this.dataset.rowId = result.id ?? '';
                        this.title = 'Remove from Wishlist';
                        showToast('Added to Wishlist');
                    } else {
                        this.classList.remove('filled');
                        this.dataset.action = 'add';
                        this.dataset.rowId = '';
                        this.title = 'Add to Wishlist';
                        showToast('Removed from Wishlist');
                    }

                    const countSpan = document.querySelector('#wishlist-count');
                    if (countSpan) {
                        countSpan.textContent = result.wishlistCount;
                        countSpan.style.display = result.wishlistCount > 0 ? 'inline-block' : 'none';
                    }
                } else {
                    showToast('Something went wrong', true);
                }
            } catch (err) {
                console.error(err);
                showToast('Network error', true);
            }
        });
    });

    function showToast(message, isError = false) {
        const toast = document.createElement('div');
        toast.innerText = message;
        toast.className = `wishlist-toast ${isError ? 'error' : 'success'}`;
        document.body.appendChild(toast);
        setTimeout(() => toast.classList.add('show'), 100);
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 2000);
    }
});
</script> -->

<script>
document.addEventListener('DOMContentLoaded', function () {
    const token = document.querySelector('meta[name="csrf-token"]').content;

    document.querySelectorAll('.js-cart-toggle').forEach(button => {
        button.addEventListener('click', async function () {
            const id = this.dataset.productId;
            const name = this.dataset.name;
            const price = this.dataset.price;
            const action = this.dataset.action;
            const rowId = this.dataset.rowId;

            const route = action === 'add'
                ? '{{ route("cart.add") }}'
                : `/cart/remove/${rowId}`;

            const method = action === 'add' ? 'POST' : 'DELETE';

            const body = action === 'add'
                ? JSON.stringify({ id, name, price, quantity: 1 })
                : null;

            try {
                const response = await fetch(route, {
                    method,
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body
                });

                if (response.ok) {
                    const result = await response.json();

                    if (action === 'add') {
                        this.dataset.action = 'remove';
                        this.dataset.rowId = result.id ?? '';
                        this.title = 'Remove from Cart';
                        this.textContent = 'Remove from Cart';
                        showToast('Added to Cart');
                    } else {
                        this.dataset.action = 'add';
                        this.dataset.rowId = '';
                        this.title = 'Add to Cart';
                        this.textContent = 'Add to Cart';
                        showToast('Removed from Cart');
                    }

                    const countSpan = document.querySelector('#cart-count');
                    if (countSpan) {
                        countSpan.textContent = result.cartCount;
                        countSpan.style.display = result.cartCount > 0 ? 'inline-block' : 'none';
                    }
                } else {
                    showToast('Something went wrong', true);
                }
            } catch (err) {
                console.error(err);
                showToast('Network error', true);
            }
        });
    });

    function showToast(message, isError = false) {
        const toast = document.createElement('div');
        toast.innerText = message;
        toast.className = `wishlist-toast ${isError ? 'error' : 'success'}`;
        document.body.appendChild(toast);
        setTimeout(() => toast.classList.add('show'), 100);
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 2000);
    }
});
</script>
<script>
  // Color Variant Image Switching
// Color Variant Image Switching - Fixed version
document.addEventListener('DOMContentLoaded', function() {
    // Track swiper instances
    const swiperInstances = new Map();
    
    document.querySelectorAll('.color-variant-btn-small').forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const productId = this.dataset.productId;
            const colorId = this.dataset.colorId;
            const colorName = this.dataset.colorName;
            
            // Remove active class from siblings
            const siblings = this.parentElement.querySelectorAll('.color-variant-btn-small');
            siblings.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Get elements
            const productCard = this.closest('.product-card');
            const swiperContainer = productCard.querySelector('.swiper-container');
            const swiperWrapper = productCard.querySelector('.swiper-wrapper');
            const imgWrapper = productCard.querySelector('.pc__img-wrapper');
            
            if (!swiperWrapper || !swiperContainer) return;
            
            // Prevent interaction during loading
            swiperContainer.classList.add('loading');
            
            // Add loading overlay
            const loadingOverlay = document.createElement('div');
            loadingOverlay.className = 'color-loading-overlay';
            loadingOverlay.innerHTML = '<div class="spinner"></div>';
            imgWrapper.appendChild(loadingOverlay);
            
            try {
                // Fetch variant images
                const response = await fetch(`/api/product-variant-images/${productId}/${colorId}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                if (response.ok) {
                    const data = await response.json();
                    
                    if (data.images && data.images.length > 0) {
                        // Destroy existing swiper instance if exists
                        if (swiperContainer.swiper) {
                            swiperContainer.swiper.destroy(true, true);
                        }
                        
                        // Clear existing slides
                        swiperWrapper.innerHTML = '';
                        
                        // Add new slides
                        data.images.forEach((image, index) => {
                            const slide = document.createElement('div');
                            slide.className = 'swiper-slide';
                            slide.innerHTML = `
                                <a href="${data.productUrl}">
                                    <img loading="lazy" 
                                         src="/uploads/products/${image}" 
                                         width="330" 
                                         height="400" 
                                         alt="${data.productName} - ${colorName}" 
                                         class="pc__img">
                                </a>
                            `;
                            swiperWrapper.appendChild(slide);
                        });
                        
                        // Small delay to ensure DOM is ready
                        setTimeout(() => {
                            // Reinitialize Swiper
                            if (typeof Swiper !== 'undefined') {
                                const newSwiper = new Swiper(swiperContainer, {
                                    resizeObserver: true,
                                    slidesPerView: 1,
                                    navigation: {
                                        nextEl: swiperContainer.querySelector('.pc__img-next'),
                                        prevEl: swiperContainer.querySelector('.pc__img-prev'),
                                    },
                                    on: {
                                        init: function() {
                                            swiperContainer.classList.remove('loading');
                                        }
                                    }
                                });
                                
                                // Store instance for later
                                swiperInstances.set(productId, newSwiper);
                            } else {
                                swiperContainer.classList.remove('loading');
                            }
                        }, 100);
                        
                        // Show success feedback
                        showColorToast(`Showing ${colorName}`, false);
                    } else {
                        swiperContainer.classList.remove('loading');
                        showColorToast('No images for this color', true);
                    }
                } else {
                    swiperContainer.classList.remove('loading');
                    showColorToast('Failed to load images', true);
                }
            } catch (error) {
                console.error('Error fetching variant images:', error);
                swiperContainer.classList.remove('loading');
                showColorToast('Network error', true);
            } finally {
                // Remove loading overlay
                setTimeout(() => {
                    if (loadingOverlay.parentNode) {
                        loadingOverlay.remove();
                    }
                }, 300);
            }
        });
    });
  

});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const swiperInstances = new Map();

    document.querySelectorAll('.color-variant-btn-small').forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            e.stopPropagation();

            const productId = this.dataset.productId;
            const colorId = this.dataset.colorId;
            const colorName = this.dataset.colorName;

            // Remove active from siblings
            const siblings = this.parentElement.querySelectorAll('.color-variant-btn-small');
            siblings.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            const productCard = this.closest('.product-card');
            const swiperContainer = productCard.querySelector('.swiper-container');
            const swiperWrapper = productCard.querySelector('.swiper-wrapper');
            const imgWrapper = productCard.querySelector('.pc__img-wrapper');

            if (!swiperWrapper || !swiperContainer) return;
            swiperContainer.classList.add('loading');

            const loadingOverlay = document.createElement('div');
            loadingOverlay.className = 'color-loading-overlay';
            loadingOverlay.innerHTML = '<div class="spinner"></div>';
            imgWrapper.appendChild(loadingOverlay);

            try {
                const response = await fetch(`/api/product-variant-images/${productId}/${colorId}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (response.ok) {
                    const data = await response.json();

                    if (data.images && data.images.length > 0) {
                        if (swiperContainer.swiper) {
                            swiperContainer.swiper.destroy(true, true);
                        }
                        swiperWrapper.innerHTML = '';

                        data.images.forEach((image) => {
                            const slide = document.createElement('div');
                            slide.className = 'swiper-slide';
                            slide.innerHTML = `
                                <a href="${data.productUrl}">
                                    <img loading="lazy" 
                                         src="/uploads/products/${image}" 
                                         width="330" 
                                         height="400" 
                                         alt="${data.productName} - ${colorName}" 
                                         class="pc__img">
                                </a>
                            `;
                            swiperWrapper.appendChild(slide);
                        });

                        setTimeout(() => {
                            if (typeof Swiper !== 'undefined') {
                                const newSwiper = new Swiper(swiperContainer, {
                                    resizeObserver: true,
                                    slidesPerView: 1,
                                    navigation: {
                                        nextEl: swiperContainer.querySelector('.pc__img-next'),
                                        prevEl: swiperContainer.querySelector('.pc__img-prev'),
                                    },
                                    on: {
                                        init: function() {
                                            swiperContainer.classList.remove('loading');
                                        }
                                    }
                                });
                                swiperInstances.set(productId, newSwiper);
                            } else {
                                swiperContainer.classList.remove('loading');
                            }
                        }, 100);

                        // ✅ هنا يظهر التوست مرة وحدة فقط
                        showColorToast(`Showing ${colorName}`, this.style.background);
                    } else {
                        swiperContainer.classList.remove('loading');
                        showColorToast('No images for this color', null, true);
                    }
                } else {
                    swiperContainer.classList.remove('loading');
                    showColorToast('Failed to load images', null, true);
                }
            } catch (error) {
                console.error('Error fetching variant images:', error);
                swiperContainer.classList.remove('loading');
                showColorToast('Network error', null, true);
            } finally {
                setTimeout(() => {
                    if (loadingOverlay.parentNode) {
                        loadingOverlay.remove();
                    }
                }, 300);
            }
        });
    });

    // دالة لتعديل درجة اللون (أفتح أو أغمق)
    function adjustColor(color, amount) {
        const ctx = document.createElement("canvas").getContext("2d");
        ctx.fillStyle = color;
        const hex = ctx.fillStyle;

        let r = parseInt(hex.substr(1, 2), 16);
        let g = parseInt(hex.substr(3, 2), 16);
        let b = parseInt(hex.substr(5, 2), 16);

        r = Math.min(255, Math.max(0, r + amount));
        g = Math.min(255, Math.max(0, g + amount));
        b = Math.min(255, Math.max(0, b + amount));

        return `rgb(${r}, ${g}, ${b})`;
    }

    // دالة تحدد النص أغمق أو أفتح حسب الخلفية
    function getTextColor(bgColor) {
        const ctx = document.createElement("canvas").getContext("2d");
        ctx.fillStyle = bgColor;
        const hex = ctx.fillStyle;

        const r = parseInt(hex.substr(1, 2), 16);
        const g = parseInt(hex.substr(3, 2), 16);
        const b = parseInt(hex.substr(5, 2), 16);

        const luma = 0.2126*r + 0.7152*g + 0.0722*b;
        return luma < 128 ? adjustColor(bgColor, 120) : adjustColor(bgColor, -120);
    }

    // Toast notification function
    function showColorToast(message, colorCode = null, isError = false) {
        document.querySelectorAll('.color-toast').forEach(t => t.remove());

        const toast = document.createElement('div');
        toast.innerText = message;

        if (colorCode) {
            toast.className = "color-toast";
            toast.style.background = colorCode;   
            toast.style.color = getTextColor(colorCode); 
        } else {
            toast.className = `color-toast ${isError ? 'error' : 'success'}`;
        }

        document.body.appendChild(toast);

        setTimeout(() => toast.classList.add('show'), 100);
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 2000);
    }
});
</script>


<style>
/* Color Variants Inline with Category - Professional Style */
.product-color-variants-inline {
  display: inline-flex;
  align-items: center;
  gap: 4px;
}

.color-variant-btn-small {
  width: 18px;
  height: 18px;
  border-radius: 50%;
  border: 1.5px solid #fff;
  cursor: pointer;
  transition: all 0.2s ease;
  position: relative;
  padding: 0;
  background-clip: padding-box;
  box-shadow: 0 0 0 1px #d1d5db, 0 1px 2px rgba(0,0,0,0.1);
  flex-shrink: 0;
}

.color-variant-btn-small:hover {
  transform: scale(1.25);
  box-shadow: 0 0 0 2px #4062B1, 0 2px 4px rgba(64, 98, 177, 0.3);
  z-index: 2;
}

.color-variant-btn-small.active {
  border-color: #4062B1;
  border-width: 2px;
  box-shadow: 0 0 0 1px #fff, 0 0 0 3px #4062B1;
  transform: scale(1.15);
}

.color-variant-btn-small.active::after {
  content: '✓';
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  color: #fff;
  font-size: 10px;
  font-weight: bold;
  text-shadow: 0 1px 2px rgba(0,0,0,0.8);
}

.color-more-text {
  font-size: 11px;
  color: #6b7280;
  font-weight: 500;
  margin-left: 2px;
}

.pc__category {
  font-size: 13px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #6b7280;
  font-weight: 500;
}

/* Loading overlay - Fixed for swiper issue */
.color-loading-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(255, 255, 255, 0.95);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 999;
  border-radius: 8px;
}

.color-loading-overlay .spinner {
  width: 35px;
  height: 35px;
  border: 3px solid #f3f3f3;
  border-top: 3px solid #4062B1;
  border-radius: 50%;
  animation: spin 0.6s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Toast notification */
.color-toast {
  position: fixed;
  bottom: 30px;
  right: 30px;
  background: #4062B1;
  color: white;
  padding: 10px 20px;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  z-index: 9999;
  opacity: 0;
  transform: translateY(20px);
  transition: all 0.3s ease;
  font-size: 13px;
  font-weight: 500;
}

.color-toast.show {
  opacity: 1;
  transform: translateY(0);
}

.color-toast.error {
  background: #dc3545;
}

.color-toast.success {
  background: #10b981;
}

/* Swiper fixes for color switching */
.swiper-container.loading {
  pointer-events: none;
  opacity: 0.7;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .color-variant-btn-small {
    width: 16px;
    height: 16px;
  }
  
  .pc__category {
    font-size: 12px;
  }
  
  .color-more-text {
    font-size: 10px;
  }
  
  .color-toast {
    bottom: 20px;
    right: 20px;
    left: 20px;
    text-align: center;
    font-size: 12px;
  }
}

/* Hover effect on product card */
.product-card:hover .color-variant-btn-small {
  opacity: 1;
  visibility: visible;
}

.color-variant-btn-small {
  opacity: 0.85;
  transition: all 0.2s ease;
}
</style>
@endpush
