@extends('layouts.app')
@section('title', 'Sami Store | Cart')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
        <h2 class="page-title">Cart</h2>
        <div class="checkout-steps">
            <a href="javascript:void(0)" class="checkout-steps__item active">
                <span class="checkout-steps__item-number">01</span>
                <span class="checkout-steps__item-title">
                    <span>Shopping Bag</span>
                    <em>Manage Your Items List</em>
                </span>
            </a>
            <a href="javascript:void(0)" class="checkout-steps__item">
                <span class="checkout-steps__item-number">02</span>
                <span class="checkout-steps__item-title">
                    <span>Shipping and Checkout</span>
                    <em>Checkout Your Items List</em>
                </span>
            </a>
            <a href="javascript:void(0)" class="checkout-steps__item">
                <span class="checkout-steps__item-number">03</span>
                <span class="checkout-steps__item-title">
                    <span>Confirmation</span>
                    <em>Review And Submit Your Order</em>
                </span>
            </a>
        </div>

        <div class="shopping-cart">
            @if ($items->count() > 0)
                <div class="cart-table__wrapper">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th></th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $subTotal = 0; @endphp
                            @foreach ($items as $item)
                                @php
                                    $product = \App\Models\Product::find($item->product_id);
                                    $itemTotal = $item->price * $item->quantity;
                                    $subTotal += $itemTotal;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="shopping-cart__product-item">
                                            <img loading="lazy" src="{{ asset('uploads/products/' . $product->image) }}" width="120" height="120" alt="{{ $item->product_name }}" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="shopping-cart__product-item__detail">
                                            <h4>{{ $item->product_name }}</h4>
                                            <ul class="shopping-cart__product-item__options">
                                                <li>Color: Yellow</li>
                                                <li>Size: L</li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td><span class="shopping-cart__product-price">${{ number_format($item->price, 2) }}</span></td>
                                    <td>
                                        <div class="qty-control position-relative">
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="qty-control__number text-center">
                                            <form method="POST" action="{{ route('cart.qty.decrease', ['rowId' => $item->id]) }}"
>
                                                @csrf @method('PUT')
                                                <div class="qty-control__reduce">-</div>
                                            </form>
                                            <form method="POST" action="{{ route('cart.qty.increase', ['rowId' => $item->id]) }}">
                                                @csrf @method('PUT')
                                                <div class="qty-control__increase">+</div>
                                            </form>
                                        </div>
                                    </td>
                                    <td><span class="shopping-cart__subtotal">${{ number_format($itemTotal, 2) }}</span></td>
                                    <td>
                                        <form method="POST" action="{{ route('cart.remove', ['rowId' => $item->id]) }}">

                                            @csrf @method('DELETE')
                                            <a href="javascript:void(0)" class="remove-cart">
                                                <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                                    <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                                </svg>
                                            </a>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- ... باقي الهيكل كما هو --}}
<div class="cart-table-footer">
   <form method="POST" action="{{ route('cart.applyCoupon') }}" class="position-relative bg-body">
    @csrf
<input class="form-control @error('coupon_code') is-invalid @enderror" 
       type="text" 
       name="coupon_code" 
       placeholder="Coupon Code" 
       value="{{ old('coupon_code', session('coupon')['code'] ?? '') }}">
    
    <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4" 
           type="submit" 
           value="APPLY COUPON">
    
    @error('coupon_code')
        <div class="invalid-feedback d-block mt-1">
            {{ $message }}
        </div>
    @enderror
</form>


    @if(session()->has('coupon'))
        <form method="POST" action="{{ route('cart.removeCoupon') }}" class="mt-2">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm">Remove Coupon</button>
        </form>
    @endif

    <form method="POST" action="{{ route('cart.empty') }}">
        @csrf
        @method('DELETE')
        <button class="btn btn-light mt-2" type="submit">CLEAR CART</button>
    </form>
</div>

                </div>

                @php
    $vat = ($subTotal - ($discount ?? 0)) * 0.15;
    $total = ($subTotal - ($discount ?? 0)) + $vat;
@endphp

<div class="shopping-cart__totals-wrapper">
    <div class="sticky-content">
        <div class="shopping-cart__totals">
            <h3>Cart Totals</h3>
            <table class="cart-totals">
                <tbody>
                    <tr>
                        <th>Subtotal</th>
                        <td>${{ number_format($subTotal, 2) }}</td>
                    </tr>

                    @if(!empty($coupon))
                        <tr>
                            <th>Coupon ({{ $coupon->code }})</th>
                            <td>- ${{ number_format($discount, 2) }}</td>
                        </tr>
                    @endif

                    <tr>
                        <th>Shipping</th>
                        <td>Free</td>
                    </tr>
                    <tr>
                        <th>VAT</th>
                        <td>${{ number_format($vat, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td>${{ number_format($total, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mobile_fixed-btn_wrapper">
            <div class="button-wrapper container">
                <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-checkout">PROCEED TO CHECKOUT</a>
            </div>
        </div>
    </div>
</div>

            @else
                <div class="row">
                    <div class="col-md-12 text-center pt-5 pb-5">
                        <p>No item found in your cart</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-info">Shop Now</a>
                    </div>
                </div>
            @endif
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
    $(function () {
        $(".qty-control__reduce").on("click", function () {
            $(this).closest('form').submit();
        });

        $(".qty-control__increase").on("click", function () {
            $(this).closest('form').submit();
        });

        $(".remove-cart").on("click", function () {
            $(this).closest('form').submit();
        });
    });
</script>
@endpush
