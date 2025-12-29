@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <div class="auth-icon">
            <i class="bi bi-key"></i>
        </div>
        <h1>Forgot Password?</h1>
        <p>No worries! Enter your email and we'll send you a reset link.</p>
    </div>

    <div class="auth-body">
        @if (session('status'))
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div>{{ session('status') }}</div>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-floating mb-4">
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       placeholder="name@example.com" 
                       required 
                       autofocus>
                <label for="email">
                    <i class="bi bi-envelope me-2"></i>Email Address
                </label>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 btn-lg mb-3">
                <i class="bi bi-envelope-arrow-up me-2"></i>
                Send Reset Link
            </button>

            <div class="text-center">
                <a href="{{ route('login') }}" class="text-muted text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i>
                    Back to Login
                </a>
            </div>
        </form>
    </div>

    <div class="auth-footer">
        <p>
            Don't have an account? 
            <a href="{{ route('register') }}">Sign up</a>
        </p>
    </div>
</div>

<style>
.auth-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, var(--primary), #ff8c5a);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.auth-icon i {
    font-size: 2.5rem;
    color: white;
}

.auth-header h1 {
    font-size: 1.75rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.auth-header p {
    color: #6c757d;
    margin-bottom: 0;
}

.form-floating > .form-control {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    height: 58px;
    padding-left: 1rem;
}

.form-floating > .form-control:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.1);
}

.form-floating > label {
    padding-left: 1rem;
}

.btn-primary {
    padding: 0.875rem 1.5rem;
    font-weight: 600;
    border-radius: 12px;
}

.alert {
    border-radius: 12px;
    border: none;
}

.alert-success {
    background: #d1fae5;
    color: #065f46;
}
</style>
@endsection