<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Dashboard') - Admin | Service Rabbit</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Admin CSS -->
    <link href="{{ asset('assets/admin/css/admin.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>
<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <i class="bi bi-box-seam"></i>
            </div>
            <div class="sidebar-brand-text">
                ServiceRabbit
                <small>Admin Dashboard</small>
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <!-- Main Navigation -->
            <div class="nav-section-title">Main Navigation</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                Dashboard
            </a>
            
            @if(Auth::guard('admin')->user()->hasAnyPermission(['manage_users.view']))
            <!-- Users with Submenu -->
            <a href="#usersSubmenu" class="nav-link nav-toggle {{ request()->routeIs('admin.users.*') ? '' : 'collapsed' }}" data-bs-toggle="collapse">
                <i class="bi bi-people"></i>
                Users
            </a>
            <ul class="nav-submenu collapse {{ request()->routeIs('admin.users.*') ? 'show' : '' }}" id="usersSubmenu">
                @if(Route::has('admin.users.index'))
                <li><a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">All Users</a></li>
                @else
                <li><a href="#" class="nav-link disabled">All Users</a></li>
                @endif
            </ul>
            @endif
            
            @if(Auth::guard('admin')->user()->hasAnyPermission(['manage_taskers.view']))
            <a href="#taskersSubmenu" class="nav-link nav-toggle {{ request()->routeIs('admin.taskers.*') ? '' : 'collapsed' }}" data-bs-toggle="collapse">
                <i class="bi bi-person-badge"></i>
                Taskers
            </a>
            <ul class="nav-submenu collapse {{ request()->routeIs('admin.taskers.*') ? 'show' : '' }}" id="taskersSubmenu">
                @if(Route::has('admin.taskers.index'))
                <li><a href="{{ route('admin.taskers.index') }}" class="nav-link">All Taskers</a></li>
                <li><a href="{{ route('admin.taskers.pending') }}" class="nav-link">Pending Verification</a></li>
                @else
                <li><a href="#" class="nav-link disabled">All Taskers</a></li>
                @endif
            </ul>
            @endif
            
            @if(Auth::guard('admin')->user()->hasAnyPermission(['manage_bookings.view']))
            <a href="#" class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }} {{ !Route::has('admin.bookings.index') ? 'disabled' : '' }}">
                <i class="bi bi-calendar-check"></i>
                Bookings
                @if(!Route::has('admin.bookings.index'))
                <span class="nav-badge">Soon</span>
                @endif
            </a>
            @endif
            
            <!-- Management Section -->
            <div class="nav-section-title">Management</div>
            
            @if(Auth::guard('admin')->user()->hasAnyPermission(['manage_categories.view']))
            <!-- Categories with Submenu -->
            <a href="#categoriesSubmenu" class="nav-link nav-toggle {{ request()->routeIs('admin.categories.*') || request()->routeIs('admin.subcategories.*') ? '' : 'collapsed' }}" data-bs-toggle="collapse">
                <i class="bi bi-grid-3x3-gap"></i>
                Categories
            </a>
            <ul class="nav-submenu collapse {{ request()->routeIs('admin.categories.*') || request()->routeIs('admin.subcategories.*') ? 'show' : '' }}" id="categoriesSubmenu">
                <li>
                    <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.index') ? 'active' : '' }}">
                        All Categories
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.categories.create') }}" class="nav-link {{ request()->routeIs('admin.categories.create') ? 'active' : '' }}">
                        Add Category
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.subcategories.index') }}" class="nav-link {{ request()->routeIs('admin.subcategories.index') ? 'active' : '' }}">
                        Subcategories
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.subcategories.create') }}" class="nav-link {{ request()->routeIs('admin.subcategories.create') ? 'active' : '' }}">
                        Add Subcategory
                    </a>
                </li>
            </ul>
            @endif
            
            @if(Auth::guard('admin')->user()->hasAnyPermission(['manage_payments.view']))
            <a href="#" class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }} {{ !Route::has('admin.payments.index') ? 'disabled' : '' }}">
                <i class="bi bi-credit-card"></i>
                Payments
                @if(!Route::has('admin.payments.index'))
                <span class="nav-badge">Soon</span>
                @endif
            </a>
            @endif
            
            @if(Auth::guard('admin')->user()->hasAnyPermission(['manage_reviews.view']))
            <a href="#" class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }} {{ !Route::has('admin.reviews.index') ? 'disabled' : '' }}">
                <i class="bi bi-star"></i>
                Reviews
                @if(!Route::has('admin.reviews.index'))
                <span class="nav-badge">Soon</span>
                @endif
            </a>
            @endif
            
            <!-- Analytics & Settings -->
            <div class="nav-section-title">Analytics & Settings</div>
            
            @if(Auth::guard('admin')->user()->isSuperAdmin() || Auth::guard('admin')->user()->hasPermission('manage_settings.admins'))
            <a href="{{ route('admin.admins.index') }}" class="nav-link {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                <i class="bi bi-person-gear"></i>
                Admin Users
            </a>
            @endif
            
            @if(Auth::guard('admin')->user()->isSuperAdmin() || Auth::guard('admin')->user()->hasPermission('manage_settings.roles'))
            <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                <i class="bi bi-shield-lock"></i>
                Roles & Permissions
            </a>
            @endif
            
            @if(Auth::guard('admin')->user()->isSuperAdmin() || Auth::guard('admin')->user()->hasPermission('manage_settings.view'))
            <a href="#" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }} {{ !Route::has('admin.settings.index') ? 'disabled' : '' }}">
                <i class="bi bi-gear"></i>
                Settings
                @if(!Route::has('admin.settings.index'))
                <span class="nav-badge">Soon</span>
                @endif
            </a>
            @endif
            
            @if(Auth::guard('admin')->user()->isSuperAdmin() || Auth::guard('admin')->user()->hasPermission('manage_settings.admins'))
            <a href="{{ route('admin.activity-logs.index') }}" class="nav-link {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}">
                <i class="bi bi-activity"></i>
                Activity Logs
            </a>
            @endif
        </nav>
        
        <!-- Theme Toggle -->
        <div class="sidebar-footer">
            <div class="theme-toggle" id="themeToggle">
                <div class="theme-toggle-label">
                    <i class="bi bi-sun-fill"></i>
                    <span>Light Mode</span>
                </div>
                <div class="theme-toggle-switch"></div>
            </div>
        </div>
    </aside>
    
    <!-- Main Content -->
    <main class="admin-main">
        <!-- Top Navbar -->
        <header class="admin-topbar">
            <div class="topbar-left">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <div class="page-header">
                    <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                    <p class="page-subtitle">@yield('page-subtitle', '')</p>
                </div>
            </div>
            
            <div class="topbar-right">
                <!-- Language Dropdown -->
                <div class="dropdown language-dropdown d-none d-md-block">
                    <button class="dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-globe"></i>
                        English
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">English</a></li>
                        <li><a class="dropdown-item" href="#">Tamil</a></li>
                        <li><a class="dropdown-item" href="#">Hindi</a></li>
                    </ul>
                </div>
                
                <!-- Admin Dropdown -->
                <div class="dropdown admin-dropdown">
                    <button class="dropdown-toggle" data-bs-toggle="dropdown">
                        @if(Auth::guard('admin')->user()->avatar)
                        <img src="{{ asset('storage/' . Auth::guard('admin')->user()->avatar) }}" alt="Admin" class="admin-avatar">
                        @else
                        <div class="admin-avatar">{{ substr(Auth::guard('admin')->user()->first_name, 0, 1) }}</div>
                        @endif
                        <div class="admin-info d-none d-md-block">
                            <div class="name">{{ Auth::guard('admin')->user()->full_name }}</div>
                            <div class="role">{{ Auth::guard('admin')->user()->is_super_admin ? 'Super Admin' : 'Admin' }}</div>
                        </div>
                        <i class="bi bi-chevron-down ms-1 d-none d-md-inline"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-person me-2"></i> My Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-gear me-2"></i> Settings
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        
        <!-- Content Area -->
        <div class="admin-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </main>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    
    <script>
        // Theme Toggle
        const themeToggle = document.getElementById('themeToggle');
        const html = document.documentElement;
        const themeLabel = themeToggle.querySelector('.theme-toggle-label span');
        const themeIcon = themeToggle.querySelector('.theme-toggle-label i');
        
        // Check for saved theme preference
        const savedTheme = localStorage.getItem('admin-theme') || 'light';
        html.setAttribute('data-theme', savedTheme);
        updateThemeUI(savedTheme);
        
        themeToggle.addEventListener('click', function() {
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('admin-theme', newTheme);
            updateThemeUI(newTheme);
        });
        
        function updateThemeUI(theme) {
            if (theme === 'dark') {
                themeLabel.textContent = 'Dark Mode';
                themeIcon.classList.remove('bi-sun-fill');
                themeIcon.classList.add('bi-moon-fill');
            } else {
                themeLabel.textContent = 'Light Mode';
                themeIcon.classList.remove('bi-moon-fill');
                themeIcon.classList.add('bi-sun-fill');
            }
        }
        
        // Sidebar Toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        const adminSidebar = document.getElementById('adminSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        sidebarToggle?.addEventListener('click', () => {
            adminSidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
        });
        
        sidebarOverlay?.addEventListener('click', () => {
            adminSidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
        });
        
        // Auto-hide alerts after 5 seconds
        document.querySelectorAll('.alert-dismissible').forEach(alert => {
            setTimeout(() => {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                bsAlert.close();
            }, 5000);
        });
    </script>
    
    @stack('scripts')
</body>
</html>