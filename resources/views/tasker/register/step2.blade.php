@extends('layouts.app')

@section('title', 'Become a Tasker - Services')

@section('content')
<div class="registration-container">
    <div class="container py-5">
        <!-- Progress Steps -->
        <div class="progress-steps mb-5">
            <div class="step-item completed">
                <div class="step-circle"><i class="bi bi-check"></i></div>
                <span class="step-label">Profile</span>
            </div>
            <div class="step-line active"></div>
            <div class="step-item active">
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
            <div class="col-lg-10">
                <div class="step-card">
                    <div class="step-header">
                        <h2><i class="bi bi-grid-3x3-gap me-2"></i>Select Your Services</h2>
                        <p>Choose the categories you want to offer and set your hourly rates</p>
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

                    <form action="{{ route('tasker.register.step2.store') }}" method="POST" id="servicesForm">
                        @csrf
                        
                        <!-- Services List -->
                        <div id="servicesList">
                            @if($selectedServices->count() > 0)
                                @foreach($selectedServices as $index => $service)
                                <div class="service-item" data-index="{{ $index }}">
                                    <div class="service-item-header">
                                        <h5>Service #{{ $index + 1 }}</h5>
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-service" onclick="removeService(this)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Category <span class="text-danger">*</span></label>
                                            <select name="services[{{ $index }}][category_id]" class="form-select category-select" required>
                                                <option value="">Select category...</option>
                                                @foreach($categories as $category)
                                                <option value="{{ $category->id }}" 
                                                    data-subcategories="{{ json_encode($category->subcategories) }}"
                                                    {{ $service->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Subcategory</label>
                                            <select name="services[{{ $index }}][subcategory_id]" class="form-select subcategory-select">
                                                <option value="">Select subcategory...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Service Title <span class="text-danger">*</span></label>
                                            <input type="text" name="services[{{ $index }}][title]" class="form-control" 
                                                value="{{ $service->title }}" placeholder="e.g., Deep House Cleaning" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Hourly Rate ($) <span class="text-danger">*</span></label>
                                            <input type="number" name="services[{{ $index }}][hourly_rate]" class="form-control" 
                                                value="{{ $service->hourly_rate }}" min="10" max="500" step="1" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Experience</label>
                                            <select name="services[{{ $index }}][experience_years]" class="form-select">
                                                <option value="">Select...</option>
                                                <option value="0" {{ $service->experience_years == 0 ? 'selected' : '' }}>&lt;1 year</option>
                                                <option value="1" {{ $service->experience_years == 1 ? 'selected' : '' }}>1 year</option>
                                                <option value="2" {{ $service->experience_years == 2 ? 'selected' : '' }}>2 years</option>
                                                <option value="3" {{ $service->experience_years == 3 ? 'selected' : '' }}>3+ years</option>
                                                <option value="5" {{ $service->experience_years == 5 ? 'selected' : '' }}>5+ years</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Description</label>
                                            <textarea name="services[{{ $index }}][description]" class="form-control" rows="2" 
                                                placeholder="Briefly describe what's included...">{{ $service->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="service-item" data-index="0">
                                    <div class="service-item-header">
                                        <h5>Service #1</h5>
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-service d-none" onclick="removeService(this)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Category <span class="text-danger">*</span></label>
                                            <select name="services[0][category_id]" class="form-select category-select" required>
                                                <option value="">Select category...</option>
                                                @foreach($categories as $category)
                                                <option value="{{ $category->id }}" data-subcategories="{{ json_encode($category->subcategories) }}">
                                                    {{ $category->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Subcategory</label>
                                            <select name="services[0][subcategory_id]" class="form-select subcategory-select">
                                                <option value="">Select subcategory...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Service Title <span class="text-danger">*</span></label>
                                            <input type="text" name="services[0][title]" class="form-control" 
                                                placeholder="e.g., Deep House Cleaning" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Hourly Rate ($) <span class="text-danger">*</span></label>
                                            <input type="number" name="services[0][hourly_rate]" class="form-control" 
                                                value="35" min="10" max="500" step="1" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Experience</label>
                                            <select name="services[0][experience_years]" class="form-select">
                                                <option value="">Select...</option>
                                                <option value="0">&lt;1 year</option>
                                                <option value="1">1 year</option>
                                                <option value="2">2 years</option>
                                                <option value="3">3+ years</option>
                                                <option value="5">5+ years</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Description</label>
                                            <textarea name="services[0][description]" class="form-control" rows="2" 
                                                placeholder="Briefly describe what's included..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Add Service Button -->
                        <button type="button" class="btn btn-outline-primary w-100 mt-3" id="addServiceBtn">
                            <i class="bi bi-plus-circle me-2"></i> Add Another Service
                        </button>

                        <!-- Tips -->
                        <div class="tips-card mt-4">
                            <h6><i class="bi bi-lightbulb me-2"></i>Tips for Setting Rates</h6>
                            <ul class="mb-0">
                                <li>Research local market rates for similar services</li>
                                <li>Consider your experience and skill level</li>
                                <li>Start competitive and raise rates as you get reviews</li>
                                <li>Average tasker rates: $25-$50/hour</li>
                            </ul>
                        </div>

                        <!-- Actions -->
                        <div class="step-actions">
                            <a href="{{ route('tasker.register.step1') }}" class="btn btn-outline-secondary btn-lg">
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

<!-- Service Template -->
<template id="serviceTemplate">
    <div class="service-item" data-index="INDEX">
        <div class="service-item-header">
            <h5>Service #NUM</h5>
            <button type="button" class="btn btn-sm btn-outline-danger remove-service" onclick="removeService(this)">
                <i class="bi bi-trash"></i>
            </button>
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Category <span class="text-danger">*</span></label>
                <select name="services[INDEX][category_id]" class="form-select category-select" required>
                    <option value="">Select category...</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" data-subcategories="{{ json_encode($category->subcategories) }}">
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Subcategory</label>
                <select name="services[INDEX][subcategory_id]" class="form-select subcategory-select">
                    <option value="">Select subcategory...</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Service Title <span class="text-danger">*</span></label>
                <input type="text" name="services[INDEX][title]" class="form-control" placeholder="e.g., Deep House Cleaning" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Hourly Rate ($) <span class="text-danger">*</span></label>
                <input type="number" name="services[INDEX][hourly_rate]" class="form-control" value="35" min="10" max="500" step="1" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Experience</label>
                <select name="services[INDEX][experience_years]" class="form-select">
                    <option value="">Select...</option>
                    <option value="0">&lt;1 year</option>
                    <option value="1">1 year</option>
                    <option value="2">2 years</option>
                    <option value="3">3+ years</option>
                    <option value="5">5+ years</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="services[INDEX][description]" class="form-control" rows="2" placeholder="Briefly describe what's included..."></textarea>
            </div>
        </div>
    </div>
</template>
@endsection

@push('styles')
<style>
.registration-container { background: #f8f9fa; min-height: calc(100vh - 80px); }
.progress-steps { display: flex; align-items: center; justify-content: center; gap: 0.5rem; }
.step-item { display: flex; flex-direction: column; align-items: center; gap: 0.5rem; }
.step-circle { width: 45px; height: 45px; border-radius: 50%; background: #e5e7eb; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #6b7280; }
.step-item.active .step-circle, .step-item.completed .step-circle { background: linear-gradient(135deg, #FF6B35, #e55a2b); color: white; }
.step-label { font-size: 0.8rem; color: #6b7280; font-weight: 500; }
.step-item.active .step-label { color: #FF6B35; font-weight: 600; }
.step-line { flex: 1; max-width: 100px; height: 3px; background: #e5e7eb; }
.step-line.active { background: #FF6B35; }
.step-card { background: white; border-radius: 20px; padding: 2.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
.step-header { margin-bottom: 2rem; }
.step-header h2 { font-size: 1.5rem; font-weight: 700; color: #1A1A2E; margin-bottom: 0.5rem; }
.step-header p { color: #6b7280; margin: 0; }
.service-item { background: #f9fafb; border-radius: 16px; padding: 1.5rem; margin-bottom: 1rem; border: 2px solid transparent; transition: all 0.3s; }
.service-item:hover { border-color: #FF6B35; }
.service-item-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
.service-item-header h5 { font-weight: 600; margin: 0; color: #1A1A2E; }
.tips-card { background: #eff6ff; border-radius: 12px; padding: 1.25rem; }
.tips-card h6 { color: #1e40af; font-weight: 600; margin-bottom: 0.75rem; }
.tips-card ul { padding-left: 1.25rem; color: #1e40af; font-size: 0.9rem; }
.tips-card li { margin-bottom: 0.25rem; }
.step-actions { display: flex; justify-content: space-between; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #e5e7eb; }
.btn-lg { padding: 0.875rem 2rem; border-radius: 12px; font-weight: 600; }
</style>
@endpush

@push('scripts')
<script>
let serviceIndex = {{ $selectedServices->count() > 0 ? $selectedServices->count() : 1 }};

document.getElementById('addServiceBtn').addEventListener('click', function() {
    const template = document.getElementById('serviceTemplate').innerHTML;
    const newService = template.replace(/INDEX/g, serviceIndex).replace(/NUM/g, serviceIndex + 1);
    document.getElementById('servicesList').insertAdjacentHTML('beforeend', newService);
    
    // Initialize category change listener for new service
    const newItem = document.querySelector(`.service-item[data-index="${serviceIndex}"]`);
    initCategoryListener(newItem.querySelector('.category-select'));
    
    serviceIndex++;
    updateRemoveButtons();
});

function removeService(btn) {
    btn.closest('.service-item').remove();
    updateRemoveButtons();
    renumberServices();
}

function updateRemoveButtons() {
    const items = document.querySelectorAll('.service-item');
    items.forEach((item, index) => {
        const removeBtn = item.querySelector('.remove-service');
        if (items.length === 1) {
            removeBtn.classList.add('d-none');
        } else {
            removeBtn.classList.remove('d-none');
        }
    });
}

function renumberServices() {
    const items = document.querySelectorAll('.service-item');
    items.forEach((item, index) => {
        item.querySelector('h5').textContent = `Service #${index + 1}`;
    });
}

function initCategoryListener(select) {
    select.addEventListener('change', function() {
        const subcategorySelect = this.closest('.service-item').querySelector('.subcategory-select');
        const selectedOption = this.options[this.selectedIndex];
        const subcategories = selectedOption.dataset.subcategories ? JSON.parse(selectedOption.dataset.subcategories) : [];
        
        subcategorySelect.innerHTML = '<option value="">Select subcategory...</option>';
        subcategories.forEach(sub => {
            subcategorySelect.innerHTML += `<option value="${sub.id}">${sub.name}</option>`;
        });
    });
}

// Initialize listeners for existing category selects
document.querySelectorAll('.category-select').forEach(initCategoryListener);
</script>
@endpush