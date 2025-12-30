<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Authentication') - Service Rabbit</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #FF6B35;
            --primary-dark: #e55a2b;
            --primary-light: #ff8c5a;
            --secondary: #667eea;
            --secondary-dark: #764ba2;
            --dark: #1f2937;
            --dark-light: #374151;
            --gray: #6b7280;
            --gray-light: #9ca3af;
            --gray-lighter: #e5e7eb;
            --gray-lightest: #f3f4f6;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, rgba(26, 26, 46, 0.9) 0%, rgba(45, 45, 80, 0.85) 50%, rgba(26, 26, 46, 0.9) 100%);
            position: relative;
            display: flex;
            flex-direction: column;
        }
        
        /* NEW BACKGROUND - Team collaboration / Professional services */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&w=1920&q=80') center center;
            background-size: cover;
            z-index: -1;
        }
        
        /* Auth Navbar */
        .auth-navbar {
            padding: 20px 0;
            position: relative;
            z-index: 10;
        }
        
        .auth-navbar .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        
        .auth-navbar .brand-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.4rem;
        }
        
        .auth-navbar .btn-back {
            color: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 10px 20px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .auth-navbar .btn-back:hover {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.3);
        }
        
        /* Main Content */
        .auth-main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            position: relative;
            z-index: 10;
        }
        
        /* Auth Card */
        .auth-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 480px;
            overflow: hidden;
            animation: fadeInUp 0.5s ease;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Auth Header */
        .auth-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 50%, #ffd700 100%);
            padding: 40px 40px 35px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .auth-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -30%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        
        .auth-header::after {
            content: '';
            position: absolute;
            bottom: -60%;
            left: -20%;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }
        
        .auth-header-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2.2rem;
            color: white;
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 1;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .auth-header h2 {
            color: white;
            font-weight: 700;
            font-size: 1.85rem;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .auth-header p {
            color: rgba(255, 255, 255, 0.95);
            margin: 0;
            font-size: 1rem;
            position: relative;
            z-index: 1;
        }
        
        .auth-body {
            padding: 40px;
        }
        
        /* Form Styles */
        .form-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 10px;
            font-size: 0.9rem;
        }
        
        .input-group {
            border: 2px solid var(--gray-lighter);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            background: white;
        }
        
        .input-group:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.1);
        }
        
        .input-group-text {
            background: transparent;
            border: none;
            color: var(--gray-light);
            padding: 14px 16px;
            font-size: 1.1rem;
        }
        
        .input-group .form-control {
            border: none;
            padding: 14px 16px 14px 0;
            font-size: 1rem;
            background: transparent;
        }
        
        .input-group .form-control:focus {
            box-shadow: none;
        }
        
        .input-group .form-control::placeholder {
            color: var(--gray-light);
        }
        
        .input-group .btn {
            border: none;
            background: transparent;
            color: var(--gray-light);
            padding: 14px 16px;
        }
        
        .input-group .btn:hover {
            color: var(--primary);
            background: transparent;
        }
        
        .form-check-input {
            width: 20px;
            height: 20px;
            border: 2px solid var(--gray-lighter);
            margin-top: 2px;
            cursor: pointer;
        }
        
        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .form-check-input:focus {
            box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.1);
            border-color: var(--primary);
        }
        
        .form-check-label {
            color: var(--gray);
            font-size: 0.9rem;
            cursor: pointer;
            margin-left: 5px;
        }
        
        /* Primary Button */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border: none;
            padding: 16px 28px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.05rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .btn-primary:hover::before {
            left: 100%;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(255, 107, 53, 0.35);
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
        }
        
        .btn-primary:active {
            transform: translateY(-1px);
        }
        
        /* Divider */
        .auth-divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 28px 0;
            color: var(--gray-light);
            font-size: 0.85rem;
        }
        
        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--gray-lighter);
        }
        
        .auth-divider span {
            padding: 0 18px;
            text-transform: uppercase;
            font-weight: 500;
            letter-spacing: 0.5px;
        }
        
        /* Social Buttons */
        .social-login-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 14px 20px;
            border: 2px solid var(--gray-lighter);
            border-radius: 12px;
            background: white;
            color: var(--dark);
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .social-login-btn:hover {
            border-color: var(--primary);
            background: rgba(255, 107, 53, 0.05);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        
        /* Auth Footer */
        .auth-footer {
            padding: 25px 40px;
            background: var(--gray-lightest);
            text-align: center;
            border-top: 1px solid var(--gray-lighter);
        }
        
        .auth-footer p {
            color: var(--gray);
            font-size: 0.95rem;
            margin: 0;
        }
        
        .auth-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .auth-footer a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
        
        /* Alert */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 16px 20px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            color: #dc2626;
            border-left: 4px solid #dc2626;
        }
        
        .alert-success {
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            color: #059669;
            border-left: 4px solid #059669;
        }
        
        /* Invalid Feedback */
        .invalid-feedback {
            font-size: 0.85rem;
            margin-top: 8px;
            color: #dc2626;
        }
        
        /* Forgot Password Link */
        .forgot-link {
            color: var(--primary);
            font-weight: 500;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .forgot-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
        
        /* Page Footer */
        .auth-page-footer {
            padding: 20px;
            text-align: center;
            position: relative;
            z-index: 10;
        }
        
        .auth-page-footer p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.85rem;
            margin: 0;
        }
        
        .auth-page-footer a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .auth-page-footer a:hover {
            color: white;
        }
        
        /* Responsive */
        @media (max-width: 575.98px) {
            .auth-navbar {
                padding: 15px 0;
            }
            
            .auth-navbar .navbar-brand {
                font-size: 1.25rem;
            }
            
            .auth-navbar .brand-icon {
                width: 38px;
                height: 38px;
                font-size: 1.2rem;
            }
            
            .auth-navbar .btn-back span {
                display: none;
            }
            
            .auth-card {
                border-radius: 20px;
            }
            
            .auth-header {
                padding: 30px 25px 25px;
            }
            
            .auth-header h2 {
                font-size: 1.5rem;
            }
            
            .auth-header-icon {
                width: 65px;
                height: 65px;
                font-size: 1.8rem;
            }
            
            .auth-body {
                padding: 30px 25px;
            }
            
            .auth-footer {
                padding: 20px 25px;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="auth-navbar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <div class="brand-icon">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    ServiceRabbit
                </a>
                <a href="{{ route('home') }}" class="btn-back">
                    <i class="bi bi-arrow-left"></i>
                    <span>Back to Home</span>
                </a>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main class="auth-main">
        <div class="container">
            <div class="d-flex justify-content-center">
                @yield('content')
            </div>
        </div>
    </main>
    
    <!-- Footer -->
    <footer class="auth-page-footer">
        <div class="container">
            <p>© {{ date('Y') }} ServiceRabbit. All rights reserved. | <a href="#">Privacy</a> | <a href="#">Terms</a></p>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>