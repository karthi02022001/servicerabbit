<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Service Rabbit') - Get Things Done</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <!-- In layouts/app.blade.php (for dashboard pages) -->
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <div class="brand-icon">
                    <i class="bi bi-box-seam"></i>
                </div>
                ServiceRabbit
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Services</a>
                        <ul class="dropdown-menu">
                            @php
                                $navCategories = \App\Models\TaskCategory::where('status', 'active')->orderBy('sort_order')->take(8)->get();
                            @endphp
                            @forelse($navCategories as $navCat)
                                <li>
                                    <a class="dropdown-item" href="{{ route('categories.show', $navCat->slug) }}">
                                        <i class="bi bi-arrow-right-short"></i> {{ $navCat->name }}
                                    </a>
                                </li>
                            @empty
                                <li><a class="dropdown-item" href="{{ route('categories.index') }}">View All Services</a></li>
                            @endforelse
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('categories.index') }}"><i class="bi bi-grid"></i> All Categories</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('taskers.*') ? 'active' : '' }}" href="{{ route('taskers.index') }}">Find Taskers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#how-it-works">How It Works</a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center gap-3 navbar-nav-right">
                    @guest
                        <a href="{{ route('become-tasker') }}" class="become-tasker-link d-none d-lg-block">Become a Tasker</a>
                        <a href="{{ route('login') }}" class="btn btn-nav-login">Log In</a>
                        <a href="{{ route('register') }}" class="btn btn-nav-signup">Sign Up</a>
                    @else
                        <div class="dropdown user-dropdown">
                            <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <div class="user-avatar">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="{{ auth()->user()->first_name }}">
                                    @else
                                        {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}{{ strtoupper(substr(auth()->user()->last_name, 0, 1)) }}
                                    @endif
                                </div>
                                <span class="user-name d-none d-lg-inline">{{ auth()->user()->first_name }}</span>
                                <i class="bi bi-chevron-down" style="font-size: 0.7rem; color: inherit;"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                        <i class="bi bi-speedometer2"></i> Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.bookings.index') }}">
                                        <i class="bi bi-calendar-check"></i> My Bookings
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.messages.index') }}">
                                        <i class="bi bi-chat-dots"></i> Messages
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                @if(auth()->user()->is_tasker)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('tasker.dashboard') }}">
                                            <i class="bi bi-briefcase"></i> Tasker Dashboard
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                @else
                                    <li>
                                        <a class="dropdown-item" href="{{ route('become-tasker') }}">
                                            <i class="bi bi-briefcase"></i> Become a Tasker
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.profile.edit') }}">
                                        <i class="bi bi-person-gear"></i> Settings
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main>
        @if(session('success'))
            <div class="container mt-3" style="">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="container mt-3" style="">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif
        
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4">
                    <div class="footer-brand">
                        <div class="brand-icon">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <h4>ServiceRabbit</h4>
                    </div>
                    <p class="footer-description">
                        Connect with trusted taskers in your area for all your home service needs. Quality work, fair prices, guaranteed satisfaction.
                    </p>
                    <div class="footer-social">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-twitter-x"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
                
                <div class="col-6 col-md-3 col-lg-2">
                    <h5 class="footer-title">Company</h5>
                    <ul class="footer-links">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Press</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
                
                <div class="col-6 col-md-3 col-lg-2">
                    <h5 class="footer-title">Services</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('search', ['q' => 'cleaning']) }}">Cleaning</a></li>
                        <li><a href="{{ route('search', ['q' => 'handyman']) }}">Handyman</a></li>
                        <li><a href="{{ route('search', ['q' => 'moving']) }}">Moving</a></li>
                        <li><a href="{{ route('search', ['q' => 'delivery']) }}">Delivery</a></li>
                        <li><a href="{{ route('categories.index') }}">All Services</a></li>
                    </ul>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <h5 class="footer-title">Contact Us</h5>
                    <div class="footer-contact-item">
                        <i class="bi bi-geo-alt"></i>
                        <span>123 Service Street, Suite 100<br>San Francisco, CA 94102</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="bi bi-envelope"></i>
                        <span>support@servicerabbit.com</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="bi bi-telephone"></i>
                        <span>+1 (555) 123-4567</span>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="footer-bottom-content">
                    <p class="footer-copyright">
                        © {{ date('Y') }} ServiceRabbit. All rights reserved.
                    </p>
                    <div class="footer-bottom-links">
                        <a href="#">Privacy Policy</a>
                        <a href="#">Terms of Service</a>
                        <a href="#">Cookie Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Navbar Scroll Effect -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.getElementById('mainNavbar');
            
            function handleScroll() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            }
            
            window.addEventListener('scroll', handleScroll);
            handleScroll();
        });
    </script>
    
    @stack('scripts')
</body>
</html>