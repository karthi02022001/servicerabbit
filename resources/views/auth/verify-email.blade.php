@extends('layouts.auth')

@section('title', 'Verify Email')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <div class="auth-header-icon">
            <i class="bi bi-envelope-check"></i>
        </div>
        <h2>Verify Your Email</h2>
        <p>We've sent a verification link to your email</p>
    </div>

    <div class="auth-body text-center">
        @if(session('status') == 'verification-link-sent')
            <div class="alert alert-success mb-4">
                <i class="bi bi-check-circle me-2"></i>
                A new verification link has been sent to your email address.
            </div>
        @endif

        <div class="mb-4">
            <div style="width: 100px; height: 100px; margin: 0 auto 25px; background: linear-gradient(135deg, rgba(255, 107, 53, 0.1), rgba(255, 140, 90, 0.05)); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-envelope-paper" style="font-size: 2.5rem; color: var(--primary);"></i>
            </div>
            <p style="color: var(--gray); line-height: 1.7;">
                Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just emailed to you.
            </p>
            <p style="color: var(--gray); line-height: 1.7;">
                If you didn't receive the email, we will gladly send you another.
            </p>
        </div>

        <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
            @csrf
            <button type="submit" class="btn btn-primary w-100 btn-lg">
                <i class="bi bi-send me-2"></i> Resend Verification Email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link" style="color: var(--gray); text-decoration: none;">
                <i class="bi bi-box-arrow-right me-1"></i> Log Out
            </button>
        </form>
    </div>

    <div class="auth-footer">
        <p class="mb-0">
            Wrong email? 
            <a href="{{ route('register') }}">Sign up again</a>
        </p>
    </div>
</div>
@endsection