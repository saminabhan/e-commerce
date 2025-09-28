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
            
            @if(session('error'))
              <div class="alert alert-danger">
                {{ session('error') }}
              </div>
            @endif

            @if(session('info'))
              <div class="alert alert-info">
                {{ session('info') }}
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
              <form name="account_edit_form" id="account_edit_form" action="{{ route('user.update.details') }}" method="POST">
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
                      <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" name="email" id="email_input" value="{{ old('email', Auth::user()->email) }}" required>
                      <label for="email">Email Address</label>
                      @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                      <small class="text-muted">Changing your email will require verification</small>
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

<!-- Email Change Confirmation Modal -->
<div class="modal fade" id="emailChangeModal" tabindex="-1" aria-labelledby="emailChangeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="emailChangeModalLabel">Confirm Email Change</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-warning">
          <i class="fa fa-exclamation-triangle"></i>
          <strong>Important!</strong> You are about to change your email address.
        </div>
        <p>This action will:</p>
        <ul>
          <li>Send a verification code to your new email address</li>
          <li>Require you to verify the new email before the change takes effect</li>
          <li>Keep your current email active until verification is complete</li>
        </ul>
        <p><strong>New Email:</strong> <span id="newEmailDisplay"></span></p>
        <p>Are you sure you want to continue?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <form method="POST" action="{{ route('user.confirm.email.change') }}" style="display: inline;">
          @csrf
          <input type="hidden" name="confirm" value="yes">
          <button type="submit" class="btn btn-primary">Yes, Continue</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('account_edit_form');
    const originalEmail = '{{ Auth::user()->email }}';
    const emailInput = document.getElementById('email_input');
    const modal = new bootstrap.Modal(document.getElementById('emailChangeModal'));
    
    form.addEventListener('submit', function(e) {
        const currentEmail = emailInput.value.trim();
        
        // التحقق من تغيير الإيميل
        if (currentEmail !== originalEmail) {
            e.preventDefault();
            
            // إزالة رسائل الأخطاء السابقة
            clearPreviousErrors();
            
            // عرض loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Checking...';
            submitBtn.disabled = true;
            
            // إرسال النموذج بـ AJAX للتحقق من صحة البيانات
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                
                if (!response.ok) {
                    return response.json().then(err => Promise.reject(err));
                }
                return response.json();
            })
            .then(data => {
                if (data.confirm_email_change) {
                    // عرض الإيميل الجديد في المودال
                    document.getElementById('newEmailDisplay').textContent = currentEmail;
                    modal.show();
                } else if (data.success) {
                    // تحديث ناجح بدون حاجة للتحقق
                    location.reload();
                } else {
                    // إرسال النموذج عادي
                    form.submit();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                
                // عرض أخطاء التحقق
                if (error.errors) {
                    displayValidationErrors(error.errors);
                } else if (error.message) {
                    showAlert(error.message, 'danger');
                } else {
                    showAlert('حدث خطأ. يرجى المحاولة مرة أخرى.', 'danger');
                }
            });
        }
    });
    
    function clearPreviousErrors() {
        // إزالة رسائل الأخطاء السابقة
        const alerts = document.querySelectorAll('.alert-danger, .alert-success');
        alerts.forEach(alert => alert.remove());
        
        // إزالة الـ classes الخاصة بالأخطاء
        const invalidInputs = document.querySelectorAll('.is-invalid');
        invalidInputs.forEach(input => {
            input.classList.remove('is-invalid');
            const feedback = input.parentNode.querySelector('.invalid-feedback');
            if (feedback) feedback.remove();
        });
    }
    
    function displayValidationErrors(errors) {
        for (const [field, messages] of Object.entries(errors)) {
            const input = form.querySelector(`[name="${field}"]`);
            if (input) {
                input.classList.add('is-invalid');
                
                // إنشاء رسالة الخطأ
                const feedback = document.createElement('div');
                feedback.className = 'invalid-feedback';
                feedback.innerHTML = `<strong>${messages[0]}</strong>`;
                
                // إضافة رسالة الخطأ بعد الـ input
                input.parentNode.appendChild(feedback);
            }
        }
    }
    
    function showAlert(message, type = 'info') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        // إضافة التنبيه في أعلى النموذج
        const formContainer = document.querySelector('.my-account__edit-form');
        formContainer.insertBefore(alertDiv, formContainer.firstChild);
    }
    
    // التحقق من الإيميل فوراً عند تغييره
    emailInput.addEventListener('blur', function() {
        const currentEmail = this.value.trim();
        
        if (currentEmail !== originalEmail && currentEmail !== '') {
            // تحقق فوري من وجود الإيميل
            checkEmailAvailability(currentEmail);
        }
    });
    
    function checkEmailAvailability(email) {
        // إرسال طلب للتحقق من توفر الإيميل
        fetch('{{ route("user.check.email") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            const emailInput = document.getElementById('email_input');
            const existingFeedback = emailInput.parentNode.querySelector('.email-availability-feedback');
            
            // إزالة الرسالة السابقة
            if (existingFeedback) {
                existingFeedback.remove();
            }
            
            if (!data.available) {
                emailInput.classList.add('is-invalid');
                const feedback = document.createElement('div');
                feedback.className = 'invalid-feedback email-availability-feedback';
                feedback.innerHTML = '<strong>This email address is already registered with another account.</strong>';
                emailInput.parentNode.appendChild(feedback);
            } else {
                emailInput.classList.remove('is-invalid');
                const feedback = document.createElement('div');
                feedback.className = 'valid-feedback email-availability-feedback';
                feedback.innerHTML = '<strong>This email address is available.</strong>';
                emailInput.parentNode.appendChild(feedback);
                emailInput.classList.add('is-valid');
            }
        })
        .catch(error => {
            console.error('Error checking email:', error);
        });
    }
});
</script>

@endsection