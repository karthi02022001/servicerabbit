@extends('layouts.app')

@section('title', 'Add Service')

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
                                    <i class="bi bi-plus-circle me-1"></i> New Service
                                </span>
                                <h1 class="page-title">Add a Service</h1>
                                <p class="page-description">
                                    Create a new service offering to expand your business and reach more customers.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                            <a href="{{ route('tasker.services.index') }}" class="btn btn-outline-light btn-lg">
                                <i class="bi bi-arrow-left me-2"></i>Back to Services
                            </a>
                        </div>
                    </div>
                </div>

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

                <form action="{{ route('tasker.services.store') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <!-- Service Details -->
                            <div class="section-card mb-4">
                                <div class="section-header">
                                    <h5 class="section-title mb-0">
                                        <i class="bi bi-info-circle text-primary me-2"></i>
                                        Service Details
                                    </h5>
                                </div>
                                <div class="section-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium">Category <span class="text-danger">*</span></label>
                                            <select name="category_id" id="categorySelect" class="form-select form-select-lg" required>
                                                <option value="">Select a category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium">Subcategory</label>
                                            <select name="subcategory_id" id="subcategorySelect" class="form-select form-select-lg">
                                                <option value="">Select subcategory (optional)</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-medium">Service Title <span class="text-danger">*</span></label>
                                            <input type="text" name="title" class="form-control form-control-lg" value="{{ old('title') }}" placeholder="e.g., Professional House Cleaning" required>
                                            <small class="text-muted">A clear, descriptive title for your service</small>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-medium">Description</label>
                                            <textarea name="description" class="form-control" rows="4" placeholder="Describe what you offer, your experience, and what makes your service stand out...">{{ old('description') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pricing -->
                            <div class="section-card mb-4">
                                <div class="section-header">
                                    <h5 class="section-title mb-0">
                                        <i class="bi bi-currency-dollar text-success me-2"></i>
                                        Pricing
                                    </h5>
                                </div>
                                <div class="section-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium">Hourly Rate ($) <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text">$</span>
                                                <input type="number" name="hourly_rate" class="form-control" value="{{ old('hourly_rate') }}" min="1" step="0.01" required>
                                                <span class="input-group-text">/hr</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium">Minimum Hours</label>
                                            <div class="input-group input-group-lg">
                                                <input type="number" name="minimum_hours" class="form-control" value="{{ old('minimum_hours', 1) }}" min="1" max="8">
                                                <span class="input-group-text">hours</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Experience -->
                            <div class="section-card mb-4">
                                <div class="section-header">
                                    <h5 class="section-title mb-0">
                                        <i class="bi bi-briefcase text-warning me-2"></i>
                                        Experience
                                    </h5>
                                </div>
                                <div class="section-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium">Years of Experience</label>
                                            <select name="experience_years" class="form-select form-select-lg">
                                                <option value="">Select experience</option>
                                                <option value="1" {{ old('experience_years') == 1 ? 'selected' : '' }}>Less than 1 year</option>
                                                <option value="2" {{ old('experience_years') == 2 ? 'selected' : '' }}>1-2 years</option>
                                                <option value="3" {{ old('experience_years') == 3 ? 'selected' : '' }}>3-5 years</option>
                                                <option value="5" {{ old('experience_years') == 5 ? 'selected' : '' }}>5-10 years</option>
                                                <option value="10" {{ old('experience_years') == 10 ? 'selected' : '' }}>10+ years</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="col-lg-4">
                            <!-- Status -->
                            <div class="section-card mb-4">
                                <div class="section-header">
                                    <h5 class="section-title mb-0">
                                        <i class="bi bi-toggle-on text-info me-2"></i>
                                        Status
                                    </h5>
                                </div>
                                <div class="section-body">
                                    <div class="form-check form-switch form-switch-lg">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" checked>
                                        <label class="form-check-label" for="isActive">
                                            <strong>Active</strong>
                                            <small class="d-block text-muted">Service is visible to customers</small>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Tips -->
                            <div class="section-card mb-4">
                                <div class="section-header">
                                    <h5 class="section-title mb-0">
                                        <i class="bi bi-lightbulb text-warning me-2"></i>
                                        Tips
                                    </h5>
                                </div>
                                <div class="section-body">
                                    <div class="tip-item">
                                        <i class="bi bi-check-circle text-success"></i>
                                        <span>Use clear, descriptive titles</span>
                                    </div>
                                    <div class="tip-item">
                                        <i class="bi bi-check-circle text-success"></i>
                                        <span>Set competitive pricing</span>
                                    </div>
                                    <div class="tip-item">
                                        <i class="bi bi-check-circle text-success"></i>
                                        <span>Highlight your experience</span>
                                    </div>
                                    <div class="tip-item">
                                        <i class="bi bi-check-circle text-success"></i>
                                        <span>Be specific about what's included</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-plus-lg me-2"></i>Create Service
                                </button>
                                <a href="{{ route('tasker.services.index') }}" class="btn btn-outline-secondary btn-lg">
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

.input-group-lg .input-group-text {
    border-radius: 12px;
    border: 2px solid #e5e7eb;
    background: #f9fafb;
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

/* Tips */
.tip-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
    font-size: 0.9rem;
    color: #4b5563;
}

.tip-item:last-child {
    margin-bottom: 0;
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
}

.btn-outline-secondary,
.btn-outline-light {
    border-radius: 12px;
    font-weight: 600;
}
</style>

<script>
document.getElementById('categorySelect').addEventListener('change', function() {
    const categoryId = this.value;
    const subcategorySelect = document.getElementById('subcategorySelect');
    
    subcategorySelect.innerHTML = '<option value="">Loading...</option>';
    
    if (categoryId) {
        fetch(`/api/categories/${categoryId}/subcategories`)
            .then(response => response.json())
            .then(data => {
                subcategorySelect.innerHTML = '<option value="">Select subcategory (optional)</option>';
                data.forEach(sub => {
                    subcategorySelect.innerHTML += `<option value="${sub.id}">${sub.name}</option>`;
                });
            })
            .catch(() => {
                subcategorySelect.innerHTML = '<option value="">Select subcategory (optional)</option>';
            });
    } else {
        subcategorySelect.innerHTML = '<option value="">Select subcategory (optional)</option>';
    }
});
</script>
@endsection