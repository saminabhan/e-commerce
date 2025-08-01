@extends('layouts.app')
@section('title', 'Sami Store | Product Details')
@section('content')
<style>
  .filled-heart{
    color: #4062B1;
  }
</style>
<main class="pt-90">
    <div class="mb-md-1 pb-md-3"></div>
    <section class="product-single container">
      <div class="row">
        <div class="col-lg-7">
          <div class="product-single__media" data-media-type="vertical-thumbnail">
            <div class="product-single__image">
              <div class="swiper-container">
                <div class="swiper-wrapper">

                  <div class="swiper-slide product-single__image-item">
                    <img loading="lazy" class="h-auto" src="{{ asset('uploads/products') }}/{{ $product->image }}" width="674"
                      height="674" alt="" />
                    <a data-fancybox="gallery" href="{{ asset('uploads/products') }}/{{ $product->image }}" data-bs-toggle="tooltip"
                      data-bs-placement="left" title="Zoom">
                      <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_zoom" />
                      </svg>
                    </a>
                  </div>
                  @foreach ( explode(',',$product->images) as $gimg )
                  <div class="swiper-slide product-single__image-item">
                    <img loading="lazy" class="h-auto" src="{{ asset('uploads/products') }}/{{ $gimg }}" width="674"
                      height="674" alt="" />
                    <a data-fancybox="gallery" href="{{ asset('uploads/products') }}/{{ $gimg }}" data-bs-toggle="tooltip"
                      data-bs-placement="left" title="Zoom">
                      <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_zoom" />
                      </svg>
                    </a>
                  </div>
                  @endforeach

                
                  
                </div>
                <div class="swiper-button-prev"><svg width="7" height="11" viewBox="0 0 7 11"
                    xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_prev_sm" />
                  </svg></div>
                <div class="swiper-button-next"><svg width="7" height="11" viewBox="0 0 7 11"
                    xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_next_sm" />
                  </svg></div>
              </div>
            </div>
            <div class="product-single__thumbnail">
              <div class="swiper-container">
                <div class="swiper-wrapper">
                  <div class="swiper-slide product-single__image-item"><img loading="lazy" class="h-auto"
                      src="{{ asset('uploads/products') }}/{{ $product->image }}" width="104" height="104" alt="" /></div>
                @foreach ( explode(',',$product->images) as $gimg )
                  <div class="swiper-slide product-single__image-item"><img loading="lazy" class="h-auto"
                      src="{{ asset('uploads/products') }}/{{ $gimg }}" width="104" height="104" alt="" /></div>
                @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="d-flex justify-content-between mb-4 pb-md-2">
            <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
              <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
              <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
              <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">The Shop</a>
            </div><!-- /.breadcrumb -->

            <div
              class="product-single__prev-next d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
              <a href="#" class="text-uppercase fw-medium"><svg width="10" height="10" viewBox="0 0 25 25"
                  xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_prev_md" />
                </svg><span class="menu-link menu-link_us-s">Prev</span></a>
              <a href="#" class="text-uppercase fw-medium"><span class="menu-link menu-link_us-s">Next</span><svg
                  width="10" height="10" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_next_md" />
                </svg></a>
            </div><!-- /.shop-acs -->
          </div>
          <h1 class="product-single__name">{{$product->name}}</h1>
          <div class="product-single__rating">
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
          <div class="product-single__price">
            <span class="current-price">
            @if ($product->sale_price)
                <s>${{$product->regular_price}}</s> ${{$product->sale_price}}
            @else
                ${{$product->regular_price}}
            @endif
            </span>
          </div>
          <div class="product-single__short-desc">
            <p>{{$product->short_description}}</p>
          </div>
     @php
    $cartItem = Cart::instance('cart')->content()->firstWhere('id', $product->id);
@endphp

@if ($cartItem)
    <a href="{{ route('cart.index') }}" class="btn btn-warning mb-3">Go to Cart</a>
@else
<div class="product-single__addtocart">
  <div class="qty-control position-relative">
    <input type="number" name="quantity" value="1" min="1" class="qty-control__number text-center">
    <div class="qty-control__reduce" role="button" tabindex="0" aria-label="Decrease quantity">-</div>
    <div class="qty-control__increase" role="button" tabindex="0" aria-label="Increase quantity">+</div>
  </div>

  <button
    type="button"
    class="btn btn-primary js-cart-toggle"
    data-product-id="{{ $product->id }}"
    data-name="{{ $product->name }}"
    data-price="{{ $product->sale_price ?: $product->regular_price }}"
    data-action="add"
    data-row-id=""
    data-add-route="{{ route('cart.add') }}"
    title="Add to Cart"
  >
    Add to Cart
  </button>
</div>
@endif


                  <div class="product-single__addtolinks">
                  @php
            $wishlistItem = null;
            if (auth()->check()) {
                $wishlistItem = \App\Models\Wishlist::where('user_id', auth()->id())
                                ->where('product_id', $product->id)
                                ->first();
            }
        @endphp

        @if (auth()->check())
            <form method="POST"
                class="js-wishlist-form"
                data-product-id="{{ $product->id }}"
                data-name="{{ $product->name }}"
                data-price="{{ $product->sale_price ?: $product->regular_price }}"
                data-action="{{ $wishlistItem ? 'remove' : 'add' }}"
                data-row-id="{{ $wishlistItem->id ?? '' }}"
            >
                @csrf
                @if($wishlistItem)
                    @method('DELETE')
                @else
                    <input type="hidden" name="quantity" value="1">
                @endif

                <a href="javascript:void(0)"
                    class="menu-link menu-link_us-s add-to-wishlist {{ $wishlistItem ? 'filled-heart' : '' }}"
                    onclick="this.closest('form').dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));"
                >
                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
                        <use href="#icon_heart" />
                    </svg>
                    <span>{{ $wishlistItem ? 'Remove from Wishlist' : 'Add to Wishlist' }}</span>
                </a>
            </form>
        @else
            <a href="{{ route('login') }}"
                class="menu-link menu-link_us-s add-to-wishlist"
                title="Please login to add to wishlist"
            >
                <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
                    <use href="#icon_heart" />
                </svg>
                <span>Add to Wishlist</span>
            </a>
        @endif

            <share-button class="share-button">
              <button class="menu-link menu-link_us-s to-share border-0 bg-transparent d-flex align-items-center">
                <svg width="16" height="19" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_sharing" />
                </svg>
                <span>Share</span>
              </button>
              <details id="Details-share-template__main" class="m-1 xl:m-1.5" hidden="">
                <summary class="btn-solid m-1 xl:m-1.5 pt-3.5 pb-3 px-5">+</summary>
                <div id="Article-share-template__main"
                  class="share-button__fallback flex items-center absolute top-full left-0 w-full px-2 py-4 bg-container shadow-theme border-t z-10">
                  <div class="field grow mr-4">
                    <label class="field__label sr-only" for="url">Link</label>
                    <input type="text" class="field__input w-full" id="url"
                      value="https://uomo-crystal.myshopify.com/blogs/news/go-to-wellness-tips-for-mental-health"
                      placeholder="Link" onclick="this.select();" readonly="">
                  </div>
                  <button class="share-button__copy no-js-hidden">
                    <svg class="icon icon-clipboard inline-block mr-1" width="11" height="13" fill="none"
                      xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" viewBox="0 0 11 13">
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M2 1a1 1 0 011-1h7a1 1 0 011 1v9a1 1 0 01-1 1V1H2zM1 2a1 1 0 00-1 1v9a1 1 0 001 1h7a1 1 0 001-1V3a1 1 0 00-1-1H1zm0 10V3h7v9H1z"
                        fill="currentColor"></path>
                    </svg>
                    <span class="sr-only">Copy link</span>
                  </button>
                </div>
              </details>
            </share-button>
            <script src="js/details-disclosure.html" defer="defer"></script>
            <script src="js/share.html" defer="defer"></script>
          </div>
          <div class="product-single__meta-info">
            <div class="meta-item">
              <label>SKU:</label>
              <span>{{$product->SKU}}</span>
            </div>
            <div class="meta-item">
              <label>Categories:</label>
              <span>{{$product->category->name}}</span>
            </div>
            <div class="meta-item">
              <label>Tags:</label>
              <span>N/A</span>
            </div>
          </div>
        </div>
      </div>
      <div class="product-single__details-tab">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <a class="nav-link nav-link_underscore active" id="tab-description-tab" data-bs-toggle="tab"
              href="#tab-description" role="tab" aria-controls="tab-description" aria-selected="true">Description</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link nav-link_underscore" id="tab-additional-info-tab" data-bs-toggle="tab"
              href="#tab-additional-info" role="tab" aria-controls="tab-additional-info"
              aria-selected="false">Additional Information</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link nav-link_underscore" id="tab-reviews-tab" data-bs-toggle="tab" href="#tab-reviews"
              role="tab" aria-controls="tab-reviews" aria-selected="false">Reviews (2)</a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane fade show active" id="tab-description" role="tabpanel"
            aria-labelledby="tab-description-tab">
            <div class="product-single__description">
                {{$product->description}}
            </div>

            <!-- <div class="product-single__description">
              <h3 class="block-title mb-4">Sed do eiusmod tempor incididunt ut labore</h3>
              <p class="content">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt
                in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus
                error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo
                inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
              <div class="row">
                <div class="col-lg-6">
                  <h3 class="block-title">Why choose product?</h3>
                  <ul class="list text-list">
                    <li>Creat by cotton fibric with soft and smooth</li>
                    <li>Simple, Configurable (e.g. size, color, etc.), bundled</li>
                    <li>Downloadable/Digital Products, Virtual Products</li>
                  </ul>
                </div>
                <div class="col-lg-6">
                  <h3 class="block-title">Sample Number List</h3>
                  <ol class="list text-list">
                    <li>Create Store-specific attrittbutes on the fly</li>
                    <li>Simple, Configurable (e.g. size, color, etc.), bundled</li>
                    <li>Downloadable/Digital Products, Virtual Products</li>
                  </ol>
                </div>
              </div>
              <h3 class="block-title mb-0">Lining</h3>
              <p class="content">100% Polyester, Main: 100% Polyester.</p>
            </div> -->
          </div>
          <div class="tab-pane fade" id="tab-additional-info" role="tabpanel" aria-labelledby="tab-additional-info-tab">
            <div class="product-single__addtional-info">
              <div class="item">
                <label class="h6">Weight</label>
                <span>1.25 kg</span>
              </div>
              <div class="item">
                <label class="h6">Dimensions</label>
                <span>90 x 60 x 90 cm</span>
              </div>
              <div class="item">
                <label class="h6">Size</label>
                <span>XS, S, M, L, XL</span>
              </div>
              <div class="item">
                <label class="h6">Color</label>
                <span>Black, Orange, White</span>
              </div>
              <div class="item">
                <label class="h6">Storage</label>
                <span>Relaxed fit shirt-style dress with a rugged</span>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="tab-reviews" role="tabpanel" aria-labelledby="tab-reviews-tab">
            <h2 class="product-single__reviews-title">Reviews</h2>
            <div class="product-single__reviews-list">
              <div class="product-single__reviews-item">
                <div class="customer-avatar">
                  <img loading="lazy" src="assets/images/avatar.jpg" alt="" />
                </div>
                <div class="customer-review">
                  <div class="customer-name">
                    <h6>Janice Miller</h6>
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
                  </div>
                  <div class="review-date">April 06, 2023</div>
                  <div class="review-text">
                    <p>Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod
                      maxime placeat facere possimus, omnis voluptas assumenda est…</p>
                  </div>
                </div>
              </div>
              <div class="product-single__reviews-item">
                <div class="customer-avatar">
                  <img loading="lazy" src="assets/images/avatar.jpg" alt="" />
                </div>
                <div class="customer-review">
                  <div class="customer-name">
                    <h6>Benjam Porter</h6>
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
                  </div>
                  <div class="review-date">April 06, 2023</div>
                  <div class="review-text">
                    <p>Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod
                      maxime placeat facere possimus, omnis voluptas assumenda est…</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="product-single__review-form">
              <form name="customer-review-form">
                <h5>Be the first to review “Message Cotton T-Shirt”</h5>
                <p>Your email address will not be published. Required fields are marked *</p>
                <div class="select-star-rating">
                  <label>Your rating *</label>
                  <span class="star-rating">
                    <svg class="star-rating__star-icon" width="12" height="12" fill="#ccc" viewBox="0 0 12 12"
                      xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z" />
                    </svg>
                    <svg class="star-rating__star-icon" width="12" height="12" fill="#ccc" viewBox="0 0 12 12"
                      xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z" />
                    </svg>
                    <svg class="star-rating__star-icon" width="12" height="12" fill="#ccc" viewBox="0 0 12 12"
                      xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z" />
                    </svg>
                    <svg class="star-rating__star-icon" width="12" height="12" fill="#ccc" viewBox="0 0 12 12"
                      xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z" />
                    </svg>
                    <svg class="star-rating__star-icon" width="12" height="12" fill="#ccc" viewBox="0 0 12 12"
                      xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z" />
                    </svg>
                  </span>
                  <input type="hidden" id="form-input-rating" value="" />
                </div>
                <div class="mb-4">
                  <textarea id="form-input-review" class="form-control form-control_gray" placeholder="Your Review"
                    cols="30" rows="8"></textarea>
                </div>
                <div class="form-label-fixed mb-4">
                  <label for="form-input-name" class="form-label">Name *</label>
                  <input id="form-input-name" class="form-control form-control-md form-control_gray">
                </div>
                <div class="form-label-fixed mb-4">
                  <label for="form-input-email" class="form-label">Email address *</label>
                  <input id="form-input-email" class="form-control form-control-md form-control_gray">
                </div>
                <div class="form-check mb-4">
                  <input class="form-check-input form-check-input_fill" type="checkbox" value="" id="remember_checkbox">
                  <label class="form-check-label" for="remember_checkbox">
                    Save my name, email, and website in this browser for the next time I comment.
                  </label>
                </div>
                <div class="form-action">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="products-carousel container">
      <h2 class="h3 text-uppercase mb-4 pb-xl-2 mb-xl-4">Related <strong>Products</strong></h2>

      <div id="related_products" class="position-relative">
        <div class="swiper-container js-swiper-slider" data-settings='{
            "autoplay": false,
            "slidesPerView": 4,
            "slidesPerGroup": 4,
            "effect": "none",
            "loop": true,
            "pagination": {
              "el": "#related_products .products-pagination",
              "type": "bullets",
              "clickable": true
            },
            "navigation": {
              "nextEl": "#related_products .products-carousel__next",
              "prevEl": "#related_products .products-carousel__prev"
            },
            "breakpoints": {
              "320": {
                "slidesPerView": 2,
                "slidesPerGroup": 2,
                "spaceBetween": 14
              },
              "768": {
                "slidesPerView": 3,
                "slidesPerGroup": 3,
                "spaceBetween": 24
              },
              "992": {
                "slidesPerView": 4,
                "slidesPerGroup": 4,
                "spaceBetween": 30
              }
            }
          }'>
          <div class="swiper-wrapper">
              @foreach ($rproducts as $rproduct)
                <div class="swiper-slide product-card product-card_style3">
                  <div class="pc__img-wrapper">
                    <div class="swiper-container background-img js-swiper-slider" data-settings='{"resizeObserver": true}'>
                      <div class="swiper-wrapper">
                        <div class="swiper-slide">
                          <a href="{{ route('shop.product.details', ['product_slug'=>$rproduct->slug]) }}">
                            <img loading="lazy" src="{{ asset('uploads/products') }}/{{ $rproduct->image }}" width="330" height="400" alt="{{ $rproduct->name }}" class="pc__img">
                          </a>
                        </div>
                        @foreach (explode(',', $rproduct->images) as $gimg)
                        <div class="swiper-slide">
                          <a href="{{ route('shop.product.details', ['product_slug'=>$rproduct->slug]) }}">
                            <img loading="lazy" src="{{ asset('uploads/products') }}/{{ trim($gimg) }}" width="330" height="400" alt="{{ $rproduct->name }}" class="pc__img">
                          </a>
                        </div>
                        @endforeach
                      </div>
                      <span class="pc__img-prev"><svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg"><use href="#icon_prev_sm" /></svg></span>
                      <span class="pc__img-next"><svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg"><use href="#icon_next_sm" /></svg></span>
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
                          data-product-id="{{ $rproduct->id }}"
                          data-name="{{ $rproduct->name }}"
                          data-price="{{ $rproduct->sale_price ?: $rproduct->regular_price }}"
                          data-action="{{ $cartItem ? 'remove' : 'add' }}"
                          data-row-id="{{ $cartItem->id ?? '' }}"
                          data-add-route="{{ route('cart.add') }}"
                          title="{{ $cartItem ? 'Remove from Cart' : 'Add to Cart' }}"
                      >
                          {{ $cartItem ? 'Remove from Cart' : 'Add to Cart' }}
                      </button>
                  @else
                      <a href="{{ route('login') }}"
                          class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium"
                          title="Please login to add to cart"
                      >
                          Add to Cart
                      </a>
                  @endif

                  </div>

                  <div class="pc__info position-relative">
                    <p class="pc__category">{{ $rproduct->category->name }}</p>
                    <h6 class="pc__title">
                      <a href="{{ route('shop.product.details', ['product_slug'=>$rproduct->slug]) }}">{{ $rproduct->name }}</a>
                    </h6>
                    <div class="product-card__price d-flex">
                      <span class="money price">
                        @if ($rproduct->sale_price)
                          <s>${{ $rproduct->regular_price }}</s> ${{ $rproduct->sale_price }}
                        @else
                          ${{ $rproduct->regular_price }}
                        @endif
                      </span>
                    </div>
                    <div class="product-card__review d-flex align-items-center">
                      <div class="reviews-group d-flex">
                        @for ($i = 0; $i < 5; $i++)
                          <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg"><use href="#icon_star" /></svg>
                        @endfor
                      </div>
                      <span class="reviews-note text-lowercase text-secondary ms-1">8k+ reviews</span>
                    </div>

                    @php
                      $wishlistItem = null;
                      if (auth()->check()) {
                          $wishlistItem = \App\Models\Wishlist::where('user_id', auth()->id())
                                          ->where('product_id', $rproduct->id)
                                          ->first();
                      }
                    @endphp

                    @if (auth()->check())
                    <button 
                      class="wishlist-btn position-absolute top-0 end-0 bg-transparent border-0 js-wishlist-toggle {{ $wishlistItem ? 'filled' : '' }}" 
                      data-product-id="{{ $rproduct->id }}"
                      data-name="{{ $rproduct->name }}"
                      data-price="{{ $rproduct->sale_price ?: $rproduct->regular_price }}"
                      data-action="{{ $wishlistItem ? 'remove' : 'add' }}"
                      data-row-id="{{ $wishlistItem->id ?? '' }}"
                      title="{{ $wishlistItem ? 'Remove from Wishlist' : 'Add to Wishlist' }}"
                    >
                      <svg width="16" height="16" viewBox="0 0 20 20" fill="none"><use href="#icon_heart" /></svg>
                    </button>
                    @else
                        <a href="{{ route('login') }}"
                            class="wishlist-btn position-absolute top-0 end-0 bg-transparent border-0"
                            title="Please login to add to wishlist"
                        >
                            <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
                                <use href="#icon_heart" />
                            </svg>
                        </a>
                    @endif
                  </div>
                </div>
                @endforeach

            
          </div><!-- /.swiper-wrapper -->
        </div><!-- /.swiper-container js-swiper-slider -->

        <div class="products-carousel__prev position-absolute top-50 d-flex align-items-center justify-content-center">
          <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
            <use href="#icon_prev_md" />
          </svg>
        </div><!-- /.products-carousel__prev -->
        <div class="products-carousel__next position-absolute top-50 d-flex align-items-center justify-content-center">
          <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
            <use href="#icon_next_md" />
          </svg>
        </div><!-- /.products-carousel__next -->

        <div class="products-pagination mt-4 mb-5 d-flex align-items-center justify-content-center"></div>
        <!-- /.products-pagination -->
      </div><!-- /.position-relative -->

    </section><!-- /.products-carousel container -->
  </main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const token = document.querySelector('meta[name="csrf-token"]')?.content;

    document.querySelectorAll('.js-wishlist-form').forEach(form => {
        const btn = form.querySelector('.add-to-wishlist');
        const span = btn?.querySelector('span');

        updateFormButtonStyle(form);

        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            const action = form.dataset.action;
            const id = form.dataset.productId;
            const name = form.dataset.name;
            const price = form.dataset.price;
            const rowId = form.dataset.rowId;

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

                if (!response.ok) throw new Error("Request failed");

                const result = await response.json();

                form.dataset.action = action === 'add' ? 'remove' : 'add';
                form.dataset.rowId = action === 'add' ? (result.id ?? '') : '';
                updateFormButtonStyle(form);
                showToast(action === 'add' ? 'Added to Wishlist' : 'Removed from Wishlist');
                updateWishlistCount(result.wishlistCount);
            } catch (err) {
                console.error(err);
                showToast('Something went wrong', true);
            }
        });
    });

    document.querySelectorAll('.js-wishlist-toggle').forEach(button => {
        updateButtonStyle(button);

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

                if (!response.ok) throw new Error("Request failed");

                const result = await response.json();

                this.dataset.action = action === 'add' ? 'remove' : 'add';
                this.dataset.rowId = action === 'add' ? (result.id ?? '') : '';
                this.title = action === 'add' ? 'Remove from Wishlist' : 'Add to Wishlist';
                updateButtonStyle(this);
                showToast(action === 'add' ? 'Added to Wishlist' : 'Removed from Wishlist');
                updateWishlistCount(result.wishlistCount);
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

    function updateWishlistCount(count) {
        const countSpan = document.querySelector('#wishlist-count');
        if (countSpan && count !== undefined) {
            countSpan.textContent = count;
            countSpan.style.display = count > 0 ? 'inline-block' : 'none';
        }
    }

    function updateButtonStyle(button) {
        const isActive = button.dataset.action === 'remove';
        button.classList.toggle('filled', isActive);
    }

    function updateFormButtonStyle(form) {
        const btn = form.querySelector('.add-to-wishlist');
        const span = btn?.querySelector('span');
        const isActive = form.dataset.action === 'remove';

        btn?.classList.toggle('filled-heart', isActive);
        if (span) span.textContent = isActive ? 'Remove from Wishlist' : 'Add to Wishlist';
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const token = document.querySelector('meta[name="csrf-token"]')?.content;

  // Fixed quantity control with proper event handling
  document.querySelectorAll('.qty-control__increase, .qty-control__reduce').forEach(button => {
    button.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopImmediatePropagation(); // This prevents multiple handlers from executing
      
      const container = this.closest('.qty-control');
      const input = container.querySelector('.qty-control__number');
      let currentValue = parseInt(input.value) || 1;
      
      if (this.classList.contains('qty-control__increase')) {
        input.value = currentValue + 1;
      } 
      else if (this.classList.contains('qty-control__reduce') && currentValue > 1) {
        input.value = currentValue - 1;
      }
      
      // Manually trigger input event in case other code listens for it
      input.dispatchEvent(new Event('input', { bubbles: true }));
    }, { once: false, capture: true }); // Important options
  });

  // Add to cart button click handler
  document.querySelectorAll('.js-cart-toggle').forEach(button => {
    button.addEventListener('click', async function() {
      const id = this.dataset.productId;
      const name = this.dataset.name;
      const price = this.dataset.price;
      const action = this.dataset.action;
      const rowId = this.dataset.rowId;
      const addRoute = this.dataset.addRoute;

      const container = this.closest('.product-single__addtocart');
      const qtyInput = container?.querySelector('.qty-control__number');
      const quantity = qtyInput ? parseInt(qtyInput.value) || 1 : 1;

      const route = action === 'add' ? addRoute : `/cart/remove/${rowId}`;
      const method = action === 'add' ? 'POST' : 'DELETE';

      const body = action === 'add' 
        ? JSON.stringify({ id, name, price, quantity }) 
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

        if (!response.ok) throw new Error("Request failed");

        const result = await response.json();

        // Update button state
        this.dataset.action = action === 'add' ? 'remove' : 'add';
        this.dataset.rowId = action === 'add' ? (result.id ?? '') : '';
        this.title = action === 'add' ? 'Remove from Cart' : 'Add to Cart';
        this.textContent = action === 'add' ? 'Remove from Cart' : 'Add to Cart';
        this.classList.toggle('filled', action === 'add');

        showToast(action === 'add' ? 'Added to Cart' : 'Removed from Cart');

        // Update cart count
        const countSpan = document.querySelector('#cart-count');
        if (countSpan) {
          countSpan.textContent = result.cartCount;
          countSpan.style.display = result.cartCount > 0 ? 'inline-block' : 'none';
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

@endpush