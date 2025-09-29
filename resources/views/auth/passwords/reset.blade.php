@extends('layouts.app')
@section('title', 'Reset Password')
@section('content')

<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="login-register container">
        <ul class="nav nav-tabs mb-5" id="reset_tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link nav-link_underscore active" id="reset-tab" data-bs-toggle="tab" href="#tab-item-reset"
                   role="tab" aria-controls="tab-item-reset" aria-selected="true">Reset Password</a>
            </li>
        </ul>

        <div class="tab-content pt-2" id="reset_tabs_content">
            <div class="tab-pane fade show active" id="tab-item-reset" role="tabpanel" aria-labelledby="reset-tab">
                <div class="login-form">

                    <form method="POST" action="{{ route('password.update') }}" id="resetPasswordForm">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                       {{-- Email (display only) --}}
                        <div class="form-floating mb-3">
                        {{-- للعرض فقط --}}
                        <input type="email" 
                            class="form-control form-control_gray" 
                            value="{{ $email ?? '' }}" 
                            disabled>

                        {{-- للإرسال مع الـ form --}}
                        <input type="hidden" name="email" value="{{ $email ?? '' }}">
                            <label>Email Address *</label>
                        </div>


                        {{-- Password --}}
                        <div class="form-floating mb-3">
                            <input id="password" 
                                   type="password" 
                                   class="form-control form-control_gray @error('password') is-invalid @enderror" 
                                   name="password" 
                                   required 
                                   autocomplete="new-password">
                            <label for="password">New Password *</label>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="form-floating mb-3">
                            <input id="password-confirm" 
                                   type="password" 
                                   class="form-control form-control_gray" 
                                   name="password_confirmation" 
                                   required 
                                   autocomplete="new-password">
                            <label for="password-confirm">Confirm Password *</label>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" id="resetPasswordBtn" class="btn btn-primary w-100 text-uppercase">
                            Reset Password
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </section>
</main>

{{-- Loader Script --}}
<script>
    document.getElementById('resetPasswordForm').addEventListener('submit', function () {
        let btn = document.getElementById('resetPasswordBtn');
        btn.disabled = true;
        btn.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
            Resetting...
        `;
    });
</script>
@endsection
