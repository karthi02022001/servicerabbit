{{-- Tasker Sidebar - Matches User Dashboard Design --}}
@php
    $taskerProfile = auth()->user()->taskerProfile;
    $isAvailable = $taskerProfile?->is_available ?? false;
    $pendingCount = \App\Models\Booking::where('tasker_id', auth()->id())->where('status', 'pending')->count();
    $serviceCount = $taskerProfile?->services()->where('is_active', true)->count() ?? 0;
@endphp

<div class="sidebar-card">
    {{-- Profile Header --}}
    <div class="sidebar-profile">
        <div class="profile-avatar-wrapper">
            <div class="profile-avatar">
                @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->full_name }}">
                @else
                    <span class="avatar-initials">{{ strtoupper(substr(auth()->user()->first_name, 0, 1) . substr(auth()->user()->last_name, 0, 1)) }}</span>
                @endif
            </div>
            <span class="status-dot {{ $isAvailable ? 'online' : 'offline' }}"></span>
        </div>
        <h5 class="profile-name">{{ auth()->user()->full_name }}</h5>
        <div class="profile-badges">
            @if($taskerProfile?->verification_status === 'approved')
                <span class="badge badge-verified">
                    <i class="bi bi-patch-check-fill me-1"></i>Verified
                </span>
            @else
                <span class="badge badge-pending">
                    <i class="bi bi-hourglass-split me-1"></i>Pending
                </span>
            @endif
        </div>
        <div class="profile-rating">
            <i class="bi bi-star-fill text-warning"></i>
            <span>{{ number_format($taskerProfile?->average_rating ?? 0, 1) }}</span>
            <small class="text-muted">({{ $taskerProfile?->total_reviews ?? 0 }} reviews)</small>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="sidebar-nav">
        {{-- Main Menu --}}
        <div class="nav-group">
            <span class="nav-group-title">Main Menu</span>
            
            <a href="{{ route('tasker.dashboard') }}" class="nav-item {{ request()->routeIs('tasker.dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-grid-1x2"></i></span>
                <span class="nav-text">Dashboard</span>
            </a>
            
            <a href="{{ Route::has('tasker.bookings.index') ? route('tasker.bookings.index', ['status' => 'pending']) : '#' }}" 
               class="nav-item {{ request()->routeIs('tasker.bookings.*') && request('status') == 'pending' ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-inbox"></i></span>
                <span class="nav-text">Pending Requests</span>
                @if($pendingCount > 0)
                    <span class="nav-badge">{{ $pendingCount }}</span>
                @endif
            </a>
            
            <a href="{{ Route::has('tasker.bookings.index') ? route('tasker.bookings.index') : '#' }}" 
               class="nav-item {{ request()->routeIs('tasker.bookings.index') && !request('status') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-calendar-check"></i></span>
                <span class="nav-text">All Bookings</span>
            </a>
        </div>

        {{-- Services --}}
        <div class="nav-group">
            <span class="nav-group-title">Services</span>
            
            <a href="{{ route('tasker.services.index') }}" class="nav-item {{ request()->routeIs('tasker.services.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-grid-3x3-gap"></i></span>
                <span class="nav-text">My Services</span>
                @if($serviceCount > 0)
                    <span class="nav-badge bg-secondary">{{ $serviceCount }}</span>
                @endif
            </a>
            
            <a href="{{ route('tasker.availability.index') }}" class="nav-item {{ request()->routeIs('tasker.availability.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-clock"></i></span>
                <span class="nav-text">Availability</span>
            </a>
        </div>

        {{-- Earnings --}}
        <div class="nav-group">
            <span class="nav-group-title">Earnings</span>
            
            <a href="{{ route('tasker.profile.earnings') }}" class="nav-item {{ request()->routeIs('tasker.profile.earnings') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-wallet2"></i></span>
                <span class="nav-text">My Earnings</span>
            </a>
        </div>

        {{-- Account --}}
        <div class="nav-group">
            <span class="nav-group-title">Account</span>
            
            <a href="{{ route('tasker.profile.edit') }}" class="nav-item {{ request()->routeIs('tasker.profile.edit') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-person-gear"></i></span>
                <span class="nav-text">Edit Profile</span>
            </a>
            
            <a href="{{ route('tasker.profile.verification') }}" class="nav-item {{ request()->routeIs('tasker.profile.verification') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-shield-check"></i></span>
                <span class="nav-text">Verification</span>
                @if($taskerProfile?->verification_status === 'submitted')
                    <span class="nav-badge bg-warning text-dark">Review</span>
                @endif
            </a>
        </div>
    </nav>

    {{-- Availability Toggle --}}
    <div class="availability-toggle">
        <form action="{{ route('tasker.profile.toggle-availability') }}" method="POST" id="sidebarAvailabilityForm">
            @csrf
            <div class="toggle-header">
                <div class="toggle-icon {{ $isAvailable ? 'online' : 'offline' }}">
                    <i class="bi bi-{{ $isAvailable ? 'check-circle-fill' : 'x-circle-fill' }}"></i>
                </div>
                <div class="toggle-info">
                    <strong>{{ $isAvailable ? 'Available' : 'Unavailable' }}</strong>
                    <small>{{ $isAvailable ? 'Accepting bookings' : 'Not accepting' }}</small>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="availabilitySwitch" 
                        {{ $isAvailable ? 'checked' : '' }}
                        onchange="document.getElementById('sidebarAvailabilityForm').submit()">
                </div>
            </div>
        </form>
    </div>

    {{-- Switch Mode Button --}}
    <div class="sidebar-footer">
        <a href="{{ route('user.dashboard') }}" class="btn btn-switch-mode">
            <i class="bi bi-arrow-left-right me-2"></i>Switch to User Mode
        </a>
    </div>
</div>

<style>
/* Sidebar Card */
.sidebar-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    overflow: hidden;
    position: sticky;
    top: 100px;
}

/* Profile Section */
.sidebar-profile {
    background: linear-gradient(135deg, #FF6B35 0%, #ff8c5a 50%, #ffab7a 100%);
    padding: 2rem 1.5rem;
    text-align: center;
    position: relative;
}

.sidebar-profile::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 20px;
    background: white;
    border-radius: 20px 20px 0 0;
}

.profile-avatar-wrapper {
    position: relative;
    display: inline-block;
    margin-bottom: 1rem;
}

.profile-avatar {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    overflow: hidden;
    border: 4px solid rgba(255,255,255,0.3);
}

.profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-avatar .avatar-initials {
    font-size: 1.75rem;
    font-weight: 700;
    color: #FF6B35;
}

.status-dot {
    position: absolute;
    bottom: 5px;
    right: 5px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    border: 3px solid white;
}

.status-dot.online { background: #10b981; }
.status-dot.offline { background: #9ca3af; }

.profile-name {
    color: white;
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
}

.profile-badges {
    margin-bottom: 0.5rem;
}

.badge-verified {
    background: rgba(255,255,255,0.2);
    color: white;
    padding: 0.35rem 0.75rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 500;
}

.badge-pending {
    background: rgba(255,255,255,0.2);
    color: white;
    padding: 0.35rem 0.75rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 500;
}

.profile-rating {
    color: rgba(255,255,255,0.9);
    font-size: 0.9rem;
}

.profile-rating span {
    font-weight: 600;
    color: white;
}

/* Navigation */
.sidebar-nav {
    padding: 1rem 0;
}

.nav-group {
    padding: 0 1rem;
    margin-bottom: 0.5rem;
}

.nav-group-title {
    display: block;
    font-size: 0.7rem;
    font-weight: 600;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 0.75rem 1rem 0.5rem;
}

.nav-item {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    color: #4b5563;
    text-decoration: none;
    border-radius: 12px;
    margin-bottom: 0.25rem;
    transition: all 0.3s ease;
    font-weight: 500;
    font-size: 0.9rem;
}

.nav-item:hover {
    background: #f9fafb;
    color: #FF6B35;
}

.nav-item.active {
    background: linear-gradient(135deg, #FF6B35, #ff8c5a);
    color: white;
    box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
}

.nav-icon {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    margin-right: 0.75rem;
    font-size: 1.1rem;
    background: #f3f4f6;
    transition: all 0.3s;
}

.nav-item:hover .nav-icon {
    background: rgba(255, 107, 53, 0.1);
    color: #FF6B35;
}

.nav-item.active .nav-icon {
    background: rgba(255,255,255,0.2);
    color: white;
}

.nav-text {
    flex: 1;
}

.nav-badge {
    background: #FF6B35;
    color: white;
    font-size: 0.7rem;
    font-weight: 600;
    padding: 0.2rem 0.5rem;
    border-radius: 50px;
    min-width: 20px;
    text-align: center;
}

.nav-item.active .nav-badge {
    background: white;
    color: #FF6B35;
}

/* Availability Toggle */
.availability-toggle {
    margin: 1rem;
    padding: 1rem;
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    border-radius: 16px;
    border: 1px dashed #10b981;
}

.toggle-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.toggle-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.toggle-icon.online {
    background: #10b981;
    color: white;
}

.toggle-icon.offline {
    background: #9ca3af;
    color: white;
}

.toggle-info {
    flex: 1;
}

.toggle-info strong {
    display: block;
    font-size: 0.9rem;
    color: #065f46;
}

.toggle-info small {
    font-size: 0.75rem;
    color: #047857;
}

.availability-toggle .form-check-input {
    width: 2.5rem;
    height: 1.25rem;
    cursor: pointer;
}

.availability-toggle .form-check-input:checked {
    background-color: #10b981;
    border-color: #10b981;
}

/* Sidebar Footer */
.sidebar-footer {
    padding: 0 1rem 1rem;
}

.btn-switch-mode {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 0.75rem 1rem;
    background: #f9fafb;
    color: #4b5563;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-weight: 500;
    font-size: 0.9rem;
    text-decoration: none;
    transition: all 0.3s;
}

.btn-switch-mode:hover {
    background: #FF6B35;
    color: white;
    border-color: #FF6B35;
}

/* Responsive */
@media (max-width: 991.98px) {
    .sidebar-card {
        position: static;
        margin-bottom: 1.5rem;
    }
}
</style>