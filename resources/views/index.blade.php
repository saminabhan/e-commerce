@extends('layouts.app')
@section('content')
<main>

<section class="swiper-container js-swiper-slider swiper-number-pagination slideshow" data-settings='{
    "autoplay": {
      "delay": 5000
    },
    "slidesPerView": 1,
    "effect": "fade",
    "loop": true
  }'>
  <div class="swiper-wrapper">

  <div class="swiper-slide">
      <div class="overflow-hidden position-relative h-100">
        <div class="slideshow-character position-absolute bottom-0 pos_right-center">
          <img loading="lazy" src="{{ asset('assets/images/home/demo3/gaming.png') }}" width="400" height="690"
            alt="Gaming"
            class="slideshow-character__img animate animate_fade animate_rtl animate_delay-10 w-auto h-auto" />
            <div class="character_markup type2">
            <p class="text-uppercase font-sofia fw-bold animate animate_fade animate_rtl animate_delay-10">Gaming
            </p>
          </div>
        </div>
        <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
          <h6 class="text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">
            New Arrivals</h6>
          <h2 class="h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5">Gift With Each</h2>
          <h2 class="h1 fw-bold animate animate_fade animate_btt animate_delay-5" style="color: #4062B1;">Gaming Machine</h2>
          <a href="{{route('shop.index')}}"
            class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">Shop
            Now</a>
        </div>
      </div>
    </div>
    
    <div class="swiper-slide">
      <div class="overflow-hidden position-relative h-100">
        <div class="slideshow-character position-absolute bottom-0 pos_right-center">
          <img loading="lazy" src="{{ asset('assets/images/home/demo3/watches.png') }}" width="542" height="733"
            alt="Watches"
            class="slideshow-character__img animate animate_fade animate_btt animate_delay-9 w-auto h-auto" />
          <div class="character_markup type2">
            <p
              class="text-uppercase font-sofia mark-grey-color animate animate_fade animate_btt animate_delay-10 mb-0">
              Watches</p>
          </div>
        </div>
        <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
          <h6 class="text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">
            New Arrivals</h6>
          <h2 class="h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5">New Titanium</h2>
          <h2 class="h1 fw-bold animate animate_fade animate_btt animate_delay-5" style="color: #4062B1;">Watches</h2>
          <a href="{{route('shop.index')}}"
            class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">Shop
            Now</a>
        </div>
      </div>
    </div>

    <div class="swiper-slide">
      <div class="overflow-hidden position-relative h-100">
        <div class="slideshow-character position-absolute bottom-0 pos_right-center">
          <img loading="lazy" src="{{ asset('assets/images/home/demo3/monitors.png') }}" width="400" height="733"
            alt="Monitors"
            class="slideshow-character__img animate animate_fade animate_btt animate_delay-9 w-auto h-auto" />
          <div class="character_markup type2">
            <p class="text-uppercase font-sofia fw-bold animate animate_fade animate_rtl animate_delay-10">Monitors
            </p>
          </div>
        </div>
        <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
          <h6 class="text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">
            New Arrivals</h6>
          <h2 class="h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5">High Quality</h2>
          <h2 class="h1 fw-bold animate animate_fade animate_btt animate_delay-5" style="color: #4062B1;">Monitors</h2>
          <a href="{{route('shop.index')}}"
            class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">Shop
            Now</a>
        </div>
      </div>
    </div>

  </div>

  <div class="container">
    <div
      class="slideshow-pagination slideshow-number-pagination d-flex align-items-center position-absolute bottom-0 mb-5">
    </div>
  </div>
</section>
<div class="container mw-1620 bg-white border-radius-10">
    <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
        <section class="category-carousel container">
            <h2 class="section-title text-center mb-3 pb-xl-2 mb-xl-4">You Might Like</h2>

            <div class="position-relative">
            <div class="swiper-container js-swiper-slider" data-settings='{
                "autoplay": {
                    "delay": 5000
                },
                "slidesPerView": 8,
                "slidesPerGroup": 1,
                "effect": "none",
                "loop": true,
                "navigation": {
                    "nextEl": ".products-carousel__next-1",
                    "prevEl": ".products-carousel__prev-1"
                },
                "breakpoints": {
                    "320": {
                        "slidesPerView": 2,
                        "slidesPerGroup": 2,
                        "spaceBetween": 15
                    },
                    "768": {
                        "slidesPerView": 4,
                        "slidesPerGroup": 4,
                        "spaceBetween": 30
                    },
                    "992": {
                        "slidesPerView": 6,
                        "slidesPerGroup": 1,
                        "spaceBetween": 45,
                        "pagination": false
                    },
                    "1200": {
                        "slidesPerView": 8,
                        "slidesPerGroup": 1,
                        "spaceBetween": 60,
                        "pagination": false
                    }
                }
            }'>
    <div class="swiper-wrapper">
        @foreach($products as $product)
            <div class="swiper-slide">
                <img loading="lazy" class="w-100 h-auto mb-3" 
                     src="{{ asset('uploads/products') }}/{{ $product->image }}" 
                     width="124" height="124" alt="{{ $product->name }}">
                <div class="text-center">
                    <a href="{{ route('shop.product.details', ['product_slug'=>$product->slug]) }}" class="menu-link fw-small">{{ $product->category->name }}<br>{{ $product->name }}</a>
                </div>
            </div>
        @endforeach
    </div>
</div>


            <div
                class="products-carousel__prev products-carousel__prev-1 position-absolute top-50 d-flex align-items-center justify-content-center">
                <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                <use href="#icon_prev_md" />
                </svg>
            </div><!-- /.products-carousel__prev -->
            <div
                class="products-carousel__next products-carousel__next-1 position-absolute top-50 d-flex align-items-center justify-content-center">
                <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                <use href="#icon_next_md" />
                </svg>
            </div><!-- /.products-carousel__next -->
            </div><!-- /.position-relative -->
        </section>

    <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

    <section class="hot-deals container">
        <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Hot Deals</h2>
        <div class="row">
        <div
            class="col-md-6 col-lg-4 col-xl-20per d-flex align-items-center flex-column justify-content-center py-4 align-items-md-start">
            <h2>Summer Sale</h2>
            <h2 class="fw-bold">Up to 60% Off</h2>

            <div class="position-relative d-flex align-items-center text-center pt-xxl-4 js-countdown mb-3"
            data-date="18-3-2024" data-time="06:50">
            <div class="day countdown-unit">
                <span class="countdown-num d-block"></span>
                <span class="countdown-word text-uppercase text-secondary">Days</span>
            </div>

            <div class="hour countdown-unit">
                <span class="countdown-num d-block"></span>
                <span class="countdown-word text-uppercase text-secondary">Hours</span>
            </div>

            <div class="min countdown-unit">
                <span class="countdown-num d-block"></span>
                <span class="countdown-word text-uppercase text-secondary">Mins</span>
            </div>

            <div class="sec countdown-unit">
                <span class="countdown-num d-block"></span>
                <span class="countdown-word text-uppercase text-secondary">Sec</span>
            </div>
            </div>

            <a href="{{ route('shop.index') }}" class="btn-link default-underline text-uppercase fw-medium mt-3">View All</a>
        </div>
        <div class="col-md-6 col-lg-8 col-xl-80per">
            <div class="position-relative">
                <div class="swiper-container js-swiper-slider" data-settings='{
                    "autoplay": { "delay": 5000 },
                    "slidesPerView": 4,
                    "slidesPerGroup": 4,
                    "effect": "none",
                    "loop": false,
                    "breakpoints": {
                        "320": { "slidesPerView": 2, "slidesPerGroup": 2, "spaceBetween": 14 },
                        "768": { "slidesPerView": 2, "slidesPerGroup": 3, "spaceBetween": 24 },
                        "992": { "slidesPerView": 3, "slidesPerGroup": 1, "spaceBetween": 30 },
                        "1200": { "slidesPerView": 4, "slidesPerGroup": 1, "spaceBetween": 30 }
                    }
                }'>
                    <div class="swiper-wrapper">
                        @foreach($saleProducts as $product)
                            <div class="swiper-slide product-card product-card_style3">
                            <div class="pc__img-wrapper">
                <div class="swiper-container background-img js-swiper-slider" data-settings='{"resizeObserver": true}'>
                  <div class="swiper-wrapper">
                    <div class="swiper-slide">
                      <a href="{{ route('shop.product.details', ['product_slug'=>$product->slug]) }}"><img loading="lazy" src="{{ asset('uploads/products') }}/{{ $product->image }}" width="330" height="400" alt="{{ $product->image }}" class="pc__img"></a>
                    </div>
                    @foreach ( explode(',',$product->images) as $gimg )
                    <div class="swiper-slide">
                      <a href="{{ route('shop.product.details', ['product_slug'=>$product->slug]) }}"><img loading="lazy" src="{{ asset('uploads/products') }}/{{ trim($gimg) }}" width="330" height="400" alt="{{ $product->image }}" class="pc__img"></a>
                    </div>
                    @endforeach
                  </div>
                  <span class="pc__img-prev"><svg width="7" height="11" viewBox="0 0 7 11"
                      xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_prev_sm" />
                    </svg></span>
                  <span class="pc__img-next"><svg width="7" height="11" viewBox="0 0 7 11"
                      xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_next_sm" />
                    </svg></span>
                </div>
                  @php
                    $inCart = false;
                    if (auth()->check()) {
                        $inCart = \App\Models\Cart::where('user_id', auth()->id())
                                  ->where('product_id', $product->id)
                                  ->exists();
                    }
                @endphp

                @if ($inCart)
                    <a href="{{ route('cart.index') }}" 
                      class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium btn-warning mb-3">
                        Go to Cart
                    </a>
                @else
                    <form name="addtocart-form" method="post" action="{{ route('cart.add') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product->id }}">
                        <input type="hidden" name="name" value="{{ $product->name }}">
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="price" value="{{ $product->sale_price ?: $product->regular_price }}">
                        <button type="submit" class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium" data-aside="cartDrawer" title="Add To Cart">
                            Add To Cart
                        </button>
                    </form>
                @endif
              </div>
              <div class="pc__info position-relative">
                <p class="pc__category">{{$product->category->name}}</p>
                <h6 class="pc__title"><a href="{{ route('shop.product.details', ['product_slug'=>$product->slug]) }}">{{$product->name}}</a></h6>
                <div class="product-card__price d-flex">
                  <span class="money price">
                    @if ($product->sale_price)
                        <s>${{$product->regular_price}}</s> ${{$product->sale_price}}
                    @else
                    ${{$product->regular_price}}
                    @endif
                  </span>
                </div>
                <div class="product-card__review d-flex align-items-center">
                  <div class="reviews-group d-flex">
                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_star" />
                    </svg>
                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_star" />
                    </svg>
                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_star" />
                    </svg>
                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_star" />
                    </svg>
                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_star" />
                    </svg>
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

              <button 
                  class="wishlist-btn position-absolute top-0 end-0 bg-transparent border-0 js-wishlist-toggle {{ $wishlistItem ? 'filled' : '' }}" 
                  data-product-id="{{ $product->id }}"
                  data-name="{{ $product->name }}"
                  data-price="{{ $product->sale_price ?: $product->regular_price }}"
                  data-action="{{ $wishlistItem ? 'remove' : 'add' }}"
                  data-row-id="{{ $wishlistItem->id ?? '' }}"
                  title="{{ $wishlistItem ? 'Remove from Wishlist' : 'Add to Wishlist' }}"
              >
                  <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
                      <use href="#icon_heart" />
                  </svg>
              </button>

              </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div><!-- /.position-relative -->
        </div>
        </div>
    </section>

    <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

    <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

    <section class="products-grid container">
        <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Newest Products</h2>

        <div class="row">
    @foreach ($newestProducts as $product)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
            <div class="pc__img-wrapper">
                <div class="swiper-container background-img js-swiper-slider" data-settings='{"resizeObserver": true}'>
                  <div class="swiper-wrapper">
                    <div class="swiper-slide">
                      <a href="{{ route('shop.product.details', ['product_slug'=>$product->slug]) }}"><img loading="lazy" src="{{ asset('uploads/products') }}/{{ $product->image }}" width="330" height="400" alt="{{ $product->image }}" class="pc__img"></a>
                    </div>
                    @foreach ( explode(',',$product->images) as $gimg )
                    <div class="swiper-slide">
                      <a href="{{ route('shop.product.details', ['product_slug'=>$product->slug]) }}"><img loading="lazy" src="{{ asset('uploads/products') }}/{{ trim($gimg) }}" width="330" height="400" alt="{{ $product->image }}" class="pc__img"></a>
                    </div>
                    @endforeach
                  </div>
                  <span class="pc__img-prev"><svg width="7" height="11" viewBox="0 0 7 11"
                      xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_prev_sm" />
                    </svg></span>
                  <span class="pc__img-next"><svg width="7" height="11" viewBox="0 0 7 11"
                      xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_next_sm" />
                    </svg></span>
                </div>
                        @php
                          $inCart = false;
                          if (auth()->check()) {
                              $inCart = \App\Models\Cart::where('user_id', auth()->id())
                                        ->where('product_id', $product->id)
                                        ->exists();
                          }
                      @endphp

                      @if ($inCart)
                          <a href="{{ route('cart.index') }}" 
                            class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium btn-warning mb-3">
                              Go to Cart
                          </a>
                      @else
                  <form name="addtocart-form" method="post" action="{{ route('cart.add') }}">
                      @csrf
                      <input type="hidden" name="id" value="{{ $product->id }}">
                      <input type="hidden" name="name" value="{{ $product->name }}">
                      <input type="hidden" name="quantity" value="1">
                      <input type="hidden" name="price" value="{{ $product->sale_price ?: $product->regular_price }}">
                      <button type="submit" class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium" data-aside="cartDrawer" title="Add To Cart">
                          Add To Cart
                      </button>
                  </form>
              @endif
              </div>

              <div class="pc__info position-relative">
                <p class="pc__category">{{$product->category->name}}</p>
                <h6 class="pc__title"><a href="{{ route('shop.product.details', ['product_slug'=>$product->slug]) }}">{{$product->name}}</a></h6>
                <div class="product-card__price d-flex">
                  <span class="money price">
                    @if ($product->sale_price)
                        <s>${{$product->regular_price}}</s> ${{$product->sale_price}}
                    @else
                    ${{$product->regular_price}}
                    @endif
                  </span>
                </div>
                <div class="product-card__review d-flex align-items-center">
                  <div class="reviews-group d-flex">
                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_star" />
                    </svg>
                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_star" />
                    </svg>
                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_star" />
                    </svg>
                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_star" />
                    </svg>
                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_star" />
                    </svg>
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

              <button 
                  class="wishlist-btn position-absolute top-0 end-0 bg-transparent border-0 js-wishlist-toggle {{ $wishlistItem ? 'filled' : '' }}" 
                  data-product-id="{{ $product->id }}"
                  data-name="{{ $product->name }}"
                  data-price="{{ $product->sale_price ?: $product->regular_price }}"
                  data-action="{{ $wishlistItem ? 'remove' : 'add' }}"
                  data-row-id="{{ $wishlistItem->id ?? '' }}"
                  title="{{ $wishlistItem ? 'Remove from Wishlist' : 'Add to Wishlist' }}"
              >
                  <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
                      <use href="#icon_heart" />
                  </svg>
              </button>

              </div>
            </div>
        </div>
    @endforeach
</div>


        <div class="text-center mt-2">
        <a class="btn-link btn-link_lg default-underline text-uppercase fw-medium" href="{{ route('shop.index') }}">View All</a>
        </div>
    </section>
    </div>

    <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

</main>
@endsection

@push('scripts')
  <script>
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
                    this.classList.toggle('filled');
                    this.dataset.action = action === 'add' ? 'remove' : 'add';

                    if (action === 'add') {
                        const result = await response.json();
                        this.dataset.rowId = result.id ?? ''; 
                        showToast('Added to Wishlist');
                    } else {
                        this.dataset.rowId = '';
                        showToast('Removed from Wishlist');
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

    // Toast alert
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
@endpush