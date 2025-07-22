@extends('layouts.app')

@section('content')
<main class="pt-90">
    <section class="shop-checkout container">
        <h2 class="page-title">Complete Your Payment</h2>
        
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
                    <span>Payment</span>
                    <em>Complete Your Order</em>
                </span>
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="payment-form-wrapper">
                    <h4>Payment Details</h4>
                    
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form id="payment-form" action="{{ route('payment.process') }}" method="POST">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                        <div class="card-element-wrapper">
                            <label for="card-element">Credit or Debit Card</label>
                            <div id="card-element" class="form-control" style="height: 50px; padding: 15px;">
                                <!-- Stripe Elements will create form elements here -->
                            </div>
                            <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                        </div>

                        <button id="submit-payment" class="btn btn-primary btn-lg mt-4 w-100" type="submit" disabled>
                            <span id="button-text">Pay ${{ number_format($order->total, 2) }}</span>
                            <div id="spinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="order-summary">
                    <h4>Order Summary</h4>
                    <div class="order-details">
                        <div class="order-info">
                            <div class="order-info__item">
                                <label>Order Number</label>
                                <span>#{{ $order->id }}</span>
                            </div>
                            <div class="order-info__item">
                                <label>Subtotal</label>
                                <span>${{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            <div class="order-info__item">
                                <label>VAT (15%)</label>
                                <span>${{ number_format($order->vat, 2) }}</span>
                            </div>
                            <div class="order-info__item total">
                                <label><strong>Total</strong></label>
                                <span><strong>${{ number_format($order->total, 2) }}</strong></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
.payment-form-wrapper {
    background: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.card-element-wrapper {
    margin-bottom: 20px;
}

.card-element-wrapper label {
    font-weight: 600;
    margin-bottom: 8px;
    display: block;
}

#card-element {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 12px;
    background: #fff;
}

#card-element.StripeElement--focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

.order-summary {
    background: #f8f9fa;
    padding: 25px;
    border-radius: 8px;
    position: sticky;
    top: 20px;
}

.order-info__item {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #eee;
}

.order-info__item.total {
    border-bottom: none;
    margin-top: 10px;
    padding-top: 15px;
    border-top: 2px solid #4062B1;
}

#submit-payment:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Stripe
    const stripe = Stripe("{{ config('services.stripe.key') }}");
    const elements = stripe.elements();

    // Create card element with styling
    const cardElement = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#424770',
                '::placeholder': {
                    color: '#aab7c4',
                },
            },
        },
    });

    // Mount card element
    cardElement.mount('#card-element');

    // Handle real-time validation errors from the card Element
    const cardErrors = document.getElementById('card-errors');
    const submitButton = document.getElementById('submit-payment');
    
    cardElement.on('change', function(event) {
        if (event.error) {
            cardErrors.textContent = event.error.message;
            submitButton.disabled = true;
        } else {
            cardErrors.textContent = '';
            submitButton.disabled = false;
        }
    });

    // Handle form submission
    const form = document.getElementById('payment-form');
    const buttonText = document.getElementById('button-text');
    const spinner = document.getElementById('spinner');

    form.addEventListener('submit', async function(event) {
        event.preventDefault();

        // Disable button and show loading state
        submitButton.disabled = true;
        buttonText.style.display = 'none';
        spinner.classList.remove('d-none');

        try {
            // Create token
            const {token, error} = await stripe.createToken(cardElement);

            if (error) {
                // Show error to customer
                cardErrors.textContent = error.message;
                
                // Re-enable button
                submitButton.disabled = false;
                buttonText.style.display = 'inline';
                spinner.classList.add('d-none');
            } else {
                // Token was created successfully
                console.log('Token created:', token);
                
                // Create hidden input with token
                const hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);

                // Submit form
                form.submit();
            }
        } catch (err) {
            console.error('Error creating token:', err);
            cardErrors.textContent = 'An unexpected error occurred. Please try again.';
            
            // Re-enable button
            submitButton.disabled = false;
            buttonText.style.display = 'inline';
            spinner.classList.add('d-none');
        }
    });
});
</script>
@endpush
@endsection