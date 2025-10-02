@extends('layouts.app')
@section('title', 'Sami Store | Product Details')
@section('content')
<style>
  .filled-heart{
    color: #4062B1;
  }

  /* Variants Styles */
  .product-single__variants {
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
    margin-bottom: 20px;
    border: 2px solid #e9ecef;
  }

  .variant-label {
    font-size: 15px;
    color: #333;
    font-weight: 600;
  }

  .variant-options {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
  }

  .variant-option {
    cursor: pointer;
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }

  .variant-option input[type="radio"] {
    position: absolute;
    opacity: 0;
    pointer-events: none;
  }

  /* Color Options */
  .color-option {
    flex-direction: column;
    text-align: center;
    gap: 6px;
  }

  .color-swatch {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 3px solid #e0e0e0;
    display: block;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }

  .color-option:hover .color-swatch {
    transform: scale(1.1);
  }

  .color-option input:checked ~ .color-swatch {
    border-color: #4062B1;
    box-shadow: 0 0 0 3px rgba(64, 98, 177, 0.2);
    transform: scale(1.05);
  }

  .color-name {
    font-size: 12px;
    color: #666;
    font-weight: 500;
  }

  /* Text Options */
  .text-option .option-text {
    padding: 10px 20px;
    border: 2px solid #e0e0e0;
    border-radius: 6px;
    transition: all 0.3s ease;
    display: block;
    min-width: 60px;
    text-align: center;
    font-weight: 500;
    background: white;
  }

  .text-option:hover .option-text {
    border-color: #4062B1;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  }

  .text-option input:checked ~ .option-text {
    border-color: #4062B1;
    background-color: #4062B1;
    color: white;
  }

  /* Variant Info */
  .variant-info {
    padding: 15px;
    border-radius: 8px;
    background: #e7f3ff;
    border: 1px solid #4062B1;
    animation: slideIn 0.3s ease;
  }

  @keyframes slideIn {
    from {
      opacity: 0;
      transform: translateY(-10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  #variant-price {
    font-weight: 700;
    color: #4062B1 !important;
  }

  .variant-required-notice {
    background: #fff3cd;
    border: 1px solid #ffc107;
    padding: 12px;
    border-radius: 6px;
    margin-top: 10px;
    display: none;
  }

  .variant-required-notice.show {
    display: block;
    animation: shake 0.5s;
  }

  @keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
  }

  /* Responsive */
  @media (max-width: 576px) {
    .color-swatch {
      width: 40px;
      height: 40px;
    }
    
    .text-option .option-text {
      padding: 8px 15px;
      font-size: 14px;
    }
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
                <div class="swiper-wrapper" id="mainImageSwiper">
                  <div class="swiper-slide product-single__image-item">
                    <img loading="lazy" class="h-auto" src="{{ asset('uploads/products') }}/{{ $product->image }}" width="674" height="674" alt="" />
                    <a data-fancybox="gallery" href="{{ asset('uploads/products') }}/{{ $product->image }}" data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom">
                      <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_zoom" />
                      </svg>
                    </a>
                  </div>
                  @foreach ( explode(',',$product->images) as $gimg )
                  <div class="swiper-slide product-single__image-item">
                    <img loading="lazy" class="h-auto" src="{{ asset('uploads/products') }}/{{ $gimg }}" width="674" height="674" alt="" />
                    <a data-fancybox="gallery" href="{{ asset('uploads/products') }}/{{ $gimg }}" data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom">
                      <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_zoom" />
                      </svg>
                    </a>
                  </div>
                  @endforeach
                </div>
                <div class="swiper-button-prev"><svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_prev_sm" />
                  </svg></div>
                <div class="swiper-button-next"><svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_next_sm" />
                  </svg></div>
              </div>
            </div>
            <div class="product-single__thumbnail">
              <div class="swiper-container">
                <div class="swiper-wrapper" id="thumbImageSwiper">
                  <div class="swiper-slide product-single__image-item"><img loading="lazy" class="h-auto" src="{{ asset('uploads/products') }}/{{ $product->image }}" width="104" height="104" alt="" /></div>
                @foreach ( explode(',',$product->images) as $gimg )
                  <div class="swiper-slide product-single__image-item"><img loading="lazy" class="h-auto" src="{{ asset('uploads/products') }}/{{ $gimg }}" width="104" height="104" alt="" /></div>
                @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-5">
          <div class="d-flex justify-content-between mb-4 pb-md-2">
            <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
              <a href="" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
              <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
              <a href="" class="menu-link menu-link_us-s text-uppercase fw-medium">Shop</a>
            </div>

            <div class="product-single__prev-next d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
              <a href="#" class="text-uppercase fw-medium"><svg width="10" height="10" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_prev_md" />
                </svg><span class="menu-link menu-link_us-s">Prev</span></a>
              <a href="#" class="text-uppercase fw-medium"><span class="menu-link menu-link_us-s">Next</span><svg width="10" height="10" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_next_md" />
                </svg></a>
            </div>
          </div>

          <h1 class="product-single__name">{{$product->name}}</h1>
          
          <div class="product-single__rating">
            <div class="reviews-group d-flex">
              @for($i = 0; $i < 5; $i++)
              <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                <use href="#icon_star" />
              </svg>
              @endfor
            </div>
            <span class="reviews-note text-lowercase text-secondary ms-1">8k+ reviews</span>
          </div>

          <div class="product-single__price">
            <span class="current-price" id="displayPrice">
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

          {{-- Product Variants Section --}}
          @if($product->variants->count() > 0)
          <div class="product-single__variants mb-4">
            <h6 class="mb-3">Select Options:</h6>
            
            @php
                $groupedAttributes = [];
                foreach($product->variants as $variant) {
                    foreach($variant->attributeValues as $attrValue) {
                        $attrName = $attrValue->attribute->name;
                        if (!isset($groupedAttributes[$attrName])) {
                            $groupedAttributes[$attrName] = [
                                'type' => $attrValue->attribute->type,
                                'values' => []
                            ];
                        }
                        $valueExists = false;
                        foreach($groupedAttributes[$attrName]['values'] as $existing) {
                            if ($existing['id'] == $attrValue->id) {
                                $valueExists = true;
                                break;
                            }
                        }
                        if (!$valueExists) {
                            $groupedAttributes[$attrName]['values'][] = [
                                'id' => $attrValue->id,
                                'value' => $attrValue->value,
                                'color_code' => $attrValue->color_code
                            ];
                        }
                    }
                }
            @endphp

            @foreach($groupedAttributes as $attrName => $attrData)
            <div class="variant-group mb-3">
                <label class="variant-label d-block mb-2">{{ $attrName }}:</label>
                <div class="variant-options">
                    @foreach($attrData['values'] as $value)
                        @if($attrData['type'] === 'color' && $value['color_code'])
                            <label class="variant-option color-option">
                                <input type="radio" 
                                       name="attribute_{{ $attrName }}" 
                                       value="{{ $value['id'] }}"
                                       data-attr-name="{{ $attrName }}"
                                       class="variant-selector"
                                       required>
                                <span class="color-swatch" 
                                      style="background-color: {{ $value['color_code'] }}"
                                      title="{{ $value['value'] }}"></span>
                                <span class="color-name">{{ $value['value'] }}</span>
                            </label>
                        @else
                            <label class="variant-option text-option">
                                <input type="radio" 
                                       name="attribute_{{ $attrName }}" 
                                       value="{{ $value['id'] }}"
                                       data-attr-name="{{ $attrName }}"
                                       class="variant-selector"
                                       required>
                                <span class="option-text">{{ $value['value'] }}</span>
                            </label>
                        @endif
                    @endforeach
                </div>
            </div>
            @endforeach

            <input type="hidden" id="selected-variant-id" name="variant_id">
            
            <div class="variant-info" style="display:none;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>SKU:</strong> <span id="variant-sku"></span><br>
                        <strong>Stock:</strong> <span id="variant-stock"></span> available
                    </div>
                    <div class="text-end">
                        <strong>Price:</strong> <span id="variant-price" class="fs-5"></span>
                    </div>
                </div>
            </div>

            <div class="variant-required-notice">
              <strong>⚠️ Please select all options before adding to cart</strong>
            </div>
          </div>
          @endif

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

           @if (auth()->check())
              <button
                  type="button"
                  class="btn js-cart-toggle {{ $cartItem ? 'btn-danger filled' : 'btn-primary' }}"
                  data-product-id="{{ $product->id }}"
                  data-name="{{ $product->name }}"
                  data-price="{{ $product->sale_price ?: $product->regular_price }}"
                  data-action="{{ $cartItem ? 'remove' : 'add' }}"
                  data-row-id="{{ $cartItem ? $cartItem->rowId : '' }}"
                  data-add-route="{{ route('cart.add') }}"
                  title="{{ $cartItem ? 'Remove from Cart' : 'Add to Cart' }}"
              >
                  {{ $cartItem ? 'Remove from Cart' : 'Add to Cart' }}
              </button>
           @else
              <a href="{{ route('login') }}"
                 class="btn btn-primary"
                 title="Please login to add to cart"
              >
                  Add To Cart
              </a>
           @endif
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
            </share-button>
          </div>

          <div class="product-single__meta-info">
            <div class="meta-item">
              <label>SKU:</label>
              <span id="display-sku">{{$product->SKU}}</span>
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

      {{-- Rest of the page (tabs, reviews, etc.) --}}
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
          <div class="tab-pane fade show active" id="tab-description" role="tabpanel" aria-labelledby="tab-description-tab">
            <div class="product-single__description">
                {{$product->description}}
            </div>
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
            </div>
          </div>
          <div class="tab-pane fade" id="tab-reviews" role="tabpanel" aria-labelledby="tab-reviews-tab">
            <h2 class="product-single__reviews-title">Reviews</h2>
            {{-- Reviews content --}}
          </div>
        </div>
      </div>
    </section>

    {{-- Related Products Section (same as before) --}}
    <section class="products-carousel container">
      <h2 class="h3 text-uppercase mb-4 pb-xl-2 mb-xl-4">Related <strong>Products</strong></h2>
      {{-- Your existing related products code --}}
    </section>
</main>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const token = document.querySelector('meta[name="csrf-token"]')?.content;
    const hasVariants = {{ $product->variants->count() > 0 ? 'true' : 'false' }};

    // Variants data
    const variants = {!! json_encode(
        $product->variants->map(function($v) {
            return [
                'id' => $v->id,
                'sku' => $v->sku,
                'quantity' => $v->quantity,
                'price' => $v->price,
                'images' => $v->images ? explode(',', $v->images) : [],
                'attribute_ids' => $v->attributeValues->pluck('id')->toArray(),
            ];
        })->values()->toArray(),
        JSON_UNESCAPED_UNICODE
    ) !!};

    const selectors = document.querySelectorAll('.variant-selector');
    const variantInfo = document.querySelector('.variant-info');
    const variantIdInput = document.getElementById('selected-variant-id');
    const addToCartBtn = document.querySelector('.js-cart-toggle');
    const requiredNotice = document.querySelector('.variant-required-notice');

    // حفظ الصور الأصلية للمنتج
    const originalMainImages = document.getElementById('mainImageSwiper')?.innerHTML;
    const originalThumbImages = document.getElementById('thumbImageSwiper')?.innerHTML;

    // ==================== Auto-select first variant ====================
    if (hasVariants && variants.length > 0) {
        const firstVariant = variants[0];
        
        // تحديد أول option لكل attribute
        firstVariant.attribute_ids.forEach(attrId => {
            const radio = document.querySelector(`.variant-selector[value="${attrId}"]`);
            if (radio) {
                radio.checked = true;
            }
        });
        
        // تحديث الـ variant
        setTimeout(() => updateVariant(), 100);
    }

    // ==================== Variants ====================
    function updateVariant() {
        const selected = {};
        selectors.forEach(input => {
            if (input.checked) {
                selected[input.dataset.attrName] = parseInt(input.value);
            }
        });

        const selectedIds = Object.values(selected);

        const matchedVariant = variants.find(v => {
            return selectedIds.every(id => v.attribute_ids.includes(id)) &&
                   v.attribute_ids.length === selectedIds.length;
        });

        if (matchedVariant) {
            variantIdInput.value = matchedVariant.id;
            document.getElementById('variant-sku').textContent = matchedVariant.sku;
            document.getElementById('variant-stock').textContent = matchedVariant.quantity;
            document.getElementById('variant-price').textContent = '$' + matchedVariant.price;
            document.getElementById('display-sku').textContent = matchedVariant.sku;
            document.getElementById('displayPrice').innerHTML = '<span class="current-price">$' + matchedVariant.price + '</span>';

            variantInfo.style.display = 'block';

            if (addToCartBtn) {
                addToCartBtn.disabled = false;
                addToCartBtn.style.opacity = '1';
                addToCartBtn.dataset.price = matchedVariant.price;
            }

            // تحديث الصور فقط إذا كان الـ variant له صور خاصة
            if (matchedVariant.images.length > 0) {
                updateProductImages(matchedVariant.images);
            }
        } else {
            variantInfo.style.display = 'none';
            variantIdInput.value = '';

            if (addToCartBtn) {
                addToCartBtn.disabled = true;
                addToCartBtn.style.opacity = '0.6';
            }

            // إرجاع الصور الأصلية إذا لم يتم اختيار variant كامل
            if (originalMainImages && originalThumbImages) {
                restoreOriginalImages();
            }
        }
    }

    function updateProductImages(images) {
        if (!images || images.length === 0) return;
        
        const mainSwiper = document.getElementById('mainImageSwiper');
        const thumbSwiper = document.getElementById('thumbImageSwiper');
        
        if (!mainSwiper || !thumbSwiper) return;
        
        let mainHtml = '';
        let thumbHtml = '';
        
        images.forEach(img => {
            const trimmedImg = img.trim();
            const imgPath = '{{ asset("uploads/products") }}/' + trimmedImg;
            
            mainHtml += `
                <div class="swiper-slide product-single__image-item">
                    <img loading="lazy" class="h-auto" src="${imgPath}" width="674" height="674" alt="" />
                    <a data-fancybox="gallery" href="${imgPath}" data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_zoom" />
                        </svg>
                    </a>
                </div>
            `;
            
            thumbHtml += `
                <div class="swiper-slide product-single__image-item">
                    <img loading="lazy" class="h-auto" src="${imgPath}" width="104" height="104" alt="" />
                </div>
            `;
        });
        
        mainSwiper.innerHTML = mainHtml;
        thumbSwiper.innerHTML = thumbHtml;
        
        // إعادة تهيئة Swiper
        reinitializeSwiper();
    }

    function restoreOriginalImages() {
        const mainSwiper = document.getElementById('mainImageSwiper');
        const thumbSwiper = document.getElementById('thumbImageSwiper');
        
        if (mainSwiper && thumbSwiper && originalMainImages && originalThumbImages) {
            mainSwiper.innerHTML = originalMainImages;
            thumbSwiper.innerHTML = originalThumbImages;
            reinitializeSwiper();
        }
    }

    function reinitializeSwiper() {
        if (typeof Swiper === 'undefined') return;
        
        // تدمير الـ Swiper القديم
        const mainSwiperContainer = document.querySelector('.product-single__image .swiper-container');
        const thumbSwiperContainer = document.querySelector('.product-single__thumbnail .swiper-container');
        
        if (mainSwiperContainer && mainSwiperContainer.swiper) {
            mainSwiperContainer.swiper.destroy(true, true);
        }
        if (thumbSwiperContainer && thumbSwiperContainer.swiper) {
            thumbSwiperContainer.swiper.destroy(true, true);
        }
        
        // إعادة التهيئة
        setTimeout(() => {
            const thumbSwiper = new Swiper('.product-single__thumbnail .swiper-container', {
                direction: 'vertical',
                spaceBetween: 10,
                slidesPerView: 4,
                freeMode: true,
                watchSlidesProgress: true,
            });
            
            new Swiper('.product-single__image .swiper-container', {
                spaceBetween: 10,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                thumbs: {
                    swiper: thumbSwiper,
                },
            });
        }, 100);
    }

    selectors.forEach(input => {
        input.addEventListener('change', updateVariant);
    });

    // ==================== Quantity controls ====================
    document.querySelectorAll('.qty-control__increase, .qty-control__reduce').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            const container = this.closest('.qty-control');
            const input = container.querySelector('.qty-control__number');
            let currentValue = parseInt(input.value) || 1;

            if (this.classList.contains('qty-control__increase')) {
                input.value = currentValue + 1;
            } 
            else if (this.classList.contains('qty-control__reduce') && currentValue > 1) {
                input.value = currentValue - 1;
            }

            input.dispatchEvent(new Event('input', { bubbles: true }));
        }, { once: false, capture: true });
    });

    // ==================== Cart handler ====================
    document.querySelectorAll('.js-cart-toggle').forEach(button => {
        button.addEventListener('click', async function() {
            if (hasVariants && !variantIdInput.value) {
                requiredNotice.classList.add('show');
                setTimeout(() => requiredNotice.classList.remove('show'), 3000);
                return;
            }

            const id = this.dataset.productId;
            const name = this.dataset.name;
            const price = this.dataset.price;
            const action = this.dataset.action;
            const rowId = this.dataset.rowId;
            const addRoute = this.dataset.addRoute;
            const variantId = variantIdInput.value;

            const container = this.closest('.product-single__addtocart');
            const qtyInput = container?.querySelector('.qty-control__number');
            const quantity = qtyInput ? parseInt(qtyInput.value) || 1 : 1;

            const route = action === 'add' ? addRoute : `/cart/remove/${rowId}`;
            const method = action === 'add' ? 'POST' : 'DELETE';

            const body = action === 'add' 
                ? JSON.stringify({ id, name, price, quantity, variant_id: variantId }) 
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
                this.title = action === 'add' ? 'Remove from Cart' : 'Add to Cart';
                this.textContent = action === 'add' ? 'Remove from Cart' : 'Add to Cart';
                this.classList.toggle('filled', action === 'add');

                showToast(action === 'add' ? 'Added to Cart' : 'Removed from Cart');
                updateCartCount(result.cartCount);
            } catch (err) {
                console.error(err);
                showToast('Network error', true);
            }
        });
    });

    // ==================== Wishlist handler ====================
    document.querySelectorAll('.js-wishlist-form').forEach(form => {
        const btn = form.querySelector('.add-to-wishlist');
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

    // ==================== Helpers ====================
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

    function updateCartCount(count) {
        const countSpan = document.querySelector('#cart-count');
        if (countSpan && count !== undefined) {
            countSpan.textContent = count;
            countSpan.style.display = count > 0 ? 'inline-block' : 'none';
        }
    }

    function updateWishlistCount(count) {
        const countSpan = document.querySelector('#wishlist-count');
        if (countSpan && count !== undefined) {
            countSpan.textContent = count;
            countSpan.style.display = count > 0 ? 'inline-block' : 'none';
        }
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
@endpush
