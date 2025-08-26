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
                  <option value="{{ $address->id }}" 
                          data-lat="{{ $address->latitude ?? '' }}" 
                          data-lng="{{ $address->longitude ?? '' }}"
                          {{ old('selected_address_id') == $address->id ? 'selected' : '' }}>
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

          {{-- فورم إدخال عنوان جديد مع الخريطة --}}
          <div id="new-address-form" style="{{ ($addresses->count() > 0 && old('selected_address_id') != 'new') ? 'display:none;' : '' }}">
            
            {{-- خريطة تحديد الموقع --}}
            <div class="row mt-4">
              <div class="col-12">
                <h5 class="mb-3">Select Your Location on Map</h5>
                <div class="map-container mb-4">
                  <div id="map" style="height: 400px; border-radius: 8px; border: 2px solid #e0e0e0;"></div>
                  <div class="map-controls mt-3">
                    <button type="button" id="detect-location" class="btn btn-outline-primary me-2">
                      <i class="fas fa-crosshairs"></i> Detect My Location
                    </button>
                    <button type="button" id="search-address" class="btn btn-outline-secondary">
                      <i class="fas fa-search"></i> Search Address
                    </button>
                  </div>
                  <div id="address-search" class="mt-3" style="display: none;">
                    <input type="text" id="search-input" class="form-control" placeholder="Enter address to search...">
                  </div>
                  <div id="location-status" class="mt-2"></div>
                </div>
              </div>
            </div>

            {{-- الحقول المخفية للإحداثيات --}}
            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
            
            {{-- حقول العنوان --}}
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

                    @if(session()->has('coupon') && $discount > 0)
                    <tr>
                        <th>DISCOUNT ({{ strtoupper($coupon?->code ?? '') }})</th>
                        <td align="right">- ${{ number_format($discount, 2) }}</td>
                    </tr>
                    @endif

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

{{-- Add Font Awesome for icons --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

{{-- Add custom CSS for map --}}
<style>
.map-container {
    position: relative;
}

#location-status {
    padding: 10px;
    border-radius: 4px;
    font-size: 14px;
}

.status-success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

.status-warning {
    background-color: #fff3cd;
    border: 1px solid #ffeaa7;
    color: #856404;
}

.status-error {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.delivery-zone-info {
    background: #e8f4fd;
    border: 1px solid #bee5eb;
    border-radius: 4px;
    padding: 15px;
    margin-top: 15px;
}

.map-legend {
    position: absolute;
    top: 10px;
    right: 10px;
    background: white;
    padding: 10px;
    border-radius: 4px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    font-size: 12px;
    z-index: 1000;
}

.legend-item {
    display: flex;
    align-items: center;
    margin-bottom: 5px;
}

.legend-color {
    width: 20px;
    height: 20px;
    margin-right: 8px;
    border-radius: 2px;
}
</style>

@push('scripts')
<script>
let map;
let userMarker;
let storeMarker;
let deliveryZoneCircle;
let searchBox;

// إعدادات المتجر والنطاق (يمكنك تغييرها حسب موقع متجرك)
const STORE_LOCATION = {
    lat: 32.2211, // نابلس - يمكنك تغييرها لموقع متجرك
    lng: 35.2544
};
const DELIVERY_RADIUS_KM = 10; // نطاق التوصيل بالكيلومتر
const DELIVERY_RADIUS_METERS = DELIVERY_RADIUS_KM * 1000;

function initMap() {
    // إنشاء الخريطة
    map = new google.maps.Map(document.getElementById('map'), {
        center: STORE_LOCATION,
        zoom: 12,
        mapTypeId: 'roadmap'
    });

    // إضافة علامة المتجر
    storeMarker = new google.maps.Marker({
        position: STORE_LOCATION,
        map: map,
        title: 'Our Store',
        icon: {
            url: 'data:image/svg+xml;base64,' + btoa('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="red" width="30" height="40"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>'),
            scaledSize: new google.maps.Size(30, 40)
        }
    });

    // إضافة دائرة نطاق التوصيل
    deliveryZoneCircle = new google.maps.Circle({
        strokeColor: '#00AA00',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#00AA00',
        fillOpacity: 0.15,
        map: map,
        center: STORE_LOCATION,
        radius: DELIVERY_RADIUS_METERS
    });

    // إضافة معلومات للمتجر
    const storeInfoWindow = new google.maps.InfoWindow({
        content: `
            <div style="padding: 10px;">
                <h6 style="margin: 0 0 5px 0; color: #333;">Our Store</h6>
                <p style="margin: 0; font-size: 12px; color: #666;">Delivery available within ${DELIVERY_RADIUS_KM}km radius</p>
            </div>
        `
    });

    storeMarker.addListener('click', function() {
        storeInfoWindow.open(map, storeMarker);
    });

    // البحث في الخريطة
    const searchInput = document.getElementById('search-input');
    searchBox = new google.maps.places.SearchBox(searchInput);

    searchBox.addListener('places_changed', function() {
        const places = searchBox.getPlaces();
        if (places.length === 0) return;

        const place = places[0];
        if (!place.geometry) return;

        // تحديث موقع المستخدم
        updateUserLocation(place.geometry.location.lat(), place.geometry.location.lng());
        
        // تحديث معلومات العنوان
        updateAddressFields(place);
        
        map.setCenter(place.geometry.location);
        map.setZoom(15);
    });

    // النقر على الخريطة لتحديد الموقع
    map.addListener('click', function(event) {
        updateUserLocation(event.latLng.lat(), event.latLng.lng());
        
        // الحصول على معلومات العنوان من الإحداثيات
        reverseGeocode(event.latLng.lat(), event.latLng.lng());
    });

    // تحميل موقع سابق إذا كان موجود
    const savedLat = document.getElementById('latitude').value;
    const savedLng = document.getElementById('longitude').value;
    
    if (savedLat && savedLng) {
        updateUserLocation(parseFloat(savedLat), parseFloat(savedLng));
    }
}

function updateUserLocation(lat, lng) {
    // إزالة العلامة السابقة
    if (userMarker) {
        userMarker.setMap(null);
    }

    // إضافة علامة جديدة
    userMarker = new google.maps.Marker({
        position: { lat: lat, lng: lng },
        map: map,
        title: 'Your Location',
        draggable: true,
        icon: {
            url: 'data:image/svg+xml;base64,' + btoa('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="blue" width="25" height="35"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>'),
            scaledSize: new google.maps.Size(25, 35)
        }
    });

    // تحديث الحقول المخفية
    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;

    // التحقق من النطاق
    checkDeliveryZone(lat, lng);

    // إضافة إمكانية السحب
    userMarker.addListener('dragend', function(event) {
        const newLat = event.latLng.lat();
        const newLng = event.latLng.lng();
        
        document.getElementById('latitude').value = newLat;
        document.getElementById('longitude').value = newLng;
        
        checkDeliveryZone(newLat, newLng);
        reverseGeocode(newLat, newLng);
    });
}

function checkDeliveryZone(lat, lng) {
    const distance = google.maps.geometry.spherical.computeDistanceBetween(
        new google.maps.LatLng(STORE_LOCATION.lat, STORE_LOCATION.lng),
        new google.maps.LatLng(lat, lng)
    );

    const distanceKm = (distance / 1000).toFixed(2);
    const statusDiv = document.getElementById('location-status');
    
    if (distance <= DELIVERY_RADIUS_METERS) {
        statusDiv.innerHTML = `
            <i class="fas fa-check-circle"></i>
            <strong>Great!</strong> Your location is within our delivery zone (${distanceKm} km from store).
        `;
        statusDiv.className = 'status-success';
        
        // تفعيل زر الطلب
        document.getElementById('place-order-btn').disabled = false;
    } else {
        statusDiv.innerHTML = `
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Sorry!</strong> Your location is outside our delivery zone (${distanceKm} km from store). 
            Maximum delivery distance is ${DELIVERY_RADIUS_KM} km.
        `;
        statusDiv.className = 'status-error';
        
        // تعطيل زر الطلب
        document.getElementById('place-order-btn').disabled = true;
    }
}

function reverseGeocode(lat, lng) {
    const geocoder = new google.maps.Geocoder();
    const latLng = { lat: lat, lng: lng };

    geocoder.geocode({ location: latLng }, function(results, status) {
        if (status === 'OK' && results[0]) {
            updateAddressFields(results[0]);
        }
    });
}

function updateAddressFields(place) {
    const components = place.address_components || [];
    
    let streetNumber = '';
    let route = '';
    let locality = '';
    let city = '';
    let state = '';
    let zip = '';
    
    components.forEach(component => {
        const types = component.types;
        
        if (types.includes('street_number')) {
            streetNumber = component.long_name;
        }
        if (types.includes('route')) {
            route = component.long_name;
        }
        if (types.includes('sublocality') || types.includes('neighborhood')) {
            locality = component.long_name;
        }
        if (types.includes('locality') || types.includes('administrative_area_level_2')) {
            city = component.long_name;
        }
        if (types.includes('administrative_area_level_1')) {
            state = component.long_name;
        }
        if (types.includes('postal_code')) {
            zip = component.long_name;
        }
    });

    // تحديث الحقول
    if (route && streetNumber) {
        document.querySelector('input[name="address"]').value = `${streetNumber} ${route}`;
    }
    if (locality) {
        document.querySelector('input[name="locality"]').value = locality;
    }
    if (city) {
        document.querySelector('input[name="city"]').value = city;
    }
    if (state) {
        document.querySelector('input[name="state"]').value = state;
    }
    if (zip) {
        document.querySelector('input[name="zip"]').value = zip;
    }
}

// تشغيل الأحداث
document.addEventListener('DOMContentLoaded', function() {
    // زر تحديد الموقع الحالي
    document.getElementById('detect-location').addEventListener('click', function() {
        if (navigator.geolocation) {
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Detecting...';
            
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    
                    updateUserLocation(lat, lng);
                    reverseGeocode(lat, lng);
                    
                    map.setCenter({ lat: lat, lng: lng });
                    map.setZoom(15);
                    
                    document.getElementById('detect-location').innerHTML = '<i class="fas fa-crosshairs"></i> Detect My Location';
                },
                function(error) {
                    alert('Error detecting location: ' + error.message);
                    document.getElementById('detect-location').innerHTML = '<i class="fas fa-crosshairs"></i> Detect My Location';
                }
            );
        } else {
            alert('Geolocation is not supported by this browser.');
        }
    });

    // زر البحث
    document.getElementById('search-address').addEventListener('click', function() {
        const searchDiv = document.getElementById('address-search');
        if (searchDiv.style.display === 'none' || !searchDiv.style.display) {
            searchDiv.style.display = 'block';
            document.getElementById('search-input').focus();
        } else {
            searchDiv.style.display = 'none';
        }
    });

    // باقي الأحداث الأصلية...
    const form = document.getElementById('checkout-form');
    const submitBtn = document.getElementById('place-order-btn');
    const btnText = submitBtn.querySelector('.btn-text');
    const spinner = submitBtn.querySelector('.spinner-border');

    form.addEventListener('submit', function(e) {
        if (submitBtn.disabled) {
            e.preventDefault();
            return;
        }

        const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
        if (!paymentMethod) {
            e.preventDefault();
            alert('Please select a payment method.');
            return;
        }

        // التحقق من تحديد الموقع للعناوين الجديدة
        const newAddressForm = document.getElementById('new-address-form');
        const addressSelect = document.getElementById('selected_address_id');
        
        if (newAddressForm.style.display !== 'none' && (!addressSelect || addressSelect.value === 'new' || !addressSelect.value)) {
            const lat = document.getElementById('latitude').value;
            const lng = document.getElementById('longitude').value;
            
            if (!lat || !lng) {
                e.preventDefault();
                alert('Please select your location on the map.');
                return;
            }
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

    // Show/hide new address form
    const addressSelect = document.getElementById('selected_address_id');
    if (addressSelect) {
        addressSelect.addEventListener('change', function() {
            const newAddressForm = document.getElementById('new-address-form');
            const addressFormInputs = newAddressForm.querySelectorAll('input[required]');
            
            if (this.value === 'new' || !this.value) {
                newAddressForm.style.display = 'block';
                addressFormInputs.forEach(input => {
                    input.setAttribute('required', 'required');
                });
            } else {
                newAddressForm.style.display = 'none';
                addressFormInputs.forEach(input => {
                    input.removeAttribute('required');
                });
                
                // إذا تم اختيار عنوان محفوظ، عرض موقعه على الخريطة
                const selectedOption = this.options[this.selectedIndex];
                const lat = selectedOption.dataset.lat;
                const lng = selectedOption.dataset.lng;
                
                if (lat && lng) {
                    updateUserLocation(parseFloat(lat), parseFloat(lng));
                    map.setCenter({ lat: parseFloat(lat), lng: parseFloat(lng) });
                    map.setZoom(15);
                }
            }
        });

        // تشغيل الحدث عند تحميل الصفحة
        addressSelect.dispatchEvent(new Event('change'));
    }
});

// تحميل خريطة Google Maps
function loadGoogleMaps() {
    // تحقق من وجود Google Maps API Key في متغيرات البيئة
    const apiKey = '{{ env("GOOGLE_MAPS_API_KEY") }}' || 'AIzaSyDjYTUVp5rADDxV8WbWE6j35FqhtqbMhMo';
    
    if (!apiKey || apiKey === 'AIzaSyDjYTUVp5rADDxV8WbWE6j35FqhtqbMhMo') {
        // عرض رسالة خطأ إذا لم يتم تعيين API Key
        document.getElementById('map').innerHTML = `
            <div class="alert alert-warning text-center" style="height: 400px; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                <h5><i class="fas fa-exclamation-triangle"></i> Google Maps API Key Required</h5>
                <p class="mb-3">To enable map functionality, please:</p>
                <ol class="text-start">
                    <li>Get a Google Maps API key from <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">Google Cloud Console</a></li>
                    <li>Add it to your .env file: <code>GOOGLE_MAPS_API_KEY=AIzaSyDjYTUVp5rADDxV8WbWE6j35FqhtqbMhMo</code></li>
                    <li>Enable these APIs: Maps JavaScript API, Places API, Geocoding API</li>
                    <li>Refresh this page</li>
                </ol>
                <button type="button" class="btn btn-primary mt-2" onclick="enableManualMode()">Continue Without Map</button>
            </div>
        `;
        return;
    }
    
    const script = document.createElement('script');
    script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&libraries=places,geometry&callback=initMap`;
    script.async = true;
    script.defer = true;
    script.onerror = function() {
        document.getElementById('map').innerHTML = `
            <div class="alert alert-danger text-center" style="height: 400px; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                <h5><i class="fas fa-times-circle"></i> Failed to Load Google Maps</h5>
                <p>Please check your API key and internet connection.</p>
                <button type="button" class="btn btn-primary" onclick="enableManualMode()">Continue Without Map</button>
            </div>
        `;
    };
    document.head.appendChild(script);
}

// تفعيل الوضع اليدوي بدون خريطة
function enableManualMode() {
    document.getElementById('map').innerHTML = `
        <div class="alert alert-info text-center" style="height: 200px; display: flex; align-items: center; justify-content: center; flex-direction: column;">
            <h6><i class="fas fa-map-marker-alt"></i> Manual Address Entry</h6>
            <p class="mb-0">Please fill in your address details below. We'll verify the delivery zone after you place your order.</p>
        </div>
    `;
    
    // إخفاء أزرار الخريطة
    document.querySelector('.map-controls').style.display = 'none';
    document.getElementById('address-search').style.display = 'none';
    
    // إزالة التحقق من الإحداثيات في النموذج
    const form = document.getElementById('checkout-form');
    const originalSubmit = form.onsubmit;
    
    form.addEventListener('submit', function(e) {
        // السماح بإرسال النموذج بدون إحداثيات في الوضع اليدوي
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');
        
        if (!latInput.value && !lngInput.value) {
            // تعيين إحداثيات افتراضية (سيتم التحقق منها في الخادم)
            latInput.value = '0';
            lngInput.value = '0';
        }
    });
}

// تحميل الخريطة عند تحميل الصفحة
window.addEventListener('load', function() {
    // تأخير قليل للتأكد من تحميل جميع العناصر
    setTimeout(loadGoogleMaps, 500);
});
</script>
@endpush
@endsection