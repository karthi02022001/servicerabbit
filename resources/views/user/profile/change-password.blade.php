@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
<div class="dashboard-wrapper">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 col-xl-2 d-none d-lg-block">
                @include('user.partials.sidebar')
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-9 col-xl-10">
                <div class="dashboard-content py-4">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('user.profile.edit') }}">Profile</a></li>
                            <li class="breadcrumb-item active">Change Password</li>
                        </ol>
                    </nav>
                    
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="bg-white rounded-4 shadow-sm p-4">
                                <div class="text-center mb-4">
                                    <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <i class="bi bi-key fs-4"></i>
                                    </div>
                                    <h5 class="fw-semibold">Change Your Password</h5>
                                    <p class="text-muted small">Enter your current password and choose a new one</p>
                                </div>
                                
                                <form action="{{ route('user.profile.change-password') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Current Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-lock text-muted"></i>
                                            </span>
                                            <input type="password" class="form-control border-start-0 @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
                                            <button class="btn btn-outline-secondary border-start-0" type="button" onclick="togglePassword('current_password')">
                                                <i class="bi bi-eye" id="current_password_icon"></i>
                                            </button>
                                            @error('current_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="password" class="form-label">New Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-key text-muted"></i>
                                            </span>
                                            <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" id="password" name="password" required>
                                            <button class="btn btn-outline-secondary border-start-0" type="button" onclick="togglePassword('password')">
                                                <i class="bi bi-eye" id="password_icon"></i>
                                            </button>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="password-strength mt-2">
                                            <div class="progress" style="height: 4px;">
                                                <div class="progress-bar" id="strengthBar" role="progressbar" style="width: 0%"></div>
                                            </div>
                                            <small class="text-muted" id="strengthText">Password strength</small>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="password_confirmation" class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-key text-muted"></i>
                                            </span>
                                            <input type="password" class="form-control border-start-0" id="password_confirmation" name="password_confirmation" required>
                                            <button class="btn btn-outline-secondary border-start-0" type="button" onclick="togglePassword('password_confirmation')">
                                                <i class="bi bi-eye" id="password_confirmation_icon"></i>
                                            </button>
                                        </div>
                                        <div id="passwordMatch" class="mt-1"></div>
                                    </div>
                                    
                                    <div class="alert alert-info small mb-4">
                                        <i class="bi bi-info-circle me-2"></i>
                                        <strong>Password requirements:</strong>
                                        <ul class="mb-0 mt-2">
                                            <li>At least 8 characters long</li>
                                            <li>Include at least one uppercase letter</li>
                                            <li>Include at least one number</li>
                                            <li>Include at least one special character (!@#$%^&*)</li>
                                        </ul>
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary flex-grow-1">
                                            <i class="bi bi-check-lg me-1"></i> Update Password
                                        </button>
                                        <a href="{{ route('user.profile.edit') }}" class="btn btn-outline-secondary">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '_icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}

// Password strength indicator
document.getElementById('password').addEventListener('input', function(e) {
    const password = e.target.value;
    const bar = document.getElementById('strengthBar');
    const text = document.getElementById('strengthText');
    
    let strength = 0;
    
    if (password.length >= 8) strength += 25;
    if (password.match(/[a-z]/)) strength += 25;
    if (password.match(/[A-Z]/)) strength += 25;
    if (password.match(/[0-9]/)) strength += 12.5;
    if (password.match(/[^a-zA-Z0-9]/)) strength += 12.5;
    
    bar.style.width = strength + '%';
    
    if (strength < 25) {
        bar.className = 'progress-bar bg-danger';
        text.textContent = 'Very Weak';
        text.className = 'text-danger small';
    } else if (strength < 50) {
        bar.className = 'progress-bar bg-warning';
        text.textContent = 'Weak';
        text.className = 'text-warning small';
    } else if (strength < 75) {
        bar.className = 'progress-bar bg-info';
        text.textContent = 'Fair';
        text.className = 'text-info small';
    } else if (strength < 100) {
        bar.className = 'progress-bar bg-primary';
        text.textContent = 'Good';
        text.className = 'text-primary small';
    } else {
        bar.className = 'progress-bar bg-success';
        text.textContent = 'Strong';
        text.className = 'text-success small';
    }
    
    checkPasswordMatch();
});

// Password match indicator
document.getElementById('password_confirmation').addEventListener('input', checkPasswordMatch);

function checkPasswordMatch() {
    const password = document.getElementById('password').value;
    const confirm = document.getElementById('password_confirmation').value;
    const matchDiv = document.getElementById('passwordMatch');
    
    if (confirm.length === 0) {
        matchDiv.innerHTML = '';
        return;
    }
    
    if (password === confirm) {
        matchDiv.innerHTML = '<small class="text-success"><i class="bi bi-check-circle me-1"></i>Passwords match</small>';
    } else {
        matchDiv.innerHTML = '<small class="text-danger"><i class="bi bi-x-circle me-1"></i>Passwords do not match</small>';
    }
}
</script>
@endsection