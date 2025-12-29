<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Admin | Service Rabbit</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #FF6B35;
            --secondary: #1A1A2E;
            --accent: #16213E;
            --sidebar-width: 280px;
            --header-height: 70px;
        }
        
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: #f4f6f9;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--secondary) 0%, var(--accent) 100%);
            z-index: 1000;
            transition: transform 0.3s ease;
            overflow-y: auto;
        }
        
        .sidebar-header {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-logo {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary), #ff8c5a);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .sidebar-logo i {
            font-size: 1.5rem;
            color: white;
        }
        
        .sidebar-brand {
            color: white;
        }
        
        .sidebar-brand h5 {
            margin: 0;
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .sidebar-brand small {
            color: rgba(255,255,255,0.6);
            font-size: 0.75rem;
        }
        
        .sidebar-nav {
            padding: 1rem 0;
        }
        
        .nav-section {
            padding: 0.5rem 1.5rem;
            margin-top: 0.5rem;
        }
        
        .nav-section-title {
            color: rgba(255,255,255,0.4);
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
        }
        
        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            font-size: 0.9rem;
        }
        
        .sidebar-nav .nav-link:hover {
            background: rgba(255,255,255,0.05);
            color: white;
        }
        
        .sidebar-nav .nav-link.active {
            background: rgba(255, 107, 53, 0.15);
            color: var(--primary);
            border-left-color: var(--primary);
        }
        
        .sidebar-nav .nav-link i {
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
        }
        
        .nav-badge {
            margin-left: auto;
            background: var(--primary);
            color: white;
            font-size: 0.7rem;
            padding: 0.2rem 0.5rem;
            border-radius: 50px;
            font-weight: 600;
        }
        
        /* Main Content */
        .admin-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }
        
        /* Header */
        .admin-header {
            position: sticky;
            top: 0;
            height: var(--header-height);
            background: white;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            z-index: 100;
        }
        
        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--secondary);
            cursor: pointer;
        }
        
        .page-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--secondary);
            margin: 0;
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .header-icon-btn {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            border: none;
            background: #f4f6f9;
            color: var(--secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .header-icon-btn:hover {
            background: #e9ecef;
        }
        
        .header-icon-btn .badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: var(--primary);
            color: white;
            font-size: 0.65rem;
            padding: 0.2rem 0.4rem;
            border-radius: 50px;
        }
        
        .admin-dropdown {
            position: relative;
        }
        
        .admin-dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem;
            border: none;
            background: none;
            cursor: pointer;
            border-radius: 10px;
            transition: background 0.3s ease;
        }
        
        .admin-dropdown-toggle:hover {
            background: #f4f6f9;
        }
        
        .admin-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), #ff8c5a);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }
        
        .admin-info {
            text-align: left;
        }
        
        .admin-info .name {
            font-weight: 600;
            color: var(--secondary);
            font-size: 0.9rem;
            line-height: 1.2;
        }
        
        .admin-info .role {
            font-size: 0.75rem;
            color: #6c757d;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            border-radius: 12px;
            padding: 0.5rem;
            min-width: 200px;
        }
        
        .dropdown-item {
            padding: 0.6rem 1rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
        }
        
        .dropdown-item:hover {
            background: #f4f6f9;
        }
        
        .dropdown-item i {
            width: 20px;
            text-align: center;
            color: #6c757d;
        }
        
        .dropdown-divider {
            margin: 0.5rem 0;
        }
        
        .dropdown-item.text-danger i {
            color: #dc3545;
        }
        
        /* Content */
        .admin-content {
            padding: 1.5rem;
        }
        
        /* Cards */
        .admin-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            border: none;
        }
        
        .admin-card .card-header {
            background: none;
            border-bottom: 1px solid #e9ecef;
            padding: 1.25rem 1.5rem;
        }
        
        .admin-card .card-title {
            font-weight: 600;
            color: var(--secondary);
            margin: 0;
            font-size: 1.1rem;
        }
        
        .admin-card .card-body {
            padding: 1.5rem;
        }
        
        /* Stat Cards */
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .stat-icon i {
            font-size: 1.5rem;
            color: white;
        }
        
        .stat-icon.primary {
            background: linear-gradient(135deg, var(--primary), #ff8c5a);
        }
        
        .stat-icon.success {
            background: linear-gradient(135deg, #10b981, #34d399);
        }
        
        .stat-icon.info {
            background: linear-gradient(135deg, #3b82f6, #60a5fa);
        }
        
        .stat-icon.warning {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
        }
        
        .stat-icon.danger {
            background: linear-gradient(135deg, #ef4444, #f87171);
        }
        
        .stat-icon.purple {
            background: linear-gradient(135deg, #8b5cf6, #a78bfa);
        }
        
        .stat-content h3 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--secondary);
            margin-bottom: 0.25rem;
            line-height: 1;
        }
        
        .stat-content p {
            color: #6c757d;
            font-size: 0.85rem;
            margin: 0;
        }
        
        .stat-change {
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            margin-top: 0.5rem;
        }
        
        .stat-change.positive {
            color: #10b981;
        }
        
        .stat-change.negative {
            color: #ef4444;
        }
        
        /* Tables */
        .admin-table {
            margin: 0;
        }
        
        .admin-table thead th {
            background: #f8f9fa;
            border: none;
            padding: 1rem 1.25rem;
            font-weight: 600;
            font-size: 0.85rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .admin-table tbody td {
            padding: 1rem 1.25rem;
            vertical-align: middle;
            border-color: #e9ecef;
        }
        
        .admin-table tbody tr:hover {
            background: #f8f9fa;
        }
        
        /* Buttons */
        .btn-admin {
            padding: 0.6rem 1.25rem;
            font-weight: 500;
            border-radius: 10px;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .btn-admin-primary {
            background: linear-gradient(135deg, var(--primary), #ff8c5a);
            border: none;
            color: white;
        }
        
        .btn-admin-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(255, 107, 53, 0.3);
            color: white;
        }
        
        /* Badges */
        .badge-status {
            padding: 0.4rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .badge-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .badge-approved {
            background: #d4edda;
            color: #155724;
        }
        
        .badge-rejected {
            background: #f8d7da;
            color: #721c24;
        }
        
        .badge-active {
            background: #d4edda;
            color: #155724;
        }
        
        .badge-inactive {
            background: #e9ecef;
            color: #6c757d;
        }
        
        /* User Avatar in Tables */
        .user-cell {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .user-cell-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #e9ecef, #dee2e6);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .user-cell-info .name {
            font-weight: 500;
            color: var(--secondary);
        }
        
        .user-cell-info .email {
            font-size: 0.8rem;
            color: #6c757d;
        }
        
        /* Responsive */
        @media (max-width: 991.98px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            
            .admin-sidebar.show {
                transform: translateX(0);
            }
            
            .admin-main {
                margin-left: 0;
            }
            
            .sidebar-toggle {
                display: block;
            }
            
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.5);
                z-index: 999;
            }
            
            .sidebar-overlay.show {
                display: block;
            }
        }
        
        /* Alerts */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.25rem;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
        }
        
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }
        
        .alert-warning {
            background: #fff3cd;
            color: #856404;
        }
        
        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
    
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <i class="bi bi-lightning-charge"></i>
            </div>
            <div class="sidebar-brand">
                <h5>Service Rabbit</h5>
                <small>Admin Panel</small>
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i>
                <span>Dashboard</span>
            </a>
            
            <div class="nav-section">
                <div class="nav-section-title">Management</div>
            </div>
            
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>Users</span>
            </a>
            
            <a href="{{ route('admin.taskers.index') }}" class="nav-link {{ request()->routeIs('admin.taskers.*') ? 'active' : '' }}">
                <i class="bi bi-person-badge"></i>
                <span>Taskers</span>
                @php
                    $pendingTaskers = \App\Models\TaskerProfile::where('verification_status', 'submitted')->count();
                @endphp
                @if($pendingTaskers > 0)
                    <span class="nav-badge">{{ $pendingTaskers }}</span>
                @endif
            </a>
            
            <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i>
                <span>Bookings</span>
            </a>
            
            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="bi bi-grid-3x3-gap"></i>
                <span>Categories</span>
            </a>
            
            <div class="nav-section">
                <div class="nav-section-title">Finance</div>
            </div>
            
            <a href="{{ route('admin.payments.index') }}" class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                <i class="bi bi-credit-card"></i>
                <span>Payments</span>
            </a>
            
            <a href="{{ route('admin.payouts.index') }}" class="nav-link {{ request()->routeIs('admin.payouts.*') ? 'active' : '' }}">
                <i class="bi bi-wallet2"></i>
                <span>Payouts</span>
            </a>
            
            <div class="nav-section">
                <div class="nav-section-title">Content</div>
            </div>
            
            <a href="{{ route('admin.reviews.index') }}" class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                <i class="bi bi-star"></i>
                <span>Reviews</span>
            </a>
            
            <a href="{{ route('admin.pages.index') }}" class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                <i class="bi bi-file-text"></i>
                <span>Pages</span>
            </a>
            
            <a href="{{ route('admin.banners.index') }}" class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                <i class="bi bi-images"></i>
                <span>Banners</span>
            </a>
            
            <div class="nav-section">
                <div class="nav-section-title">Settings</div>
            </div>
            
            <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="bi bi-gear"></i>
                <span>Settings</span>
            </a>
            
            @if(auth('admin')->user()->isSuperAdmin())
            <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                <i class="bi bi-shield-check"></i>
                <span>Roles</span>
            </a>
            
            <a href="{{ route('admin.admins.index') }}" class="nav-link {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                <i class="bi bi-person-gear"></i>
                <span>Admins</span>
            </a>
            @endif
        </nav>
    </aside>
    
    <!-- Main Content -->
    <main class="admin-main">
        <!-- Header -->
        <header class="admin-header">
            <div class="header-left">
                <button class="sidebar-toggle" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
            </div>
            
            <div class="header-right">
                <a href="{{ url('/') }}" target="_blank" class="header-icon-btn" title="View Website">
                    <i class="bi bi-box-arrow-up-right"></i>
                </a>
                
                <button class="header-icon-btn" title="Notifications">
                    <i class="bi bi-bell"></i>
                    <span class="badge">3</span>
                </button>
                
                <div class="admin-dropdown dropdown">
                    <button class="admin-dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="admin-avatar">
                            {{ strtoupper(substr(auth('admin')->user()->first_name, 0, 1)) }}
                        </div>
                        <div class="admin-info d-none d-md-block">
                            <div class="name">{{ auth('admin')->user()->first_name }} {{ auth('admin')->user()->last_name }}</div>
                            <div class="role">{{ auth('admin')->user()->isSuperAdmin() ? 'Super Admin' : 'Admin' }}</div>
                        </div>
                        <i class="bi bi-chevron-down ms-1 d-none d-md-block"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-person"></i>
                                My Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-gear"></i>
                                Account Settings
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right"></i>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        
        <!-- Content -->
        <div class="admin-content">
            @if (session('success'))
                <div class="alert alert-success d-flex align-items-center mb-4">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif
            
            @if (session('error'))
                <div class="alert alert-danger d-flex align-items-center mb-4">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ session('error') }}
                </div>
            @endif
            
            @yield('content')
        </div>
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('adminSidebar').classList.toggle('show');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('adminSidebar');
            const toggle = document.querySelector('.sidebar-toggle');
            
            if (window.innerWidth < 992 && 
                !sidebar.contains(event.target) && 
                !toggle.contains(event.target) && 
                sidebar.classList.contains('show')) {
                toggleSidebar();
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>