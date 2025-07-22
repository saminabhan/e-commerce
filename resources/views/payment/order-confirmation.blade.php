@extends('layouts.app')

@section('content')
<main class="pt-90">
  <section class="shop-checkout container">
    <h2 class="page-title">Order Received</h2>
    <div class="checkout-steps">
      <a href="{{ route('cart.index') }}" class="checkout-steps__item active">
        <span class="checkout-steps__item-number">01</span>
        <span class="checkout-steps__item-title">
          <span>Shopping Bag</span>
          <em>Manage Your Items List</em>
        </span>
      </a>
      <a href="{{ route('checkout.index') }}" class="checkout-steps__item active">
        <span class="checkout-steps__item-number">02</span>
        <span class="checkout-steps__item-title">
          <span>Shipping and Checkout</span>
          <em>Checkout Your Items List</em>
        </span>
      </a>
      <a href="#" class="checkout-steps__item active">
        <span class="checkout-steps__item-number">03</span>
        <span class="checkout-steps__item-title">
          <span>Confirmation</span>
          <em>Review And Submit Your Order</em>
        </span>
      </a>
    </div>

    <div class="order-complete">
      <div class="order-complete__message">
    <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
      <circle cx="40" cy="40" r="40" fill="#4062B1" />
      <path d="M24 42L36 54L58 30" stroke="white" stroke-width="6" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
        <h3>Your order is completed!</h3>
        <p>Thank you. Your order has been received.</p>
      </div>

      <div class="order-info">
        <div class="order-info__item">
          <label>Order Number</label>
          <span>#{{ $order->user_invoice_number }}</span>
        </div>
        <div class="order-info__item">
          <label>Date</label>
          <span>{{ $order->created_at->format('d/m/Y') }}</span>
        </div>
        <div class="order-info__item">
          <label>Total</label>
          <span>${{ number_format($order->total, 2) }}</span>
        </div>
        <div class="order-info__item">
          <label>Payment Method</label>
          <span>{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</span>
        </div>
      </div>

      <div class="checkout__totals-wrapper">
        <div class="checkout__totals">
          <h3>Order Details</h3>
          <table class="checkout-cart-items">
            <thead>
              <tr><th>PRODUCT</th><th>SUBTOTAL</th></tr>
            </thead>
            <tbody>
              @foreach($order->items as $item)
              <tr>
                <td>{{ $item->product_name }} x {{ $item->quantity }}</td>
                <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>

          <table class="checkout-totals">
            <tbody>
              <tr><th>SUBTOTAL</th><td>${{ number_format($order->subtotal, 2) }}</td></tr>
              <tr><th>SHIPPING</th><td>Free shipping</td></tr>
              <tr><th>VAT</th><td>${{ number_format($order->vat, 2) }}</td></tr>
              <tr><th>TOTAL</th><td>${{ number_format($order->total, 2) }}</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
