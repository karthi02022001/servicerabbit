<div class="dashboard-sidebar bg-white shadow-sm rounded-4 p-3 sticky-top" style="top: 100px;">
    <div class="text-center mb-4">
        <div class="avatar-wrapper mb-3">
            @if(auth()->user()->avatar)
                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
            @else
                <div class="avatar-initials bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px; font-size: 1.5rem;">
                    {{ substr(auth()->user()->first_name, 0, 1) }}{{ substr(auth()->user()->last_name, 0, 1) }}
                </div>
            @endif
        </div>
        <h6 class="fw-semibold mb-1">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h6>
        <small class="text-muted">User</small>
    </div>
    
    <nav class="sidebar-nav">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.bookings.*') ? 'active' : '' }}" href="{{ route('user.bookings.index') }}">
                    <i class="bi bi-calendar-check me-2"></i> My Bookings
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.reviews.*') ? 'active' : '' }}" href="{{ route('user.reviews.index') }}">
                    <i class="bi bi-star me-2"></i> My Reviews
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('messages.*') ? 'active' : '' }}" href="{{ route('messages.index') }}">
                    <i class="bi bi-chat me-2"></i> Messages
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.notifications.*') ? 'active' : '' }}" href="{{ route('user.notifications.index') }}">
                    <i class="bi bi-bell me-2"></i> Notifications
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.profile.*') ? 'active' : '' }}" href="{{ route('user.profile.edit') }}">
                    <i class="bi bi-person me-2"></i> Profile
                </a>
            </li>
            @if(auth()->user()->is_tasker)
                <hr class="my-2">
                <li class="nav-item">
                    <a class="nav-link text-primary" href="{{ route('tasker.dashboard') }}">
                        <i class="bi bi-briefcase me-2"></i> Switch to Tasker
                    </a>
                </li>
            @else
                <hr class="my-2">
                <li class="nav-item">
                    <a class="nav-link text-success" href="{{ route('become-tasker') }}">
                        <i class="bi bi-briefcase me-2"></i> Become a Tasker
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</div>

<style>
.dashboard-sidebar .nav-link {
    color: var(--gray-700);
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    margin-bottom: 0.25rem;
    transition: all 0.2s;
}
.dashboard-sidebar .nav-link:hover,
.dashboard-sidebar .nav-link.active {
    background-color: var(--primary);
    color: white;
}
.dashboard-sidebar .nav-link i {
    width: 20px;
}
</style>