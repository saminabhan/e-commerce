@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email') }}</div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-envelope-open-text fa-3x text-primary mb-3"></i>
                        <h5>Check Your Email</h5>
                        <p class="text-muted">
                            We sent a 6-digit verification code to:<br>
                            <strong>{{ $tempUser->email ?? 'your email' }}</strong>
                        </p>
                    </div>
                    
                    <form method="POST" action="{{ route('verify.code') }}" id="verifyForm">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="code">{{ __('Verification Code') }}</label>
                            <input type="text" 
                                   name="code" 
                                   id="code"
                                   class="form-control text-center @error('code') is-invalid @enderror" 
                                   maxlength="6" 
                                   required 
                                   autocomplete="off"
                                   placeholder="000000"
                                   style="font-size: 20px; letter-spacing: 5px;">
                            @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            {{ __('Verify Email') }}
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <p class="text-muted">Didn't receive the code?</p>
                        <button id="resendBtn" class="btn btn-link" onclick="resendCode()">
                            Resend Code
                        </button>
                        <div id="countdown" class="text-muted" style="display: none;">
                            You can request a new code in <span id="timer">10</span> seconds
                        </div>
                    </div>

                    <div id="message" class="mt-3"></div>

                    <div class="alert alert-info mt-3">
                        <small>
                            <i class="fas fa-info-circle"></i> 
                            <strong>Note:</strong> The verification code is valid for <strong>5 minutes</strong>. 
                            Requesting a new code will invalidate the previous one.
                        </small>
                    </div>

                    <div class="text-center mt-3">
                        <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-sm">
                            ← Back to Registration
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let countdownInterval;
let canResend = true;

function showCountdown(seconds = 10) {
    canResend = false;
    document.getElementById('resendBtn').style.display = 'none';
    document.getElementById('countdown').style.display = 'block';
    
    let timeLeft = seconds;
    document.getElementById('timer').textContent = timeLeft;
    
    countdownInterval = setInterval(() => {
        timeLeft--;
        document.getElementById('timer').textContent = timeLeft;
        
        if (timeLeft <= 0) {
            clearInterval(countdownInterval);
            document.getElementById('countdown').style.display = 'none';
            document.getElementById('resendBtn').style.display = 'inline-block';
            canResend = true;
        }
    }, 1000);
}

function resendCode() {
    if (!canResend) return;
    
    const btn = document.getElementById('resendBtn');
    const originalText = btn.textContent;
    btn.textContent = 'Sending...';
    btn.disabled = true;
    
    fetch('{{ route("verify.resend") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        const messageDiv = document.getElementById('message');
        
        if (data.success) {
            messageDiv.innerHTML = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> ' + data.message + '</div>';
            showCountdown(10);
        } else {
            messageDiv.innerHTML = '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> ' + data.message + '</div>';
            if (data.remaining_seconds) {
                showCountdown(data.remaining_seconds);
            } else {
                btn.textContent = originalText;
                btn.disabled = false;
            }
        }
        
        // Clear message after 5 seconds
        setTimeout(() => {
            messageDiv.innerHTML = '';
        }, 5000);
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('message').innerHTML = '<div class="alert alert-danger"><i class="fas fa-times-circle"></i> An error occurred. Please try again.</div>';
        btn.textContent = originalText;
        btn.disabled = false;
    });
}

// Only allow numeric input
document.getElementById('code').addEventListener('input', function(e) {
    this.value = this.value.replace(/\D/g, '');
});

// Auto-focus on code input
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('code').focus();
    
    // If there's an error about expired code, allow immediate resend
    @if($errors->has('code') && str_contains($errors->first('code'), 'expired'))
        showCountdown(0);
    @endif
});

// Auto-submit when 6 digits are entered
document.getElementById('code').addEventListener('input', function(e) {
    if (this.value.length === 6) {
        setTimeout(() => {
            document.getElementById('verifyForm').submit();
        }, 500);
    }
});
</script>

<style>
.fas {
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
}

.fa-envelope-open-text:before {
    content: "📧";
}

.fa-info-circle:before {
    content: "ℹ️";
}

.fa-check-circle:before {
    content: "✅";
}

.fa-exclamation-triangle:before {
    content: "⚠️";
}

.fa-times-circle:before {
    content: "❌";
}
</style>
@endsection