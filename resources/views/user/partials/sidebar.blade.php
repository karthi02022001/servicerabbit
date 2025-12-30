<div class="sidebar-wrapper">
    <!-- User Profile Card -->
    <div class="sidebar-profile">
        <div class="profile-avatar-wrapper">
            <div class="profile-avatar">
                @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar">
                @else
                    <span class="avatar-initials">
                        {{ substr(auth()->user()->first_name, 0, 1) }}{{ substr(auth()->user()->last_name, 0, 1) }}
                    </span>
                @endif
            </div>
            <span class="profile-status online"></span>
        </div>
        <h6 class="profile-name">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h6>
        <p class="profile-role">
            @if(auth()->user()->is_tasker)
                <span class="badge bg-success-subtle text-success">
                    <i class="bi bi-patch-check-fill me-1"></i> Tasker
                </span>
            @else
                <span class="badge bg-primary-subtle text-primary">
                    <i class="bi bi-person-fill me-1"></i> Member
                </span>
            @endif
        </p>
        <p class="profile-since">
            <i class="bi bi-calendar3 me-1"></i> Since {{ auth()->user()->created_at->format('M Y') }}
        </p>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav">
        <div class="nav-section">
            <span class="nav-section-title">Main Menu</span>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
                        <span class="nav-icon"><i class="bi bi-grid-1x2"></i></span>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.bookings.*') ? 'active' : '' }}" href="{{ route('user.bookings.index') }}">
                        <span class="nav-icon"><i class="bi bi-calendar-check"></i></span>
                        <span class="nav-text">My Bookings</span>
                        @if(($pendingCount ?? 0) > 0)
                            <span class="nav-badge">{{ $pendingCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.reviews.*') ? 'active' : '' }}" href="{{ route('user.reviews.index') }}">
                        <span class="nav-icon"><i class="bi bi-star"></i></span>
                        <span class="nav-text">My Reviews</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.messages.*') ? 'active' : '' }}" href="{{ route('user.messages.index') }}">
                        <span class="nav-icon"><i class="bi bi-chat-dots"></i></span>
                        <span class="nav-text">Messages</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.notifications.*') ? 'active' : '' }}" href="{{ route('user.notifications.index') }}">
                        <span class="nav-icon"><i class="bi bi-bell"></i></span>
                        <span class="nav-text">Notifications</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="nav-section">
            <span class="nav-section-title">Account</span>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.profile.*') ? 'active' : '' }}" href="{{ route('user.profile.edit') }}">
                        <span class="nav-icon"><i class="bi bi-person-gear"></i></span>
                        <span class="nav-text">Profile Settings</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.password.*') ? 'active' : '' }}" href="{{ route('user.password.change') }}">
                        <span class="nav-icon"><i class="bi bi-shield-lock"></i></span>
                        <span class="nav-text">Security</span>
                    </a>
                </li>
            </ul>
        </div>

        @if(auth()->user()->is_tasker)
        <div class="nav-section">
            <span class="nav-section-title">Tasker Mode</span>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link nav-link-highlight" href="{{ route('tasker.dashboard') }}">
                        <span class="nav-icon"><i class="bi bi-briefcase"></i></span>
                        <span class="nav-text">Tasker Dashboard</span>
                        <span class="nav-arrow"><i class="bi bi-arrow-right"></i></span>
                    </a>
                </li>
            </ul>
        </div>
        @else
        <div class="tasker-promo">
            <div class="tasker-promo-icon">
                <i class="bi bi-cash-stack"></i>
            </div>
            <h6>Earn Money</h6>
            <p>Become a tasker and start earning</p>
            <a href="{{ route('become-tasker') }}" class="btn btn-sm btn-primary w-100">
                Get Started <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
        @endif
    </nav>
</div>

<style>
.sidebar-wrapper {
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    overflow: hidden;
    position: sticky;
    top: 100px;
}

/* Profile Section */
.sidebar-profile {
    background: linear-gradient(135deg, #FF6B35 0%, #ff8c5a 100%);
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

.avatar-initials {
    font-size: 1.75rem;
    font-weight: 700;
    color: #FF6B35;
}

.profile-status {
    position: absolute;
    bottom: 5px;
    right: 5px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 3px solid white;
}

.profile-status.online {
    background: #10b981;
}

.profile-name {
    color: white;
    font-weight: 700;
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
}

.profile-role {
    margin-bottom: 0.25rem;
}

.profile-role .badge {
    font-weight: 500;
    padding: 0.4rem 0.75rem;
}

.bg-primary-subtle { background: rgba(255,255,255,0.2) !important; }
.text-primary { color: white !important; }
.bg-success-subtle { background: rgba(16, 185, 129, 0.2) !important; }
.text-success { color: #d1fae5 !important; }

.profile-since {
    color: rgba(255,255,255,0.8);
    font-size: 0.8rem;
    margin: 0;
}

/* Navigation */
.sidebar-nav {
    padding: 1rem 0;
}

.nav-section {
    padding: 0 1rem;
    margin-bottom: 1rem;
}

.nav-section-title {
    display: block;
    font-size: 0.7rem;
    font-weight: 600;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 0.5rem 1rem;
    margin-bottom: 0.25rem;
}

.sidebar-nav .nav-link {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    color: #4b5563;
    border-radius: 12px;
    margin-bottom: 0.25rem;
    transition: all 0.3s ease;
    font-weight: 500;
    font-size: 0.9rem;
}

.sidebar-nav .nav-link:hover {
    background: #f9fafb;
    color: #FF6B35;
}

.sidebar-nav .nav-link.active {
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

.nav-link:hover .nav-icon {
    background: rgba(255, 107, 53, 0.1);
    color: #FF6B35;
}

.nav-link.active .nav-icon {
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

.nav-link.active .nav-badge {
    background: white;
    color: #FF6B35;
}

.nav-arrow {
    opacity: 0;
    transform: translateX(-10px);
    transition: all 0.3s;
}

.nav-link:hover .nav-arrow,
.nav-link.active .nav-arrow {
    opacity: 1;
    transform: translateX(0);
}

/* Highlight Link */
.nav-link-highlight {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(52, 211, 153, 0.05)) !important;
    border: 1px dashed #10b981;
}

.nav-link-highlight .nav-icon {
    background: #10b981;
    color: white;
}

.nav-link-highlight:hover {
    background: linear-gradient(135deg, #10b981, #34d399) !important;
    color: white !important;
    border-color: transparent;
}

.nav-link-highlight:hover .nav-icon {
    background: rgba(255,255,255,0.2);
}

/* Tasker Promo */
.tasker-promo {
    margin: 1rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    border-radius: 16px;
    text-align: center;
    border: 1px dashed #10b981;
}

.tasker-promo-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #10b981, #34d399);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
    color: white;
}

.tasker-promo h6 {
    font-weight: 700;
    color: #065f46;
    margin-bottom: 0.25rem;
}

.tasker-promo p {
    font-size: 0.8rem;
    color: #047857;
    margin-bottom: 1rem;
}

.tasker-promo .btn-primary {
    background: linear-gradient(135deg, #10b981, #059669);
    border: none;
    font-weight: 600;
    padding: 0.6rem 1rem;
    border-radius: 10px;
}

.tasker-promo .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
}

/* Responsive */
@media (max-width: 991.98px) {
    .sidebar-wrapper {
        position: static;
        margin-bottom: 1.5rem;
    }
}
</style>