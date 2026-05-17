<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Login - Chace and Cherrie Cakes</title>

   <link rel="stylesheet" href="/css/customer.css">
</head>
<body>

<div class="main-container">

    <!-- Header Logo -->
    <div class="header-logo">
        <div class="logo-circle">
            🚚
        </div>
    </div>

    <!-- Title -->
    <h1 class="main-title">Chace and Cherrie Cakes</h1>
    <p class="main-subtitle">Delivery Management System</p>

    <!-- Login Card -->
    <div class="login-card">

        <!-- Back -->
        <a href="{{ route('login') }}" class="back-link">
            ← Back to role selection
        </a>

        <!-- Icon -->
        <div class="customer-icon-wrapper">
            <div class="customer-icon">
                🛵
            </div>
        </div>

        <!-- Title -->
        <h2 class="login-title">Delivery Login</h2>

        <!-- Form -->
        <form method="POST"
              action="{{ route('delivery.login.submit') }}"
              class="login-form">

            @csrf

            <!-- Email -->
            <div class="form-group">

                <label class="form-label">
                    Email
                </label>

                <div class="input-group">

                    <span class="input-icon">
                        📧
                    </span>

                    <input
                        type="email"
                        name="email"
                        class="form-input"
                        placeholder="Enter your email"
                        required
                    >

                </div>
            </div>

            <!-- Password -->
            <div class="form-group">

                <label class="form-label">
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

                </div>
            </div>

            <!-- Login Button -->
            <button type="submit" class="btn-login">
                Login
            </button>

            <!-- Register -->
            <p class="register-text">
                Don't have an account?

                <a href="{{ route('delivery.register') }}"
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