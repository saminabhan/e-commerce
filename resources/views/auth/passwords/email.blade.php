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

                    <form method="POST" action="{{ route('password.email') }}" id="resetForm">
                        @csrf

                        <div class="form-floating mb-3">
                            <input id="email" 
                                   type="email" 
                                   class="form-control form-control_gray @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autocomplete="email" 
                                   autofocus>
                            <label for="email">Email Address *</label>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" id="resetBtn" class="btn btn-primary w-100 text-uppercase">
                            Send Password Reset Link
                        </button>
                        <div id="countdown" class="text-center mt-2 text-muted" style="display:none;"></div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

{{-- Script with loader + countdown --}}
<script>
    document.getElementById('resetForm').addEventListener('submit', function (e) {
        let btn = document.getElementById('resetBtn');
        let countdownEl = document.getElementById('countdown');

        // Disable button
        btn.disabled = true;
        btn.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
            Sending...
        `;

        // Start countdown (120 seconds)
        let seconds = 120;
        countdownEl.style.display = 'block';
        countdownEl.textContent = `Please wait ${seconds} seconds before trying again.`;

        let interval = setInterval(() => {
            seconds--;
            countdownEl.textContent = `Please wait ${seconds} seconds before trying again.`;

            if (seconds <= 0) {
                clearInterval(interval);
                countdownEl.style.display = 'none';
                btn.disabled = false;
                btn.innerHTML = 'Send Password Reset Link';
            }
        }, 1000);
    });
</script>
@endsection
