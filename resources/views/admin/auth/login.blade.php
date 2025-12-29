<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - Service Rabbit</title>
    
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
        }
        
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1A1A2E 0%, #16213E 50%, #0F3460 100%);
            position: relative;
            overflow: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            pointer-events: none;
        }
        
        .admin-login-container {
            width: 100%;
            max-width: 440px;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }
        
        .admin-login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            overflow: hidden;
        }
        
        .admin-login-header {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--accent) 100%);
            padding: 2.5rem 2rem;
            text-align: center;
            position: relative;
        }
        
        .admin-login-header::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 0;
            right: 0;
            height: 40px;
            background: white;
            border-radius: 20px 20px 0 0;
        }
        
        .admin-logo {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary), #ff8c5a);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.3);
        }
        
        .admin-logo i {
            font-size: 2rem;
            color: white;
        }
        
        .admin-login-header h1 {
            color: white;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        
        .admin-login-header p {
            color: rgba(255,255,255,0.7);
            font-size: 0.9rem;
            margin: 0;
        }
        
        .admin-login-body {
            padding: 2.5rem 2rem 2rem;
        }
        
        .form-floating {
            margin-bottom: 1.25rem;
        }
        
        .form-floating > .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            height: 58px;
            padding: 1rem 1rem 0.5rem 3rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        
        .form-floating > .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.1);
        }
        
        .form-floating > label {
            padding-left: 3rem;
            color: #6c757d;
        }
        
        .form-floating .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #adb5bd;
            font-size: 1.1rem;
            transition: color 0.3s ease;
            z-index: 5;
        }
        
        .form-floating:focus-within .input-icon {
            color: var(--primary);
        }
        
        .form-check {
            margin-bottom: 1.5rem;
        }
        
        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .form-check-label {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .btn-admin-login {
            width: 100%;
            padding: 0.9rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--secondary) 0%, var(--accent) 100%);
            border: none;
            color: white;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-admin-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(26, 26, 46, 0.3);
            color: white;
        }
        
        .btn-admin-login:active {
            transform: translateY(0);
        }
        
        .admin-login-footer {
            padding: 1.5rem 2rem;
            background: #f8f9fa;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        
        .admin-login-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .admin-login-footer a:hover {
            color: var(--secondary);
        }
        
        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
        }
        
        .alert-danger {
            background: #fff5f5;
            color: #dc3545;
        }
        
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }
        
        .shape {
            position: absolute;
            background: rgba(255, 107, 53, 0.1);
            border-radius: 50%;
        }
        
        .shape-1 {
            width: 300px;
            height: 300px;
            top: -150px;
            right: -100px;
        }
        
        .shape-2 {
            width: 200px;
            height: 200px;
            bottom: -100px;
            left: -50px;
        }
        
        .shape-3 {
            width: 150px;
            height: 150px;
            bottom: 20%;
            right: 10%;
            background: rgba(255, 255, 255, 0.05);
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #adb5bd;
            cursor: pointer;
            padding: 0;
            z-index: 10;
        }

        .password-toggle:hover {
            color: var(--primary);
        }
    </style>
</head>
<body>
    <div class="floating-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>
    
    <div class="admin-login-container">
        <div class="admin-login-card">
            <div class="admin-login-header">
                <div class="admin-logo">
                    <i class="bi bi-shield-lock"></i>
                </div>
                <h1>Admin Portal</h1>
                <p>Service Rabbit Management</p>
            </div>
            
            <div class="admin-login-body">
                @if ($errors->any())
                    <div class="alert alert-danger d-flex align-items-center">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        <div>
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    </div>
                @endif
                
                @if (session('status'))
                    <div class="alert alert-success d-flex align-items-center">
                        <i class="bi bi-check-circle me-2"></i>
                        <div>{{ session('status') }}</div>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf
                    
                    <div class="form-floating position-relative">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               placeholder="admin@example.com" 
                               required 
                               autofocus>
                        <label for="email">Email Address</label>
                    </div>
                    
                    <div class="form-floating position-relative">
                        <i class="bi bi-lock input-icon"></i>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="Password" 
                               required>
                        <label for="password">Password</label>
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="bi bi-eye" id="password-icon"></i>
                        </button>
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            Keep me logged in
                        </label>
                    </div>
                    
                    <button type="submit" class="btn btn-admin-login">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Sign In to Dashboard
                    </button>
                </form>
            </div>
            
            <div class="admin-login-footer">
                <p class="mb-0">
                    <i class="bi bi-arrow-left me-1"></i>
                    <a href="{{ url('/') }}">Back to Website</a>
                </p>
            </div>
        </div>
        
        <p class="text-center mt-4 text-white-50 small">
            &copy; {{ date('Y') }} Service Rabbit. All rights reserved.
        </p>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            const field = document.getElementById('password');
            const icon = document.getElementById('password-icon');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>
</body>
</html>