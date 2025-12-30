@extends('layouts.auth')

@section('title', 'Verify OTP')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <div class="auth-header-icon">
            <i class="bi bi-shield-lock"></i>
        </div>
        <h2>Verify Your Email</h2>
        <p>Enter the 6-digit code sent to your email</p>
    </div>

    <div class="auth-body">
        @if(session('success'))
            <div class="alert alert-success mb-4">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info mb-4">
                <i class="bi bi-info-circle me-2"></i>
                {{ session('info') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning mb-4">
                <i class="bi bi-exclamation-triangle me-2"></i>
                {{ session('warning') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger mb-4">
                <i class="bi bi-exclamation-triangle me-2"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <div class="text-center mb-4">
            <div class="email-sent-icon mx-auto mb-3">
                <i class="bi bi-envelope-check"></i>
            </div>
            <p class="text-muted">
                We've sent a verification code to<br>
                <strong>{{ auth()->user()->email ?? 'your email' }}</strong>
            </p>
        </div>

        <form method="POST" action="{{ route('otp.verify') }}" id="otpForm">
            @csrf

            <div class="mb-4">
                <label for="otp" class="form-label text-center d-block">Enter OTP Code</label>
                <div class="otp-inputs d-flex justify-content-center gap-2">
                    <input type="text" 
                           class="form-control otp-input text-center @error('otp') is-invalid @enderror" 
                           id="otp1" 
                           maxlength="1" 
                           autofocus
                           inputmode="numeric"
                           pattern="[0-9]*">
                    <input type="text" 
                           class="form-control otp-input text-center" 
                           id="otp2" 
                           maxlength="1"
                           inputmode="numeric"
                           pattern="[0-9]*">
                    <input type="text" 
                           class="form-control otp-input text-center" 
                           id="otp3" 
                           maxlength="1"
                           inputmode="numeric"
                           pattern="[0-9]*">
                    <input type="text" 
                           class="form-control otp-input text-center" 
                           id="otp4" 
                           maxlength="1"
                           inputmode="numeric"
                           pattern="[0-9]*">
                    <input type="text" 
                           class="form-control otp-input text-center" 
                           id="otp5" 
                           maxlength="1"
                           inputmode="numeric"
                           pattern="[0-9]*">
                    <input type="text" 
                           class="form-control otp-input text-center" 
                           id="otp6" 
                           maxlength="1"
                           inputmode="numeric"
                           pattern="[0-9]*">
                </div>
                <input type="hidden" name="otp" id="otpHidden">
                @error('otp')
                    <div class="invalid-feedback d-block text-center mt-2">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 btn-lg">
                <i class="bi bi-check-circle me-2"></i> Verify OTP
            </button>
        </form>

        <div class="text-center mt-4">
            <p class="text-muted mb-2">Didn't receive the code?</p>
            <form method="POST" action="{{ route('otp.resend') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-link p-0 forgot-link">
                    <i class="bi bi-arrow-repeat me-1"></i> Resend OTP
                </button>
            </form>
        </div>

        <div class="text-center mt-3">
            <small class="text-muted">
                <i class="bi bi-clock me-1"></i> Code expires in 10 minutes
            </small>
        </div>
    </div>

    <div class="auth-footer">
        <p class="mb-0">
            Wrong email? 
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-link p-0 text-primary fw-semibold" style="text-decoration: none;">
                    Sign out & try again
                </button>
            </form>
        </p>
    </div>
</div>

<style>
.email-sent-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, rgba(255, 107, 53, 0.1), rgba(255, 140, 90, 0.05));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.email-sent-icon i {
    font-size: 2.5rem;
    color: var(--primary, #FF6B35);
}

.otp-input {
    width: 50px !important;
    height: 55px !important;
    font-size: 1.5rem;
    font-weight: 600;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.otp-input:focus {
    border-color: #FF6B35;
    box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.1);
    outline: none;
}

.otp-input.filled {
    border-color: #FF6B35;
    background: rgba(255, 107, 53, 0.05);
}

.btn-primary {
    background: linear-gradient(135deg, #FF6B35, #ff8c5a);
    border: none;
    padding: 12px 24px;
    font-weight: 600;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #e55a2b, #FF6B35);
    transform: translateY(-2px);
}

.forgot-link {
    color: #FF6B35;
    text-decoration: none;
    font-weight: 500;
}

.forgot-link:hover {
    color: #e55a2b;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.otp-input');
    const form = document.getElementById('otpForm');
    const hiddenInput = document.getElementById('otpHidden');
    
    // Focus handling and auto-advance
    inputs.forEach((input, index) => {
        input.addEventListener('input', function(e) {
            // Only allow numbers
            this.value = this.value.replace(/[^0-9]/g, '');
            
            if (this.value.length === 1) {
                this.classList.add('filled');
                // Move to next input
                if (index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            }
            
            // Update hidden field
            updateHiddenField();
        });
        
        input.addEventListener('keydown', function(e) {
            // Handle backspace
            if (e.key === 'Backspace' && this.value === '' && index > 0) {
                inputs[index - 1].focus();
                inputs[index - 1].classList.remove('filled');
            }
        });
        
        // Handle paste
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const paste = (e.clipboardData || window.clipboardData).getData('text');
            const digits = paste.replace(/[^0-9]/g, '').substring(0, 6);
            
            for (let i = 0; i < digits.length && i < 6; i++) {
                inputs[i].value = digits[i];
                inputs[i].classList.add('filled');
            }
            
            if (digits.length >= 6) {
                inputs[5].focus();
            } else if (digits.length > 0) {
                inputs[Math.min(digits.length, 5)].focus();
            }
            
            updateHiddenField();
        });
    });
    
    function updateHiddenField() {
        let otp = '';
        inputs.forEach(input => {
            otp += input.value;
        });
        hiddenInput.value = otp;
    }
    
    // Combine OTP before submit
    form.addEventListener('submit', function(e) {
        updateHiddenField();
        if (hiddenInput.value.length !== 6) {
            e.preventDefault();
            alert('Please enter all 6 digits of the OTP code.');
        }
    });
});
</script>
@endsection