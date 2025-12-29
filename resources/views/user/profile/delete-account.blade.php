@extends('layouts.app')

@section('title', 'Delete Account')

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
                            <li class="breadcrumb-item active text-danger">Delete Account</li>
                        </ol>
                    </nav>
                    
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="bg-white rounded-4 shadow-sm p-4 border border-danger">
                                <div class="text-center mb-4">
                                    <div class="icon-box bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                        <i class="bi bi-exclamation-triangle fs-1"></i>
                                    </div>
                                    <h4 class="fw-bold text-danger">Delete Your Account?</h4>
                                    <p class="text-muted">This action cannot be undone</p>
                                </div>
                                
                                <div class="alert alert-danger mb-4">
                                    <h6 class="alert-heading fw-semibold">
                                        <i class="bi bi-exclamation-triangle me-2"></i>Warning: Permanent Action
                                    </h6>
                                    <hr>
                                    <p class="mb-0 small">
                                        By deleting your account, you will permanently lose access to:
                                    </p>
                                    <ul class="mb-0 mt-2 small">
                                        <li>All your booking history</li>
                                        <li>All reviews you've written</li>
                                        <li>All messages and conversations</li>
                                        @if(auth()->user()->is_tasker)
                                            <li>Your tasker profile and services</li>
                                            <li>All earnings and pending payouts</li>
                                            <li>All reviews and ratings received</li>
                                        @endif
                                        <li>Your payment methods and transaction history</li>
                                    </ul>
                                </div>
                                
                                @if(auth()->user()->is_tasker)
                                    <div class="alert alert-warning mb-4">
                                        <h6 class="alert-heading fw-semibold">
                                            <i class="bi bi-briefcase me-2"></i>You are also a Tasker
                                        </h6>
                                        <p class="mb-0 small">
                                            Deleting your account will also remove your tasker profile and all associated services. 
                                            Any pending bookings will be cancelled and customers will be notified.
                                        </p>
                                    </div>
                                @endif
                                
                                <form action="{{ route('user.profile.destroy') }}" method="POST" id="deleteAccountForm">
                                    @csrf
                                    @method('DELETE')
                                    
                                    <div class="mb-4">
                                        <label for="password" class="form-label">Confirm Your Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-lock text-muted"></i>
                                            </span>
                                            <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter your current password" required>
                                            <button class="btn btn-outline-secondary border-start-0" type="button" onclick="togglePassword()">
                                                <i class="bi bi-eye" id="passwordIcon"></i>
                                            </button>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="confirmDelete" name="confirm_delete" required>
                                            <label class="form-check-label" for="confirmDelete">
                                                I understand that this action is <strong>permanent</strong> and <strong>cannot be undone</strong>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('user.profile.edit') }}" class="btn btn-secondary flex-grow-1">
                                            <i class="bi bi-arrow-left me-1"></i> Cancel
                                        </a>
                                        <button type="submit" class="btn btn-danger flex-grow-1" id="deleteBtn" disabled>
                                            <i class="bi bi-trash me-1"></i> Delete My Account
                                        </button>
                                    </div>
                                </form>
                            </div>
                            
                            <div class="text-center mt-4">
                                <p class="text-muted small">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Having issues with your account? 
                                    <a href="{{ route('contact') }}">Contact our support team</a> for help.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const field = document.getElementById('password');
    const icon = document.getElementById('passwordIcon');
    
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

// Enable delete button only when checkbox is checked
document.getElementById('confirmDelete').addEventListener('change', function() {
    document.getElementById('deleteBtn').disabled = !this.checked;
});

// Confirm before submission
document.getElementById('deleteAccountForm').addEventListener('submit', function(e) {
    if (!confirm('Are you absolutely sure you want to delete your account? This cannot be undone.')) {
        e.preventDefault();
    }
});
</script>
@endsection