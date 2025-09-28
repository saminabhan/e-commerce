@extends('layouts.app')
@section('title', 'Login')
@section('content')

<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="login-register container">
      <ul class="nav nav-tabs mb-5" id="login_register" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link nav-link_underscore active" id="login-tab" data-bs-toggle="tab" href="#tab-item-login"
            role="tab" aria-controls="tab-item-login" aria-selected="true">Login</a>
        </li>
      </ul>
      <div class="tab-content pt-2" id="login_register_tab_content">
        <div class="tab-pane fade show active" id="tab-item-login" role="tabpanel" aria-labelledby="login-tab">
          <div class="login-form">
            @if(session('status'))
              <div class="alert alert-success mb-3">
                {{ session('status') }}
              </div>
            @endif
            
            @if(session('error'))
              <div class="alert alert-danger mb-3">
                {{ session('error') }}
              </div>
            @endif

            <form method="POST" action="{{ route('login') }}" name="login-form" class="needs-validation" novalidate="">
                @csrf
              <div class="form-floating mb-3">
                <input class="form-control form-control_gray @error('email') is-invalid @enderror" 
                       name="email" 
                       type="email" 
                       value="{{ old('email') }}" 
                       required="" 
                       autocomplete="email" 
                       autofocus="">
                <label for="email">Email address *</label>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <div class="pb-3"></div>

              <div class="form-floating mb-3">
                <input id="password" 
                       type="password" 
                       class="form-control form-control_gray @error('password') is-invalid @enderror" 
                       name="password" 
                       required="" 
                       autocomplete="current-password">
                <label for="password">Password *</label>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <div class="d-flex align-items-center mb-3">
                <div class="form-check">
                  <input class="form-check-input form-check-input_fill" 
                         type="checkbox" 
                         name="remember" 
                         id="remember"
                         {{ old('remember') ? 'checked' : '' }}>
                  <label class="form-check-label" for="remember">
                    Remember Me
                  </label>
                </div>
                <a href="{{ route('password.request') }}" class="btn-text ms-auto">
                  Forgot Your Password?
                </a>
              </div>

              <button class="btn btn-primary w-100 text-uppercase" type="submit">Log In</button>

              <div class="customer-option mt-4 text-center">
                <span class="text-secondary">No account yet?</span>
                <a href="{{ route('register') }}" class="btn-text js-show-register">Create Account</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
</main>
@endsection