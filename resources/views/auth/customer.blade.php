<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login - Chace and Cherrie Cakes</title>

    <link rel="stylesheet" href="{{ asset('css/customer.css') }}">
</head>
<body>

<div class="main-container">

    <!-- Header Logo -->
    <div class="header-logo">
        <div class="logo-circle">
            🍰
        </div>
    </div>

    <!-- Title -->
    <h1 class="main-title">Chace and Cherrie Cakes</h1>
    <p class="main-subtitle">Order Management System</p>

    <!-- Login Card -->
    <div class="login-card">

        <!-- Back to role selection -->
        <a href="{{ route('login') }}" class="back-link">
            ← Back to role selection
        </a>

        <!-- Customer Icon -->
        <div class="customer-icon-wrapper">
            <div class="customer-icon">
                👤
            </div>
        </div>

        <!-- Login Title -->
        <h2 class="login-title">Customer Login</h2>

        <!-- SUCCESS MESSAGE -->
        @if(session('success'))

            <div style="
                background:#dcfce7;
                color:#166534;
                padding:12px;
                border-radius:10px;
                margin-bottom:15px;
                font-size:14px;
            ">
                {{ session('success') }}
            </div>

        @endif

        <!-- ERROR MESSAGE -->
        @if($errors->any())

            <div style="
                background:#fee2e2;
                color:#991b1b;
                padding:12px;
                border-radius:10px;
                margin-bottom:15px;
                font-size:14px;
            ">
                {{ $errors->first() }}
            </div>

        @endif

        <!-- Login Form -->
        <form method="POST"
              action="{{ route('customer.login.submit') }}"
              class="login-form">

            @csrf

            <!-- Email Field -->
            <div class="form-group">

                <label for="email" class="form-label">
                    Email
                </label>

                <div class="input-group">

                    <span class="input-icon">
                        📧
                    </span>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-input"
                        placeholder="Enter your email"
                        value="{{ old('email') }}"
                        required
                    >

                </div>

            </div>

            <!-- Password Field -->
            <div class="form-group">

                <label for="password" class="form-label">
                    Password
                </label>

                <div class="input-group">

                    <span class="input-icon">
                        🔒
                    </span>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-input password-input"
                        placeholder="Enter password"
                        required
                    >

                    <button type="button"
                            class="toggle-password"
                            onclick="togglePassword()">

                        <svg class="eye-icon"
                             width="20"
                             height="20"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">

                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>

                            <circle cx="12" cy="12" r="3"></circle>

                        </svg>

                    </button>

                </div>

            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="form-options">

                <label class="remember-checkbox">
                    <input type="checkbox" name="remember">
                    <span>Remember me</span>
                </label>

                <!-- UPDATED FORGOT PASSWORD LINK -->
                <a href="{{ route('customer.forgot') }}"
                   class="forgot-password">

                    Forgot password?

                </a>

            </div>

            <!-- Login Button -->
            <button type="submit" class="btn-login">
                Login
            </button>

            <!-- Register Link -->
            <p class="register-text">
                Don't have an account?

                <a href="{{ route('customer.register') }}"
                   class="register-link">

                    Sign up

                </a>
            </p>

        </form>

    </div>

</div>

<script src="{{ asset('js/customer.js') }}"></script>

</body>
</html>