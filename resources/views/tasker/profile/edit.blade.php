@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="dashboard-wrapper">
    <div class="container-fluid px-4 py-4">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3 col-xl-2">
                @include('tasker.partials.sidebar')
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-9 col-xl-10">
                <!-- Page Header -->
                <div class="page-header-card mb-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="page-header-content">
                                <span class="page-badge">
                                    <i class="bi bi-person-gear me-1"></i> Profile
                                </span>
                                <h1 class="page-title">Edit Profile</h1>
                                <p class="page-description">
                                    Update your profile information to attract more customers. A complete profile builds trust.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-4 d-none d-lg-block">
                            <div class="page-header-illustration">
                                <img src="https://illustrations.popsy.co/amber/woman-with-a-laptop.svg" alt="Profile" class="img-fluid" style="max-height: 150px;">
                            </div>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('tasker.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <!-- Profile Photo -->
                        <div class="col-lg-4">
                            <div class="section-card">
                                <div class="section-header">
                                    <h5 class="section-title mb-0">
                                        <i class="bi bi-camera text-primary me-2"></i>
                                        Profile Photo
                                    </h5>
                                </div>
                                <div class="section-body text-center">
                                    <div class="profile-photo-wrapper">
                                        <div class="profile-photo-preview" id="photoPreview">
                                            @if($user->avatar)
                                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->full_name }}" id="previewImage">
                                            @else
                                                <span class="photo-initials" id="photoInitials">{{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}</span>
                                            @endif
                                        </div>
                                        <label for="avatar" class="photo-upload-btn">
                                            <i class="bi bi-camera"></i>
                                        </label>
                                        <input type="file" name="avatar" id="avatar" class="d-none" accept="image/*" onchange="previewPhoto(this)">
                                    </div>
                                    <h5 class="mt-3 mb-1">{{ $user->full_name }}</h5>
                                    <p class="text-muted mb-0">
                                        @if($profile->verification_status === 'approved')
                                            <span class="badge bg-success"><i class="bi bi-patch-check-fill me-1"></i>Verified</span>
                                        @else
                                            <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>{{ ucfirst($profile->verification_status) }}</span>
                                        @endif
                                    </p>
                                    <small class="text-muted">Click the camera icon to change photo</small>
                                </div>
                            </div>

                            <!-- Availability Toggle -->
                            <div class="section-card mt-4">
                                <div class="section-header">
                                    <h5 class="section-title mb-0">
                                        <i class="bi bi-toggle-on text-success me-2"></i>
                                        Availability
                                    </h5>
                                </div>
                                <div class="section-body">
                                    <div class="form-check form-switch form-switch-lg">
                                        <input class="form-check-input" type="checkbox" name="is_available" id="isAvailable" {{ $profile->is_available ? 'checked' : '' }}>
                                        <label class="form-check-label" for="isAvailable">
                                            <strong>{{ $profile->is_available ? 'Available' : 'Unavailable' }}</strong>
                                            <small class="d-block text-muted">Toggle to accept/pause bookings</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Details -->
                        <div class="col-lg-8">
                            <!-- Basic Info -->
                            <div class="section-card mb-4">
                                <div class="section-header">
                                    <h5 class="section-title mb-0">
                                        <i class="bi bi-person text-primary me-2"></i>
                                        Basic Information
                                    </h5>
                                </div>
                                <div class="section-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium">First Name</label>
                                            <input type="text" name="first_name" class="form-control form-control-lg" value="{{ old('first_name', $user->first_name) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium">Last Name</label>
                                            <input type="text" name="last_name" class="form-control form-control-lg" value="{{ old('last_name', $user->last_name) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium">Email</label>
                                            <input type="email" class="form-control form-control-lg" value="{{ $user->email }}" disabled>
                                            <small class="text-muted">Email cannot be changed</small>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium">Phone</label>
                                            <input type="tel" name="phone" class="form-control form-control-lg" value="{{ old('phone', $user->phone) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Professional Info -->
                            <div class="section-card mb-4">
                                <div class="section-header">
                                    <h5 class="section-title mb-0">
                                        <i class="bi bi-briefcase text-warning me-2"></i>
                                        Professional Information
                                    </h5>
                                </div>
                                <div class="section-body">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label fw-medium">Headline</label>
                                            <input type="text" name="headline" class="form-control form-control-lg" value="{{ old('headline', $profile->headline) }}" placeholder="e.g., Professional Handyman with 10+ years experience">
                                            <small class="text-muted">A short tagline that appears below your name</small>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-medium">Bio</label>
                                            <textarea name="bio" class="form-control" rows="4" placeholder="Tell customers about yourself, your experience, and what makes you great at what you do...">{{ old('bio', $profile->bio) }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium">Years of Experience</label>
                                            <input type="number" name="years_experience" class="form-control form-control-lg" value="{{ old('years_experience', $profile->years_experience) }}" min="0" max="50">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium">Work Radius (miles)</label>
                                            <input type="number" name="work_radius" class="form-control form-control-lg" value="{{ old('work_radius', $profile->work_radius ?? 25) }}" min="1" max="100">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="section-card mb-4">
                                <div class="section-header">
                                    <h5 class="section-title mb-0">
                                        <i class="bi bi-geo-alt text-danger me-2"></i>
                                        Location
                                    </h5>
                                </div>
                                <div class="section-body">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label fw-medium">Address</label>
                                            <input type="text" name="address" class="form-control form-control-lg" value="{{ old('address', $user->address) }}" placeholder="Street address">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-medium">City</label>
                                            <input type="text" name="city" class="form-control form-control-lg" value="{{ old('city', $user->city) }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-medium">State</label>
                                            <input type="text" name="state" class="form-control form-control-lg" value="{{ old('state', $user->state) }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-medium">ZIP Code</label>
                                            <input type="text" name="zip_code" class="form-control form-control-lg" value="{{ old('zip_code', $user->zip_code) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Vehicle Info -->
                            <div class="section-card mb-4">
                                <div class="section-header">
                                    <h5 class="section-title mb-0">
                                        <i class="bi bi-truck text-info me-2"></i>
                                        Vehicle Information
                                    </h5>
                                </div>
                                <div class="section-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-check form-switch form-switch-lg">
                                                <input class="form-check-input" type="checkbox" name="has_vehicle" id="hasVehicle" {{ $profile->has_vehicle ? 'checked' : '' }}>
                                                <label class="form-check-label" for="hasVehicle">
                                                    <strong>I have a vehicle</strong>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium">Vehicle Type</label>
                                            <select name="vehicle_type" class="form-select form-select-lg">
                                                <option value="">Select vehicle type</option>
                                                <option value="car" {{ $profile->vehicle_type == 'car' ? 'selected' : '' }}>Car</option>
                                                <option value="suv" {{ $profile->vehicle_type == 'suv' ? 'selected' : '' }}>SUV</option>
                                                <option value="truck" {{ $profile->vehicle_type == 'truck' ? 'selected' : '' }}>Truck</option>
                                                <option value="van" {{ $profile->vehicle_type == 'van' ? 'selected' : '' }}>Van</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-medium">Vehicle Description</label>
                                            <input type="text" name="vehicle_description" class="form-control form-control-lg" value="{{ old('vehicle_description', $profile->vehicle_description) }}" placeholder="e.g., 2020 Ford F-150, white">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Settings -->
                            <div class="section-card mb-4">
                                <div class="section-header">
                                    <h5 class="section-title mb-0">
                                        <i class="bi bi-gear text-secondary me-2"></i>
                                        Booking Settings
                                    </h5>
                                </div>
                                <div class="section-body">
                                    <div class="form-check form-switch form-switch-lg">
                                        <input class="form-check-input" type="checkbox" name="instant_booking" id="instantBooking" {{ $profile->instant_booking ? 'checked' : '' }}>
                                        <label class="form-check-label" for="instantBooking">
                                            <strong>Enable Instant Booking</strong>
                                            <small class="d-block text-muted">Allow customers to book without waiting for approval</small>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-flex gap-3">
                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    <i class="bi bi-check-lg me-2"></i>Save Changes
                                </button>
                                <a href="{{ route('tasker.dashboard') }}" class="btn btn-outline-secondary btn-lg">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* Dashboard Wrapper */
.dashboard-wrapper {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    min-height: calc(100vh - 76px);
}

/* Page Header Card */
.page-header-card {
    background: linear-gradient(135deg, #FF6B35 0%, #ff8c5a 50%, #ffab7a 100%);
    border-radius: 24px;
    padding: 2rem 2.5rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(255, 107, 53, 0.3);
}

.page-header-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
}

.page-badge {
    display: inline-block;
    background: rgba(255,255,255,0.2);
    color: white;
    padding: 0.35rem 1rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 500;
    margin-bottom: 0.75rem;
}

.page-title {
    color: white;
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.page-description {
    color: rgba(255,255,255,0.9);
    font-size: 1rem;
    margin: 0;
}

.page-header-illustration img {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

/* Section Card */
.section-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    overflow: hidden;
}

.section-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #f3f4f6;
}

.section-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.section-body {
    padding: 1.5rem;
}

/* Profile Photo */
.profile-photo-wrapper {
    position: relative;
    display: inline-block;
}

.profile-photo-preview {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background: linear-gradient(135deg, #FF6B35, #ff8c5a);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    border: 5px solid #f3f4f6;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.profile-photo-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.photo-initials {
    font-size: 3rem;
    font-weight: 700;
    color: white;
}

.photo-upload-btn {
    position: absolute;
    bottom: 5px;
    right: 5px;
    width: 40px;
    height: 40px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    color: #FF6B35;
    font-size: 1.1rem;
    transition: all 0.3s;
}

.photo-upload-btn:hover {
    background: #FF6B35;
    color: white;
    transform: scale(1.1);
}

/* Form Controls */
.form-control-lg,
.form-select-lg {
    border-radius: 12px;
    border: 2px solid #e5e7eb;
    padding: 0.75rem 1rem;
    font-size: 1rem;
}

.form-control-lg:focus,
.form-select-lg:focus {
    border-color: #FF6B35;
    box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
}

/* Form Switch */
.form-switch-lg .form-check-input {
    width: 3rem;
    height: 1.5rem;
    cursor: pointer;
}

.form-switch-lg .form-check-input:checked {
    background-color: #10b981;
    border-color: #10b981;
}

.form-check-label {
    margin-left: 0.5rem;
}

/* Buttons */
.btn-primary {
    background: linear-gradient(135deg, #FF6B35, #ff8c5a);
    border: none;
    border-radius: 12px;
    font-weight: 600;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #e55a2b, #FF6B35);
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(255, 107, 53, 0.3);
}

.btn-outline-secondary {
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-weight: 600;
}

/* Responsive */
@media (max-width: 991.98px) {
    .page-header-card {
        padding: 1.5rem;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
}
</style>

<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('photoPreview');
            const initials = document.getElementById('photoInitials');
            if (initials) {
                initials.remove();
            }
            let img = document.getElementById('previewImage');
            if (!img) {
                img = document.createElement('img');
                img.id = 'previewImage';
                preview.appendChild(img);
            }
            img.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection