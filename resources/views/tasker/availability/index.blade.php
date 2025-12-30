@extends('layouts.app')

@section('title', 'Availability')

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
                                    <i class="bi bi-clock me-1"></i> Schedule
                                </span>
                                <h1 class="page-title">My Availability</h1>
                                <p class="page-description">
                                    Set your weekly schedule and manage blocked dates. Customers can only book during your available hours.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-4 d-none d-lg-block">
                            <div class="page-header-illustration">
                                <img src="https://illustrations.popsy.co/amber/calendar.svg" alt="Calendar" class="img-fluid" style="max-height: 150px;">
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

                <div class="row g-4">
                    <!-- Weekly Schedule -->
                    <div class="col-lg-8">
                        <div class="section-card">
                            <div class="section-header d-flex justify-content-between align-items-center">
                                <h5 class="section-title mb-0">
                                    <i class="bi bi-calendar-week text-primary me-2"></i>
                                    Weekly Schedule
                                </h5>
                                <button type="button" class="btn btn-sm btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#addAvailabilityModal">
                                    <i class="bi bi-plus-lg me-1"></i> Add Slot
                                </button>
                            </div>
                            <div class="section-body p-0">
                                @php
                                    $days = [
                                        0 => 'Sunday',
                                        1 => 'Monday', 
                                        2 => 'Tuesday',
                                        3 => 'Wednesday',
                                        4 => 'Thursday',
                                        5 => 'Friday',
                                        6 => 'Saturday'
                                    ];
                                    $dayIcons = [
                                        0 => 'bi-calendar',
                                        1 => 'bi-1-circle', 
                                        2 => 'bi-2-circle', 
                                        3 => 'bi-3-circle', 
                                        4 => 'bi-4-circle', 
                                        5 => 'bi-5-circle', 
                                        6 => 'bi-6-circle'
                                    ];
                                @endphp
                                
                                @foreach($days as $dayNum => $dayName)
                                    @php
                                        $daySlots = $availabilities->where('day_of_week', $dayNum);
                                        $hasSlots = $daySlots->count() > 0;
                                    @endphp
                                    <div class="schedule-day {{ !$hasSlots ? 'unavailable' : '' }}">
                                        <div class="day-header">
                                            <div class="day-info">
                                                <span class="day-icon bg-{{ $hasSlots ? 'success' : 'secondary' }}-subtle">
                                                    <i class="bi {{ $dayIcons[$dayNum] }} text-{{ $hasSlots ? 'success' : 'secondary' }}"></i>
                                                </span>
                                                <div>
                                                    <h6 class="day-name">{{ $dayName }}</h6>
                                                    <small class="day-status text-{{ $hasSlots ? 'success' : 'muted' }}">
                                                        {{ $hasSlots ? $daySlots->count() . ' slot(s)' : 'Unavailable' }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="day-slots">
                                            @if($hasSlots)
                                                @foreach($daySlots as $slot)
                                                    <div class="time-slot">
                                                        <i class="bi bi-clock me-1"></i>
                                                        {{ date('g:i A', strtotime($slot->start_time)) }} - {{ date('g:i A', strtotime($slot->end_time)) }}
                                                        <form action="{{ route('tasker.availability.destroy', $slot) }}" method="POST" class="d-inline ms-2">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-link text-white p-0" onclick="return confirm('Remove this slot?')">
                                                                <i class="bi bi-x-circle"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endforeach
                                            @else
                                                <span class="text-muted small">No availability set</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Blocked Dates -->
                    <div class="col-lg-4">
                        <div class="section-card mb-4">
                            <div class="section-header">
                                <h5 class="section-title mb-0">
                                    <i class="bi bi-calendar-x text-danger me-2"></i>
                                    Blocked Dates
                                </h5>
                            </div>
                            <div class="section-body">
                                <form action="{{ route('tasker.availability.block-date') }}" method="POST" class="mb-4">
                                    @csrf
                                    <input type="hidden" name="block_type" value="full_day">
                                    <div class="input-group">
                                        <input type="date" name="blocked_date" class="form-control" min="{{ date('Y-m-d') }}" required>
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted d-block mt-2">Block specific dates when you're unavailable</small>
                                </form>

                                @if($blockedDates->count() > 0)
                                    <div class="blocked-dates-list">
                                        @foreach($blockedDates as $blocked)
                                            <div class="blocked-date-item">
                                                <div class="blocked-info">
                                                    <i class="bi bi-calendar-x text-danger me-2"></i>
                                                    <span>{{ $blocked->blocked_date->format('M d, Y') }}</span>
                                                    <small class="text-muted ms-2">({{ $blocked->blocked_date->diffForHumans() }})</small>
                                                </div>
                                                <form action="{{ route('tasker.availability.unblock-date', $blocked) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="empty-state-mini">
                                        <i class="bi bi-calendar-check text-success"></i>
                                        <p>No blocked dates</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Quick Tips -->
                        <div class="section-card">
                            <div class="section-header">
                                <h5 class="section-title mb-0">
                                    <i class="bi bi-lightbulb text-warning me-2"></i>
                                    Tips
                                </h5>
                            </div>
                            <div class="section-body">
                                <div class="tip-item">
                                    <i class="bi bi-check-circle text-success"></i>
                                    <span>Set consistent weekly hours for more bookings</span>
                                </div>
                                <div class="tip-item">
                                    <i class="bi bi-check-circle text-success"></i>
                                    <span>Block dates in advance for time off</span>
                                </div>
                                <div class="tip-item">
                                    <i class="bi bi-check-circle text-success"></i>
                                    <span>Keep your schedule updated regularly</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Availability Modal -->
<div class="modal fade" id="addAvailabilityModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-plus-circle text-primary me-2"></i>Add Availability Slot
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('tasker.availability.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Day of Week</label>
                        <select name="day_of_week" class="form-select form-select-lg" required>
                            <option value="">Select a day</option>
                            <option value="0">Sunday</option>
                            <option value="1">Monday</option>
                            <option value="2">Tuesday</option>
                            <option value="3">Wednesday</option>
                            <option value="4">Thursday</option>
                            <option value="5">Friday</option>
                            <option value="6">Saturday</option>
                        </select>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-medium">Start Time</label>
                            <input type="time" name="start_time" class="form-control form-control-lg" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-medium">End Time</label>
                            <input type="time" name="end_time" class="form-control form-control-lg" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light btn-lg" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-plus-lg me-2"></i>Add Slot
                    </button>
                </div>
            </form>
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

/* Schedule Day */
.schedule-day {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #f3f4f6;
    transition: all 0.3s ease;
}

.schedule-day:last-child {
    border-bottom: none;
}

.schedule-day:hover {
    background: #f9fafb;
}

.schedule-day.unavailable {
    background: #fafafa;
}

.day-header {
    display: flex;
    align-items: center;
}

.day-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.day-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
}

.bg-success-subtle { background: rgba(16, 185, 129, 0.1); }
.bg-secondary-subtle { background: rgba(107, 114, 128, 0.1); }

.day-name {
    font-weight: 600;
    color: #1f2937;
    margin: 0;
    font-size: 1rem;
}

.day-status {
    font-size: 0.8rem;
}

.day-slots {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    justify-content: flex-end;
}

.time-slot {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 0.75rem;
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 500;
}

.time-slot .btn-link {
    color: white !important;
    opacity: 0.8;
}

.time-slot .btn-link:hover {
    opacity: 1;
}

/* Blocked Dates */
.blocked-dates-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.blocked-date-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.75rem 1rem;
    background: #fef2f2;
    border-radius: 12px;
    border: 1px solid #fecaca;
}

.blocked-info {
    display: flex;
    align-items: center;
    font-size: 0.9rem;
}

/* Empty State Mini */
.empty-state-mini {
    text-align: center;
    padding: 2rem 1rem;
    color: #9ca3af;
}

.empty-state-mini i {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
    display: block;
}

.empty-state-mini p {
    margin: 0;
    font-size: 0.9rem;
}

/* Tips */
.tip-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    margin-bottom: 1rem;
    font-size: 0.9rem;
    color: #4b5563;
}

.tip-item:last-child {
    margin-bottom: 0;
}

.tip-item i {
    margin-top: 2px;
    flex-shrink: 0;
}

/* Modal */
.modal-content {
    border: none;
    border-radius: 20px;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    padding: 1rem 1.5rem 1.5rem;
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

/* Responsive */
@media (max-width: 991.98px) {
    .page-header-card {
        padding: 1.5rem;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
    
    .schedule-day {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .day-slots {
        justify-content: flex-start;
        width: 100%;
    }
}
</style>
@endsection