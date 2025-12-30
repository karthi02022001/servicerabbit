@extends('layouts.app')

@section('title', 'Become a Tasker - Availability')

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
            <div class="step-item completed">
                <div class="step-circle"><i class="bi bi-check"></i></div>
                <span class="step-label">Services</span>
            </div>
            <div class="step-line active"></div>
            <div class="step-item active">
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
                        <h2><i class="bi bi-calendar-week me-2"></i>Set Your Availability</h2>
                        <p>Let customers know when you're available to work</p>
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

                    <form action="{{ route('tasker.register.step3.store') }}" method="POST">
                        @csrf
                        
                        <!-- Quick Actions -->
                        <div class="quick-actions mb-4">
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="setWeekdays()">
                                <i class="bi bi-calendar-range me-1"></i> Mon-Fri (9-5)
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="setAllDays()">
                                <i class="bi bi-calendar-check me-1"></i> Every Day
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearAll()">
                                <i class="bi bi-x-circle me-1"></i> Clear All
                            </button>
                        </div>

                        <!-- Availability Schedule -->
                        <div class="availability-schedule">
                            @php
                                $existingAvailability = $availabilities->keyBy('day_of_week');
                            @endphp
                            
                            @foreach($daysOfWeek as $dayNum => $dayName)
                            @php
                                $dayData = $existingAvailability->get($dayNum);
                            @endphp
                            <div class="day-row" data-day="{{ $dayNum }}">
                                <div class="day-toggle">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input day-switch" type="checkbox" 
                                            id="day{{ $dayNum }}" 
                                            name="availability[{{ $dayNum }}][enabled]" 
                                            value="1"
                                            {{ $dayData ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="day{{ $dayNum }}">
                                            {{ $dayName }}
                                        </label>
                                    </div>
                                </div>
                                <div class="day-times {{ $dayData ? '' : 'd-none' }}">
                                    <div class="time-inputs">
                                        <div class="time-group">
                                            <label>From</label>
                                            <input type="time" name="availability[{{ $dayNum }}][start_time]" 
                                                class="form-control" 
                                                value="{{ $dayData ? substr($dayData->start_time, 0, 5) : '09:00' }}">
                                        </div>
                                        <span class="time-separator">to</span>
                                        <div class="time-group">
                                            <label>To</label>
                                            <input type="time" name="availability[{{ $dayNum }}][end_time]" 
                                                class="form-control" 
                                                value="{{ $dayData ? substr($dayData->end_time, 0, 5) : '17:00' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="day-status">
                                    <span class="badge {{ $dayData ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $dayData ? 'Available' : 'Unavailable' }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Info -->
                        <div class="info-card mt-4">
                            <i class="bi bi-info-circle text-info me-2"></i>
                            <span>You can update your availability anytime from your tasker dashboard.</span>
                        </div>

                        <!-- Actions -->
                        <div class="step-actions">
                            <a href="{{ route('tasker.register.step2') }}" class="btn btn-outline-secondary btn-lg">
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
.quick-actions { display: flex; gap: 0.5rem; flex-wrap: wrap; }
.availability-schedule { border: 1px solid #e5e7eb; border-radius: 16px; overflow: hidden; }
.day-row { display: flex; align-items: center; padding: 1rem 1.25rem; border-bottom: 1px solid #e5e7eb; transition: background 0.2s; }
.day-row:last-child { border-bottom: none; }
.day-row:hover { background: #f9fafb; }
.day-toggle { flex: 0 0 150px; }
.day-times { flex: 1; }
.day-status { flex: 0 0 100px; text-align: right; }
.time-inputs { display: flex; align-items: center; gap: 0.75rem; }
.time-group { display: flex; flex-direction: column; gap: 0.25rem; }
.time-group label { font-size: 0.75rem; color: #6b7280; }
.time-group input { width: 120px; }
.time-separator { color: #9ca3af; }
.form-switch .form-check-input { width: 3rem; height: 1.5rem; cursor: pointer; }
.form-switch .form-check-input:checked { background-color: #FF6B35; border-color: #FF6B35; }
.info-card { background: #eff6ff; border-radius: 12px; padding: 1rem 1.25rem; font-size: 0.9rem; color: #1e40af; }
.step-actions { display: flex; justify-content: space-between; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #e5e7eb; }
.btn-lg { padding: 0.875rem 2rem; border-radius: 12px; font-weight: 600; }
@media (max-width: 767.98px) {
    .day-row { flex-wrap: wrap; gap: 1rem; }
    .day-toggle { flex: 0 0 100%; }
    .day-times { flex: 0 0 100%; }
    .day-status { flex: 0 0 100%; text-align: left; }
    .time-inputs { flex-wrap: wrap; }
}
</style>
@endpush

@push('scripts')
<script>
document.querySelectorAll('.day-switch').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        const dayRow = this.closest('.day-row');
        const dayTimes = dayRow.querySelector('.day-times');
        const badge = dayRow.querySelector('.badge');
        
        if (this.checked) {
            dayTimes.classList.remove('d-none');
            badge.className = 'badge bg-success';
            badge.textContent = 'Available';
        } else {
            dayTimes.classList.add('d-none');
            badge.className = 'badge bg-secondary';
            badge.textContent = 'Unavailable';
        }
    });
});

function setWeekdays() {
    document.querySelectorAll('.day-row').forEach(function(row) {
        const dayNum = parseInt(row.dataset.day);
        const checkbox = row.querySelector('.day-switch');
        const startTime = row.querySelector('input[name*="start_time"]');
        const endTime = row.querySelector('input[name*="end_time"]');
        
        // Monday (1) to Friday (5)
        if (dayNum >= 1 && dayNum <= 5) {
            checkbox.checked = true;
            startTime.value = '09:00';
            endTime.value = '17:00';
        } else {
            checkbox.checked = false;
        }
        checkbox.dispatchEvent(new Event('change'));
    });
}

function setAllDays() {
    document.querySelectorAll('.day-row').forEach(function(row) {
        const checkbox = row.querySelector('.day-switch');
        const startTime = row.querySelector('input[name*="start_time"]');
        const endTime = row.querySelector('input[name*="end_time"]');
        
        checkbox.checked = true;
        startTime.value = '09:00';
        endTime.value = '17:00';
        checkbox.dispatchEvent(new Event('change'));
    });
}

function clearAll() {
    document.querySelectorAll('.day-switch').forEach(function(checkbox) {
        checkbox.checked = false;
        checkbox.dispatchEvent(new Event('change'));
    });
}
</script>
@endpush