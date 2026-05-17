<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baker Login - Chace and Cherrie Cakes</title>

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

        <!-- Back -->
        <a href="{{ route('login') }}" class="back-link">
            ← Back to role selection
        </a>

        <!-- Baker Icon -->
        <div class="customer-icon-wrapper">
            <div class="customer-icon"
                 style="background: linear-gradient(135deg, #6dd5ed, #2193b0);">
                👨‍🍳
            </div>
        </div>

        <!-- Title -->
        <h2 class="login-title">Baker Login</h2>

        <!-- FORM -->
        <form method="POST"
              action="{{ route('baker.login.submit') }}"
              class="login-form">

            @csrf

            <!-- ERROR -->
            @if(session('error'))
                <div style="color:red; margin-bottom:10px;">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Username -->
            <div class="form-group">

                <label class="form-label">
                    Username
                </label>

                <div class="input-group">

                    <span class="input-icon">
                        👤
                    </span>

                    <input
                        type="text"
                        name="username"
                        class="form-input"
                        placeholder="Enter username"
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
                        name="password"
                        class="form-input password-input"
                        placeholder="Enter password"
                        required
                    >

                </div>

            </div>

            <!-- BUTTON -->
            <button type="submit" class="btn-login">
                Login
            </button>

        </form>

    </div>

</div>

<script src="{{ asset('js/customer.js') }}"></script>

</body>
</html>