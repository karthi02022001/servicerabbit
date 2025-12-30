@extends('layouts.app')

@section('title', 'Become a Tasker - Profile')

@section('content')
<div class="registration-container">
    <div class="container py-5">
        <!-- Progress Steps -->
        <div class="progress-steps mb-5">
            <div class="step-item active">
                <div class="step-circle">1</div>
                <span class="step-label">Profile</span>
            </div>
            <div class="step-line"></div>
            <div class="step-item">
                <div class="step-circle">2</div>
                <span class="step-label">Services</span>
            </div>
            <div class="step-line"></div>
            <div class="step-item">
                <div class="step-circle">3</div>
                <span class="step-label">Availability</span>
            </div>
            <div class="step-line"></div>
            <div class="step-item">
                <div class="step-circle">4</div>
                <span class="step-label">Verification</span>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="step-card">
                    <div class="step-header">
                        <h2><i class="bi bi-person-circle me-2"></i>Tell Us About Yourself</h2>
                        <p>Create a profile that helps customers know you better</p>
                    </div>

                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('tasker.register.step1.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Avatar Upload -->
                        <div class="avatar-upload-section mb-4">
                            <div class="avatar-preview" id="avatarPreview">
                                @if(auth()->user()->avatar)
                                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar">
                                @else
                                    <i class="bi bi-person"></i>
                                @endif
                            </div>
                            <div class="avatar-info">
                                <h5>Profile Photo</h5>
                                <p class="text-muted">Upload a professional photo. Max 2MB, JPG or PNG.</p>
                                <label for="avatar" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-camera me-1"></i> Upload Photo
                                </label>
                                <input type="file" id="avatar" name="avatar" class="d-none" accept="image/jpeg,image/png">
                            </div>
                        </div>

                        <!-- Headline -->
                        <div class="mb-4">
                            <label class="form-label">Professional Headline <span class="text-danger">*</span></label>
                            <input type="text" name="headline" class="form-control form-control-lg" 
                                value="{{ old('headline', $profile->headline) }}" 
                                placeholder="e.g., Expert House Cleaner with 5+ Years Experience"
                                maxlength="100" required>
                            <div class="form-text">A catchy headline that describes your expertise (max 100 characters)</div>
                        </div>

                        <!-- Bio -->
                        <div class="mb-4">
                            <label class="form-label">Professional Bio <span class="text-danger">*</span></label>
                            <textarea name="professional_bio" class="form-control" rows="5" 
                                placeholder="Tell customers about your skills, experience, and what makes you great at what you do..."
                                minlength="50" maxlength="1000" required>{{ old('professional_bio', $profile->professional_bio) }}</textarea>
                            <div class="form-text">Minimum 50 characters, maximum 1000 characters</div>
                        </div>

                        <div class="row">
                            <!-- Experience -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Years of Experience <span class="text-danger">*</span></label>
                                <select name="years_of_experience" class="form-select form-select-lg" required>
                                    <option value="">Select...</option>
                                    <option value="0" {{ old('years_of_experience', $profile->years_of_experience) == '0' ? 'selected' : '' }}>Less than 1 year</option>
                                    <option value="1" {{ old('years_of_experience', $profile->years_of_experience) == '1' ? 'selected' : '' }}>1 year</option>
                                    <option value="2" {{ old('years_of_experience', $profile->years_of_experience) == '2' ? 'selected' : '' }}>2 years</option>
                                    <option value="3" {{ old('years_of_experience', $profile->years_of_experience) == '3' ? 'selected' : '' }}>3 years</option>
                                    <option value="5" {{ old('years_of_experience', $profile->years_of_experience) == '5' ? 'selected' : '' }}>5+ years</option>
                                    <option value="10" {{ old('years_of_experience', $profile->years_of_experience) == '10' ? 'selected' : '' }}>10+ years</option>
                                </select>
                            </div>

                            <!-- Work Radius -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Work Radius (km) <span class="text-danger">*</span></label>
                                <select name="work_radius_km" class="form-select form-select-lg" required>
                                    <option value="5" {{ old('work_radius_km', $profile->work_radius_km ?? 50) == '5' ? 'selected' : '' }}>5 km</option>
                                    <option value="10" {{ old('work_radius_km', $profile->work_radius_km ?? 50) == '10' ? 'selected' : '' }}>10 km</option>
                                    <option value="25" {{ old('work_radius_km', $profile->work_radius_km ?? 50) == '25' ? 'selected' : '' }}>25 km</option>
                                    <option value="50" {{ old('work_radius_km', $profile->work_radius_km ?? 50) == '50' ? 'selected' : '' }}>50 km</option>
                                    <option value="100" {{ old('work_radius_km', $profile->work_radius_km ?? 50) == '100' ? 'selected' : '' }}>100 km</option>
                                </select>
                                <div class="form-text">How far you're willing to travel for tasks</div>
                            </div>
                        </div>

                        <!-- Vehicle Section -->
                        <div class="vehicle-section mb-4">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="has_vehicle" name="has_vehicle" value="1"
                                    {{ old('has_vehicle', $profile->has_vehicle) ? 'checked' : '' }}>
                                <label class="form-check-label" for="has_vehicle">
                                    <strong>I have a vehicle for work</strong>
                                </label>
                            </div>
                            
                            <div id="vehicleDetails" class="{{ old('has_vehicle', $profile->has_vehicle) ? '' : 'd-none' }}">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Vehicle Type</label>
                                        <select name="vehicle_type" class="form-select">
                                            <option value="">Select vehicle type...</option>
                                            <option value="bicycle" {{ old('vehicle_type', $profile->vehicle_type) == 'bicycle' ? 'selected' : '' }}>Bicycle</option>
                                            <option value="motorcycle" {{ old('vehicle_type', $profile->vehicle_type) == 'motorcycle' ? 'selected' : '' }}>Motorcycle</option>
                                            <option value="car" {{ old('vehicle_type', $profile->vehicle_type) == 'car' ? 'selected' : '' }}>Car</option>
                                            <option value="minivan" {{ old('vehicle_type', $profile->vehicle_type) == 'minivan' ? 'selected' : '' }}>Minivan</option>
                                            <option value="pickup_truck" {{ old('vehicle_type', $profile->vehicle_type) == 'pickup_truck' ? 'selected' : '' }}>Pickup Truck</option>
                                            <option value="moving_truck" {{ old('vehicle_type', $profile->vehicle_type) == 'moving_truck' ? 'selected' : '' }}>Moving Truck</option>
                                            <option value="van" {{ old('vehicle_type', $profile->vehicle_type) == 'van' ? 'selected' : '' }}>Van</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Vehicle Description</label>
                                        <input type="text" name="vehicle_description" class="form-control"
                                            value="{{ old('vehicle_description', $profile->vehicle_description) }}"
                                            placeholder="e.g., Blue Toyota Camry 2020">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="step-actions">
                            <a href="{{ route('become-tasker') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="bi bi-arrow-left me-2"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                Continue <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.registration-container { background: #f8f9fa; min-height: calc(100vh - 80px); }
.progress-steps { display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0 1rem; }
.step-item { display: flex; flex-direction: column; align-items: center; gap: 0.5rem; }
.step-circle { width: 45px; height: 45px; border-radius: 50%; background: #e5e7eb; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #6b7280; transition: all 0.3s; }
.step-item.active .step-circle, .step-item.completed .step-circle { background: linear-gradient(135deg, #FF6B35, #e55a2b); color: white; }
.step-item.completed .step-circle::after { content: '✓'; }
.step-label { font-size: 0.8rem; color: #6b7280; font-weight: 500; }
.step-item.active .step-label { color: #FF6B35; font-weight: 600; }
.step-line { flex: 1; max-width: 100px; height: 3px; background: #e5e7eb; }
.step-card { background: white; border-radius: 20px; padding: 2.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
.step-header { margin-bottom: 2rem; }
.step-header h2 { font-size: 1.5rem; font-weight: 700; color: #1A1A2E; margin-bottom: 0.5rem; }
.step-header p { color: #6b7280; margin: 0; }
.avatar-upload-section { display: flex; align-items: center; gap: 1.5rem; padding: 1.5rem; background: #f9fafb; border-radius: 16px; }
.avatar-preview { width: 100px; height: 100px; border-radius: 50%; background: linear-gradient(135deg, #FF6B35, #ff8c5a); display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0; }
.avatar-preview i { font-size: 2.5rem; color: white; }
.avatar-preview img { width: 100%; height: 100%; object-fit: cover; }
.avatar-info h5 { font-weight: 600; margin-bottom: 0.25rem; }
.vehicle-section { padding: 1.5rem; background: #f9fafb; border-radius: 16px; }
.step-actions { display: flex; justify-content: space-between; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #e5e7eb; }
.btn-lg { padding: 0.875rem 2rem; border-radius: 12px; font-weight: 600; }
@media (max-width: 767.98px) { .progress-steps { flex-wrap: wrap; } .step-line { display: none; } .step-card { padding: 1.5rem; } }
</style>
@endpush

@push('scripts')
<script>
document.getElementById('avatar').addEventListener('change', function(e) {
    if (e.target.files && e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatarPreview').innerHTML = '<img src="' + e.target.result + '" alt="Avatar">';
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});

document.getElementById('has_vehicle').addEventListener('change', function() {
    document.getElementById('vehicleDetails').classList.toggle('d-none', !this.checked);
});
</script>
@endpush