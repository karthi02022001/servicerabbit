@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <div class="auth-icon">
            <i class="bi bi-shield-lock"></i>
        </div>
        <h1>Reset Password</h1>
        <p>Create a new secure password for your account</p>
    </div>

    <div class="auth-body">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-floating mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" value="{{ old('email', $email ?? '') }}" 
                       placeholder="name@example.com" required autofocus>
                <label for="email"><i class="bi bi-envelope me-2"></i>Email Address</label>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                       id="password" name="password" placeholder="New Password" required>
                <label for="password"><i class="bi bi-lock me-2"></i>New Password</label>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating mb-4">
                <input type="password" class="form-control" id="password_confirmation" 
                       name="password_confirmation" placeholder="Confirm New Password" required>
                <label for="password_confirmation"><i class="bi bi-lock-fill me-2"></i>Confirm New Password</label>
            </div>

            <button type="submit" class="btn btn-primary w-100 btn-lg">
                <i class="bi bi-check-lg me-2"></i>Reset Password
            </button>
        </form>
    </div>

    <div class="auth-footer">
        <p><i class="bi bi-arrow-left me-1"></i><a href="{{ route('login') }}">Back to Login</a></p>
    </div>
</div>
@endsection