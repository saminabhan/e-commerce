@extends('layouts.app')

@section('title', 'Sami Store | Add New Address')

@section('content')
<main class="pt-90">
  <div class="mb-4 pb-4"></div>
  <section class="my-account container">
    <h2 class="page-title"><span>Add New</span> Address</h2>
    <div class="row">
      <div class="col-lg-3">
        @include('user.account-nav')
      </div>
      <div class="col-lg-9">
        <div class="page-content my-account__address-form">

          @if(session('success'))
            <div class="alert alert-success">
              {{ session('success') }}
            </div>
          @endif
          @if($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <a href="{{ route('addresses.index') }}" class="btn btn-secondary mb-3">Back to Addresses</a>

          <form action="{{ route('addresses.store') }}" method="POST" novalidate>
            @csrf
            <div class="row g-3">

              <div class="col-md-6">
                <div class="form-floating">
                  <input type="text" 
                         class="form-control @error('name') is-invalid @enderror" 
                         id="name" name="name" 
                         placeholder="Full Name" 
                         value="{{ old('name') }}" required>
                  <label for="name">Full Name *</label>
                  @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-floating">
                  <input type="text" 
                         class="form-control @error('phone') is-invalid @enderror" 
                         id="phone" name="phone" 
                         placeholder="Phone Number" 
                         value="{{ old('phone') }}" required>
                  <label for="phone">Phone Number *</label>
                  @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-floating">
                  <input type="text" 
                         class="form-control @error('zip') is-invalid @enderror" 
                         id="zip" name="zip" 
                         placeholder="Pincode" 
                         value="{{ old('zip') }}" required>
                  <label for="zip">Pincode *</label>
                  @error('zip')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-floating">
                  <input type="text" 
                         class="form-control @error('state') is-invalid @enderror" 
                         id="state" name="state" 
                         placeholder="State" 
                         value="{{ old('state') }}" required>
                  <label for="state">State *</label>
                  @error('state')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-floating">
                  <input type="text" 
                         class="form-control @error('city') is-invalid @enderror" 
                         id="city" name="city" 
                         placeholder="Town / City" 
                         value="{{ old('city') }}" required>
                  <label for="city">Town / City *</label>
                  @error('city')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-floating">
                  <input type="text" 
                         class="form-control @error('address') is-invalid @enderror" 
                         id="address" name="address" 
                         placeholder="House no, Building Name" 
                         value="{{ old('address') }}" required>
                  <label for="address">House no, Building Name *</label>
                  @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-floating">
                  <input type="text" 
                         class="form-control @error('locality') is-invalid @enderror" 
                         id="locality" name="locality" 
                         placeholder="Road Name, Area, Colony" 
                         value="{{ old('locality') }}" required>
                  <label for="locality">Road Name, Area, Colony *</label>
                  @error('locality')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-floating">
                  <input type="text" 
                         class="form-control @error('landmark') is-invalid @enderror" 
                         id="landmark" name="landmark" 
                         placeholder="Landmark" 
                         value="{{ old('landmark') }}">
                  <label for="landmark">Landmark</label>
                  @error('landmark')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-check mt-3">
                  <input class="form-check-input" type="checkbox" name="is_default" id="is_default" value="1" {{ old('is_default') ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_default">Make as Default address</label>
                </div>
              </div>

              <div class="col-md-12 mt-4">
                <button type="submit" class="btn btn-primary">Add Address</button>
              </div>

            </div>
          </form>

        </div>
      </div>
    </div>
  </section>
</main>
@endsection
