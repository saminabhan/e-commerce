@extends('layouts.app')
@section('title', 'Sami Store | My Account Details')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
      <h2 class="page-title"><span>Account</span> Details</h2>
      <div class="row">
        <div class="col-lg-3">
          @include('user.account-nav')
        </div>
        <div class="col-lg-9">
          <div class="page-content my-account__edit">
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
            
            <div class="my-account__edit-form">
              <form name="account_edit_form" action="{{ route('user.update.details') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-floating my-3">
                      <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Full Name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                      <label for="name">Name</label>
                      @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-floating my-3">
                      <input type="text" class="form-control @error('mobile') is-invalid @enderror" placeholder="Mobile Number" name="mobile" value="{{ old('mobile', Auth::user()->mobile) }}" required>
                      <label for="mobile">Mobile Number</label>
                      @error('mobile')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-floating my-3">
                      <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                      <label for="account_email">Email Address</label>
                      @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="my-3">
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </div>
                </div>
              </form>
              
              <hr class="my-5">
              
              <form name="password_change_form" action="{{ route('user.update.password') }}" method="POST" class="{{ session('password_error') ? 'was-validated' : '' }}">
                  @csrf
                  @method('PUT')
                  
                  <div class="row">
                      <div class="col-md-12">
                          <div class="my-3">
                              <h5 class="text-uppercase mb-0">Password Change</h5>
                          </div>
                      </div>
                      
                      <!-- Current Password Field -->
                      <div class="col-md-12">
                          <div class="form-floating my-3">
                              <input type="password" class="form-control @error('old_password') is-invalid @enderror" 
                                    id="old_password" name="old_password" 
                                    placeholder="Current password" required>
                              <label for="old_password">Current password</label>
                              @error('old_password')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>
                      </div>
                      
                      <!-- New Password Field -->
                      <div class="col-md-12">
                          <div class="form-floating my-3">
                              <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                    id="new_password" name="new_password" 
                                    placeholder="New password" required
                                    minlength="8">
                              <label for="new_password">New password</label>
                              @error('new_password')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                              <small class="form-text text-muted">
                                  Password must be at least 8 characters long.
                              </small>
                          </div>
                      </div>
                      
                      <!-- Confirm New Password Field -->
                      <div class="col-md-12">
                          <div class="form-floating my-3">
                              <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" 
                                    id="new_password_confirmation" name="new_password_confirmation" 
                                    placeholder="Confirm new password" required>
                              <label for="new_password_confirmation">Confirm new password</label>
                              @error('new_password_confirmation')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>
                      </div>
                      
                      <!-- Submit Button -->
                      <div class="col-md-12">
                          <div class="my-3">
                              <button type="submit" class="btn btn-primary">Update Password</button>
                          </div>
                      </div>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
@endsection