@extends('layouts.auth')

@section('title', 'Verify Email')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <div class="auth-icon">
            <i class="bi bi-envelope-check"></i>
        </div>
        <h1>Verify Your Email</h1>
        <p>We've sent a verification link to your email address</p>
    </div>

    <div class="auth-body">
        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div>A new verification link has been sent to your email address.</div>
            </div>
        @endif

        <div class="verification-info">
            <div class="email-display">
                <i class="bi bi-envelope"></i>
                <span>{{ auth()->user()->email }}</span>
            </div>
            
            <p class="text-muted mt-4">
                Please check your inbox and click on the verification link to activate your account. 
                If you don't see the email, check your spam folder.
            </p>
        </div>

        <div class="verification-actions mt-4">
            <form method="POST" action="{{ route('verification.send') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-primary w-100 mb-3">
                    <i class="bi bi-arrow-repeat me-2"></i>Resend Verification Email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                </button>
            </form>
        </div>
    </div>

    <div class="auth-footer">
        <p><i class="bi bi-question-circle me-1"></i>Need help? <a href="{{ url('/contact') }}">Contact Support</a></p>
    </div>
</div>
@endsection