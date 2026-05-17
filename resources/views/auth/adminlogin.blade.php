<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Chace and Cherrie Cakes</title>
    <link rel="stylesheet" href="/css/customer.css">
</head>
<body>

<div class="main-container">

    <!-- Logo -->
    <div class="header-logo">
        <div class="logo-circle">🍰</div>
    </div>

    <!-- Title -->
    <h1 class="main-title">Chace and Cherrie Cakes</h1>
    <p class="main-subtitle">Admin Panel</p>

    <!-- Login Card -->
    <div class="login-card">

        <!-- Back -->
        <a href="{{ route('login') }}" class="back-link">
            ← Back to role selection
        </a>

        <!-- Icon -->
        <div class="customer-icon-wrapper">
            <div class="customer-icon">🛠️</div>
        </div>

        <!-- Title -->
        <h2 class="login-title">Admin Login</h2>

        <!-- LOGIN FORM -->
        <form method="POST" action="{{ route('admin.login.submit') }}" class="login-form">
            @csrf

            <!-- SUCCESS MESSAGE -->
            @if(session('success'))
                <div style="color:green; margin-bottom:10px;">
                    {{ session('success') }}
                </div>
            @endif

            <!-- ERROR MESSAGE -->
            @if(session('error'))
                <div style="color:red; margin-bottom:10px;">
                    {{ session('error') }}
                </div>
            @endif

            <!-- USERNAME -->
            <div class="form-group">
                <label class="form-label">Username</label>
                <div class="input-group">
                    <input 
                        type="text" 
                        name="username" 
                        class="form-input"
                        placeholder="Enter username"
                        required
                    >
                </div>
            </div>

            <!-- PASSWORD -->
            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <input 
                        type="password" 
                        name="password" 
                        class="form-input"
                        placeholder="Enter password"
                        required
                    >
                </div>
            </div>

            <div style="text-align:right; margin-bottom:15px;">
                <a href="{{ route('admin.forgot') }}"
                style="font-size:14px; color:#e91e63; text-decoration:none;">

                    Forgot Password?

                </a>
            </div>

            <!-- LOGIN BUTTON -->
            <button type="submit" class="btn-login">Login</button>

        </form>
    </div>
</div>

<script src="{{ asset('js/customer.js') }}"></script>

</body>
</html>