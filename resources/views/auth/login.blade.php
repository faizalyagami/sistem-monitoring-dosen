{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIMONKER - Sistem Monitoring Kinerja Dosen</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .bg-animation .circle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 20s infinite;
        }

        .circle-1 {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }

        .circle-2 {
            width: 500px;
            height: 500px;
            bottom: -200px;
            right: -100px;
            animation-delay: 5s;
        }

        .circle-3 {
            width: 200px;
            height: 200px;
            top: 50%;
            left: 50%;
            animation-delay: 10s;
        }

        .circle-4 {
            width: 400px;
            height: 400px;
            bottom: 10%;
            left: -150px;
            animation-delay: 3s;
        }

        .circle-5 {
            width: 250px;
            height: 250px;
            top: 20%;
            right: -50px;
            animation-delay: 7s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0) rotate(0deg);
            }

            33% {
                transform: translate(30px, -30px) rotate(120deg);
            }

            66% {
                transform: translate(-20px, 20px) rotate(240deg);
            }
        }

        /* Login Card */
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 30px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
            backdrop-filter: blur(10px);
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }

        .login-header .logo {
            width: 100px;
            height: 100px;
            margin: 0 auto 20px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
        }

        .login-header .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 50%;
            background: white;
        }

        .login-header h3 {
            font-weight: 700;
            margin-bottom: 10px;
        }

        .login-header p {
            opacity: 0.9;
            font-size: 14px;
            margin-bottom: 0;
        }

        .login-body {
            padding: 40px 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
            font-size: 14px;
        }

        .input-group-custom {
            position: relative;
        }

        .input-group-custom i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 18px;
            z-index: 10;
        }

        .input-group-custom input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s;
            background: white;
        }

        .input-group-custom input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .input-group-custom input.error {
            border-color: #e74c3c;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
            z-index: 10;
        }

        .checkbox-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .checkbox-group label {
            margin-bottom: 0;
            font-weight: normal;
            cursor: pointer;
        }

        .checkbox-group input {
            margin-right: 8px;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .demo-accounts {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        .demo-accounts h6 {
            font-size: 13px;
            color: #666;
            margin-bottom: 15px;
        }

        .demo-badge {
            display: inline-block;
            padding: 8px 15px;
            background: #f5f5f5;
            border-radius: 10px;
            margin: 5px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .demo-badge:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        .demo-badge strong {
            font-weight: 600;
        }

        .alert-custom {
            padding: 12px 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: shake 0.5s;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        .alert-custom i {
            font-size: 20px;
        }

        .alert-custom.alert-danger {
            background: #fee2e2;
            color: #e74c3c;
            border-left: 4px solid #e74c3c;
        }

        .footer-text {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.8);
        }

        @media (max-width: 768px) {
            .login-card {
                max-width: 95%;
            }

            .login-header {
                padding: 30px 20px;
            }

            .login-body {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="bg-animation">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
        <div class="circle circle-3"></div>
        <div class="circle circle-4"></div>
        <div class="circle circle-5"></div>
    </div>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo">
                    <img src="{{ asset('img/logo-fakultas-psikologi.jpg') }}" alt="Logo Fakultas Psikologi">
                </div>
                <h3>Sistem Monitoring Kinerja Dosen</h3>
                <p>SIMONKER - Version 1.0</p>
            </div>

            <div class="login-body">
                @if ($errors->any())
                    <div class="alert-custom alert-danger">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div>
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert-custom alert-danger">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    <div class="form-group">
                        <label>Email Address</label>
                        <div class="input-group-custom">
                            <i class="bi bi-envelope"></i>
                            <input type="email" name="email" value="{{ old('email') }}"
                                placeholder="Enter your email" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-group-custom">
                            <i class="bi bi-lock"></i>
                            <input type="password" name="password" id="password" placeholder="Enter your password"
                                required>
                            <i class="bi bi-eye-slash toggle-password" id="togglePassword"></i>
                        </div>
                    </div>

                    <div class="checkbox-group">
                        <label>
                            <input type="checkbox" name="remember"> Remember Me
                        </label>
                        <a href="{{ route('password.request') }}"
                            style="color: #667eea; text-decoration: none; font-size: 14px;">
                            Forgot Password?
                        </a>
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
                    </button>
                </form>

                <div class="demo-accounts">
                    <h6><i class="bi bi-info-circle me-1"></i> Demo Accounts</h6>
                    <div class="demo-badge" onclick="fillDemo('admin@unisba.ac.id', 'password123')">
                        <i class="bi bi-shield-lock"></i> <strong>Admin</strong>
                    </div>
                    <div class="demo-badge" onclick="fillDemo('siti.nurhayati@unisba.ac.id', 'password123')">
                        <i class="bi bi-person-badge"></i> <strong>Dosen 1</strong>
                    </div>
                    <div class="demo-badge" onclick="fillDemo('ahmad.rizal@unisba.ac.id', 'password123')">
                        <i class="bi bi-person-badge"></i> <strong>Dosen 2</strong>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });

        // Fill demo account
        function fillDemo(email, pwd) {
            document.querySelector('input[name="email"]').value = email;
            document.querySelector('input[name="password"]').value = pwd;

            // Add effect
            const emailField = document.querySelector('input[name="email"]');
            const pwdField = document.querySelector('input[name="password"]');
            emailField.style.borderColor = '#27ae60';
            pwdField.style.borderColor = '#27ae60';
            setTimeout(() => {
                emailField.style.borderColor = '#e0e0e0';
                pwdField.style.borderColor = '#e0e0e0';
            }, 1000);
        }

        // Loading effect on submit
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.querySelector('.btn-login');
            btn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> Signing in...';
            btn.disabled = true;
        });
    </script>
</body>

</html>
