@extends('layouts.app')

@section('title', 'Edit Profile')

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
                            <li class="breadcrumb-item active">Edit Profile</li>
                        </ol>
                    </nav>
                    
                    <div class="row">
                        <div class="col-lg-8">
                            <!-- Profile Form -->
                            <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
                                <h5 class="fw-semibold mb-4">Personal Information</h5>
                                
                                <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    
                                    <!-- Avatar Upload -->
                                    <div class="text-center mb-4">
                                        <div class="avatar-upload position-relative d-inline-block">
                                            @if($user->avatar)
                                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="rounded-circle" id="avatarPreview" style="width: 120px; height: 120px; object-fit: cover;">
                                            @else
                                                <div class="avatar-initials bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" id="avatarInitials" style="width: 120px; height: 120px; font-size: 2rem;">
                                                    {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                                                </div>
                                                <img src="" alt="Avatar" class="rounded-circle d-none" id="avatarPreview" style="width: 120px; height: 120px; object-fit: cover;">
                                            @endif
                                            <label for="avatar" class="avatar-edit-btn position-absolute bottom-0 end-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; cursor: pointer;">
                                                <i class="bi bi-camera"></i>
                                            </label>
                                            <input type="file" name="avatar" id="avatar" class="d-none" accept="image/*">
                                        </div>
                                        @if($user->avatar)
                                            <div class="mt-2">
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="document.getElementById('removeAvatarForm').submit();">
                                                    <i class="bi bi-trash me-1"></i> Remove Photo
                                                </button>
                                            </div>
                                        @endif
                                        @error('avatar')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            @if(!$user->email_verified_at)
                                                <div class="text-warning small mt-1">
                                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                                    Email not verified. <a href="{{ route('verification.send') }}">Resend verification</a>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                                            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}">
                                            @error('date_of_birth')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="gender" class="form-label">Gender</label>
                                            <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                                <option value="">Select Gender</option>
                                                <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Female</option>
                                                <option value="other" {{ old('gender', $user->gender) === 'other' ? 'selected' : '' }}>Other</option>
                                                <option value="prefer_not_to_say" {{ old('gender', $user->gender) === 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="bio" class="form-label">About Me</label>
                                            <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="3" placeholder="Tell us a little about yourself...">{{ old('bio', $user->bio) }}</textarea>
                                            @error('bio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <hr class="my-4">
                                    
                                    <h5 class="fw-semibold mb-4">Address Information</h5>
                                    
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="address_line_1" class="form-label">Address Line 1</label>
                                            <input type="text" class="form-control @error('address_line_1') is-invalid @enderror" id="address_line_1" name="address_line_1" value="{{ old('address_line_1', $user->address_line_1) }}" placeholder="Street address">
                                            @error('address_line_1')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="address_line_2" class="form-label">Address Line 2</label>
                                            <input type="text" class="form-control @error('address_line_2') is-invalid @enderror" id="address_line_2" name="address_line_2" value="{{ old('address_line_2', $user->address_line_2) }}" placeholder="Apartment, suite, unit, etc.">
                                            @error('address_line_2')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="city" class="form-label">City</label>
                                            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city', $user->city) }}">
                                            @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="state" class="form-label">State / Province</label>
                                            <input type="text" class="form-control @error('state') is-invalid @enderror" id="state" name="state" value="{{ old('state', $user->state) }}">
                                            @error('state')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="postal_code" class="form-label">Postal Code</label>
                                            <input type="text" class="form-control @error('postal_code') is-invalid @enderror" id="postal_code" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}">
                                            @error('postal_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="country_code" class="form-label">Country</label>
                                            <select class="form-select @error('country_code') is-invalid @enderror" id="country_code" name="country_code">
                                                <option value="US" {{ old('country_code', $user->country_code) === 'US' ? 'selected' : '' }}>United States</option>
                                                <option value="CA" {{ old('country_code', $user->country_code) === 'CA' ? 'selected' : '' }}>Canada</option>
                                                <option value="GB" {{ old('country_code', $user->country_code) === 'GB' ? 'selected' : '' }}>United Kingdom</option>
                                                <option value="AU" {{ old('country_code', $user->country_code) === 'AU' ? 'selected' : '' }}>Australia</option>
                                            </select>
                                            @error('country_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-lg me-1"></i> Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <!-- Account Settings -->
                            <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
                                <h5 class="fw-semibold mb-4">Account Settings</h5>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('user.profile.change-password') }}" class="btn btn-outline-primary text-start">
                                        <i class="bi bi-key me-2"></i> Change Password
                                    </a>
                                    <a href="{{ route('user.notifications.preferences') }}" class="btn btn-outline-primary text-start">
                                        <i class="bi bi-bell me-2"></i> Notification Settings
                                    </a>
                                    @if(!$user->is_tasker)
                                        <a href="{{ route('become-tasker') }}" class="btn btn-outline-success text-start">
                                            <i class="bi bi-briefcase me-2"></i> Become a Tasker
                                        </a>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Account Info -->
                            <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
                                <h5 class="fw-semibold mb-4">Account Info</h5>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-3">
                                        <small class="text-muted d-block">Member Since</small>
                                        <span>{{ $user->created_at->format('F d, Y') }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <small class="text-muted d-block">Email Status</small>
                                        @if($user->email_verified_at)
                                            <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Verified</span>
                                        @else
                                            <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i> Not Verified</span>
                                        @endif
                                    </li>
                                    <li class="mb-3">
                                        <small class="text-muted d-block">Account Type</small>
                                        @if($user->is_tasker)
                                            <span class="badge bg-primary"><i class="bi bi-briefcase me-1"></i> User & Tasker</span>
                                        @else
                                            <span class="badge bg-secondary"><i class="bi bi-person me-1"></i> User</span>
                                        @endif
                                    </li>
                                    @if($user->last_login_at)
                                        <li>
                                            <small class="text-muted d-block">Last Login</small>
                                            <span>{{ $user->last_login_at->diffForHumans() }}</span>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            
                            <!-- Danger Zone -->
                            <div class="bg-white rounded-4 shadow-sm p-4 border border-danger">
                                <h5 class="fw-semibold text-danger mb-3">Danger Zone</h5>
                                <p class="text-muted small mb-3">Once you delete your account, there is no going back. Please be certain.</p>
                                <a href="{{ route('user.profile.delete') }}" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash me-1"></i> Delete Account
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden form for avatar removal -->
<form id="removeAvatarForm" action="{{ route('user.profile.remove-avatar') }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

<script>
document.getElementById('avatar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatarPreview').src = e.target.result;
            document.getElementById('avatarPreview').classList.remove('d-none');
            const initials = document.getElementById('avatarInitials');
            if (initials) {
                initials.classList.add('d-none');
            }
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection