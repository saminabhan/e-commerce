@extends('layouts.app')
@section('title', 'Sami Store | Verify Email Change')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title"><span>Verify</span> Email Change</h2>
        <div class="row">
            <div class="col-lg-3">
                @include('user.account-nav')
            </div>
            <div class="col-lg-9">
                <div class="page-content my-account__edit">
                    
                    {{-- Success & Error Messages --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if(session('info'))
                        <div class="alert alert-info">{{ session('info') }}</div>
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
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i>
                            We've sent a 6-digit verification code to your new email address. Please enter it below to complete the change.
                        </div>

                        {{-- Verification Form --}}
                        <form method="POST" action="{{ route('user.verify.email.change') }}">
                            @csrf
                            <div class="form-floating my-3">
                                <input type="text" 
                                       class="form-control text-center @error('verification_code') is-invalid @enderror" 
                                       id="verification_code" 
                                       name="verification_code" 
                                       placeholder="Enter 6-digit code"
                                       maxlength="6"
                                       pattern="[0-9]{6}"
                                       style="letter-spacing: 0.5em; font-size: 1.2em;"
                                       required>
                                <label for="verification_code">Verification Code</label>
                                @error('verification_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="my-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    Verify Email
                                </button>
                            </div>
                        </form>

                        <div class="text-center my-3">
                            <p class="text-muted mb-2">Didn't receive the code?</p>
                            <button id="resendBtn" class="btn btn-outline-secondary" disabled>
                                Resend Code (<span id="counter">60</span>s)
                            </button>
                        </div>

                        <hr class="my-5">

                        <div class="text-center">
                            <a href="{{ route('user.details') }}" class="btn btn-link">
                                Cancel and go back to Account Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let resendBtn = document.getElementById("resendBtn");
    let counterEl = document.getElementById("counter");

    let defaultWait = 60; // مدة الانتظار
    let now = Math.floor(Date.now() / 1000);

    // إذا ما في وقت انتهاء محفوظ، نسجله الآن
    let endTime = localStorage.getItem("resend_end_time");
    if (!endTime) {
        endTime = now + defaultWait;
        localStorage.setItem("resend_end_time", endTime);
    } else {
        endTime = parseInt(endTime);
    }

    let waitTime = endTime - now;
    if (waitTime < 0) waitTime = 0;

    function startCountdown(seconds) {
        resendBtn.disabled = true;
        counterEl.textContent = seconds;

        let interval = setInterval(() => {
            seconds--;
            counterEl.textContent = seconds;

            if (seconds <= 0) {
                clearInterval(interval);
                resendBtn.textContent = "Resend Code";
                resendBtn.disabled = false;

                localStorage.removeItem("resend_end_time");

                resendBtn.addEventListener("click", function () {
                    let newEndTime = Math.floor(Date.now() / 1000) + defaultWait;
                    localStorage.setItem("resend_end_time", newEndTime);
                    window.location.href = "{{ route('user.resend.email.verification') }}";
                }, { once: true });
            }
        }, 1000);
    }

    if (waitTime > 0) {
        startCountdown(waitTime);
    } else {
        resendBtn.textContent = "Resend Code";
        resendBtn.disabled = false;
        resendBtn.addEventListener("click", function () {
            let newEndTime = Math.floor(Date.now() / 1000) + defaultWait;
            localStorage.setItem("resend_end_time", newEndTime);
            window.location.href = "{{ route('user.resend.email.verification') }}";
        }, { once: true });
    }
});
</script>

<script>
document.getElementById('verification_code').addEventListener('input', function(e) {
    // أرقام فقط
    this.value = this.value.replace(/[^0-9]/g, '');
    // إرسال أوتوماتيكي عند 6 أرقام
    if (this.value.length === 6) {
        setTimeout(() => {
            this.closest('form').submit();
        }, 500);
    }
});
</script>
@endsection
