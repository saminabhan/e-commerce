@extends('layouts.app')

@section('content')
<main class="pt-90">
  <section class="shop-checkout container">
    <h2 class="page-title">Shipping and Checkout</h2>
    
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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
      <a href="#" class="checkout-steps__item">
        <span class="checkout-steps__item-number">03</span>
        <span class="checkout-steps__item-title">
          <span>Confirmation</span>
          <em>Review And Submit Your Order</em>
        </span>
      </a>
    </div>

    <form method="POST" action="{{ route('checkout.place') }}" id="checkout-form">
      @csrf

      <div class="checkout-form">
        <div class="billing-info__wrapper">
          <div class="row">
            <div class="col-12"><h4>SHIPPING DETAILS</h4></div>
          </div>

          {{-- إذا عند المستخدم عناوين محفوظة، عرض Dropdown لاختيار العنوان --}}
          @if($addresses->count() > 0)
          <div class="row mb-4">
            <div class="col-md-12">
              <label for="selected_address_id" class="form-label">Select Shipping Address</label>
              <select name="selected_address_id" id="selected_address_id" class="form-select">
                <option value="">-- Choose an Address --</option>
                @foreach($addresses as $address)
                  <option value="{{ $address->id }}" {{ old('selected_address_id') == $address->id ? 'selected' : '' }}>
                    {{ $address->name }}, {{ $address->address }}, {{ $address->city }}, {{ $address->state }}
                  </option>
                @endforeach
                <option value="new" {{ old('selected_address_id') == 'new' ? 'selected' : '' }}>Add New Address</option>
              </select>
              @error('selected_address_id')
                  <div class="text-danger mt-1">{{ $message }}</div>
              @enderror
            </div>
          </div>
          @endif

          {{-- فورم إدخال عنوان جديد (مخفي إفتراضياً إذا يوجد عناوين) --}}
          <div id="new-address-form" style="{{ ($addresses->count() > 0 && old('selected_address_id') != 'new') ? 'display:none;' : '' }}">
            <div class="row mt-5">
              <div class="col-md-6">
                <div class="form-floating my-3">
                  <input type="text" class="form-control @error('name') is-invalid @enderror" 
                         name="name" value="{{ old('name') }}" required>
                  <label>Full Name *</label>
                  @error('name')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating my-3">
                  <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                         name="phone" value="{{ old('phone') }}" required>
                  <label>Phone Number *</label>
                  @error('phone')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-floating my-3">
                  <input type="text" class="form-control @error('zip') is-invalid @enderror" 
                         name="zip" value="{{ old('zip') }}" required>
                  <label>Pincode *</label>
                  @error('zip')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating my-3">
                  <input type="text" class="form-control @error('state') is-invalid @enderror" 
                         name="state" value="{{ old('state') }}" required>
                  <label>State *</label>
                  @error('state')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating my-3">
                  <input type="text" class="form-control @error('city') is-invalid @enderror" 
                         name="city" value="{{ old('city') }}" required>
                  <label>Town / City *</label>
                  @error('city')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating my-3">
                  <input type="text" class="form-control @error('address') is-invalid @enderror" 
                         name="address" value="{{ old('address') }}" required>
                  <label>House no, Building Name *</label>
                  @error('address')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating my-3">
                  <input type="text" class="form-control @error('locality') is-invalid @enderror" 
                         name="locality" value="{{ old('locality') }}" required>
                  <label>Road Name, Area, Colony *</label>
                  @error('locality')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-floating my-3">
                  <input type="text" class="form-control @error('landmark') is-invalid @enderror" 
                         name="landmark" value="{{ old('landmark') }}">
                  <label>Landmark</label>
                  @error('landmark')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="checkout__totals-wrapper">
          <div class="sticky-content">
            <div class="checkout__totals">
              <h3>Your Order</h3>
              <table class="checkout-cart-items">
                <thead>
                  <tr>
                    <th>PRODUCT</th>
                    <th align="right">SUBTOTAL</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($items as $item)
                    <tr>
                      <td>
                        <div class="cart-item-details">
                          <strong>{{ $item->product_name }}</strong>
                          <br>
                          <small>Quantity: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</small>
                        </div>
                      </td>
                      <td align="right">
                        <strong>${{ number_format($item->price * $item->quantity, 2) }}</strong>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>

              <table class="checkout-totals">
                <tbody>
                  <tr>
                    <th>SUBTOTAL</th>
                    <td align="right">${{ number_format($subTotal, 2) }}</td>
                  </tr>
                  <tr>
                    <th>SHIPPING</th>
                    <td align="right">Free</td>
                  </tr>
                  <tr>
                    <th>VAT (15%)</th>
                    <td align="right">${{ number_format($vat, 2) }}</td>
                  </tr>
                  <tr class="total-row">
                    <th><strong>TOTAL</strong></th>
                    <td align="right"><strong>${{ number_format($total, 2) }}</strong></td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="checkout__payment-methods">
              <h4>Payment Method</h4>
              
              <div class="form-check payment-option">
                <input class="form-check-input" type="radio" name="payment_method" 
                       id="payment_method_bank" value="bank_transfer" 
                       {{ old('payment_method', 'bank_transfer') === 'bank_transfer' ? 'checked' : '' }}>
                <label class="form-check-label" for="payment_method_bank">
                  <strong>Direct Bank Transfer</strong>
                  <p class="option-detail">Make your payment directly into our bank account. Please use your Order ID as the payment reference.</p>
                </label>
              </div>

              <div class="form-check payment-option">
                <input class="form-check-input" type="radio" name="payment_method" 
                       id="payment_method_check" value="check_payment"
                       {{ old('payment_method') === 'check_payment' ? 'checked' : '' }}>
                <label class="form-check-label" for="payment_method_check">
                  <strong>Check Payments</strong>
                  <p class="option-detail">Please send a check to our store address. Your order will be processed once we receive your payment.</p>
                </label>
              </div>

              <div class="form-check payment-option">
                <input class="form-check-input" type="radio" name="payment_method" 
                       id="payment_method_cod" value="cash_on_delivery"
                       {{ old('payment_method') === 'cash_on_delivery' ? 'checked' : '' }}>
                <label class="form-check-label" for="payment_method_cod">
                  <strong>Cash on Delivery</strong>
                  <p class="option-detail">Pay with cash upon delivery. Available for orders within the delivery area.</p>
                </label>
              </div>

              <div class="form-check payment-option">
                <input class="form-check-input" type="radio" name="payment_method" 
                       id="payment_method_stripe" value="stripe"
                       {{ old('payment_method') === 'stripe' ? 'checked' : '' }}>
                <label class="form-check-label" for="payment_method_stripe">
                  <strong>Credit / Debit Card (Stripe)</strong>
                  <p class="option-detail">Pay securely using your credit or debit card via Stripe.</p>
                </label>
              </div>

              @error('payment_method')
                  <div class="text-danger mt-2">{{ $message }}</div>
              @enderror
            </div>

            <div class="checkout-actions">
              <button class="btn btn-primary btn-checkout w-100" type="submit" id="place-order-btn">
                <span class="btn-text">PLACE ORDER</span>
                <div class="spinner-border spinner-border-sm ms-2 d-none" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </section>
</main>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('checkout-form');
    const submitBtn = document.getElementById('place-order-btn');
    const btnText = submitBtn.querySelector('.btn-text');
    const spinner = submitBtn.querySelector('.spinner-border');

    form.addEventListener('submit', function(e) {
        if (submitBtn.disabled) {
            e.preventDefault();
            return;
        }

        // التحقق من اختيار عنوان أو إدخال عنوان جديد
        const addressSelect = document.getElementById('selected_address_id');
        if (addressSelect && !addressSelect.value) {
            e.preventDefault();
            alert('Please select an address or add a new one.');
            return;
        }

        // التحقق من طريقة الدفع
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
        if (!paymentMethod) {
            e.preventDefault();
            alert('Please select a payment method.');
            return;
        }

        submitBtn.disabled = true;
        btnText.textContent = 'PROCESSING...';
        spinner.classList.remove('d-none');

        setTimeout(() => {
            if (submitBtn.disabled) {
                submitBtn.disabled = false;
                btnText.textContent = 'PLACE ORDER';
                spinner.classList.add('d-none');
            }
        }, 15000);
    });

    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            document.querySelectorAll('.payment-option').forEach(option => {
                option.classList.remove('active');
            });
            
            this.closest('.payment-option').classList.add('active');
        });
    });

    const checkedMethod = document.querySelector('input[name="payment_method"]:checked');
    if (checkedMethod) {
        checkedMethod.closest('.payment-option').classList.add('active');
    }

    // Show/hide new address form based on dropdown
    const addressSelect = document.getElementById('selected_address_id');
    if (addressSelect) {
        addressSelect.addEventListener('change', function() {
            const newAddressForm = document.getElementById('new-address-form');
            const addressFormInputs = newAddressForm.querySelectorAll('input[required]');
            
            if (this.value === 'new' || !this.value) {
                newAddressForm.style.display = 'block';
                // إضافة الـ required attribute للحقول
                addressFormInputs.forEach(input => {
                    input.setAttribute('required', 'required');
                });
            } else {
                newAddressForm.style.display = 'none';
                // إزالة الـ required attribute من الحقول
                addressFormInputs.forEach(input => {
                    input.removeAttribute('required');
                });
            }
        });

        // تشغيل الحدث عند تحميل الصفحة
        addressSelect.dispatchEvent(new Event('change'));
    }
});
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const addressSelect = document.getElementById('selected_address_id');
    if (!addressSelect) return;

    const newAddressForm = document.getElementById('new-address-form');
    const addressFormInputs = newAddressForm.querySelectorAll('input[required]');

    function toggleNewAddressForm() {
        if (addressSelect.value === 'new') {
            newAddressForm.style.display = 'block';
            addressFormInputs.forEach(input => input.setAttribute('required', 'required'));
        } else {
            newAddressForm.style.display = 'none';
            addressFormInputs.forEach(input => input.removeAttribute('required'));
        }
    }

    addressSelect.addEventListener('change', toggleNewAddressForm);
    toggleNewAddressForm();
});

</script>
@endpush

@endsection
