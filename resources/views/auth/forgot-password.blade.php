@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <div class="auth-header-icon">
            <i class="bi bi-key"></i>
        </div>
        <h2>Forgot Password?</h2>
        <p>No worries, we'll send you reset instructions</p>
    </div>

    <div class="auth-body">
        @if(session('status'))
            <div class="alert alert-success mb-4">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger mb-4">
                <i class="bi bi-exclamation-triangle me-2"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           placeholder="Enter your email address"
                           required 
                           autofocus>
                </div>
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 btn-lg">
                <i class="bi bi-send me-2"></i> Send Reset Link
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="forgot-link">
                <i class="bi bi-arrow-left me-1"></i> Back to Login
            </a>
        </div>
    </div>

    <div class="auth-footer">
        <p class="mb-0">
            Remember your password? 
            <a href="{{ route('login') }}">Log in</a>
        </p>
    </div>
</div>
@endsection