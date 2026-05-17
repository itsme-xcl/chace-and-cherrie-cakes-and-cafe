<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Forgot Password</title>

    <link rel="stylesheet" href="{{ asset('css/customer.css') }}">
</head>
<body>

<div class="main-container">

    <div class="header-logo">
        <div class="logo-circle">
            🎂
        </div>
    </div>

    <h1 class="main-title">Chace and Cherrie Cakes</h1>
    <p class="main-subtitle">Customer Password Recovery</p>

    <div class="login-card">

        <a href="{{ route('customer.login') }}" class="back-link">
            ← Back to Login
        </a>

        <div class="customer-icon-wrapper">
            <div class="customer-icon">
                📧
            </div>
        </div>

        <h2 class="login-title">Forgot Password</h2>

        @if(session('error'))
            <div style="color:red; margin-bottom:15px;">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div style="color:green; margin-bottom:15px;">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST"
              action="{{ route('customer.send.code') }}"
              class="login-form">

            @csrf

            <div class="form-group">

                <label class="form-label">
                    Customer Email
                </label>

                <div class="input-group">

                    <span class="input-icon">
                        📧
                    </span>

                    <input
                        type="email"
                        name="email"
                        class="form-input"
                        placeholder="Enter your registered email"
                        required
                    >

                </div>

            </div>

            <button type="submit" class="btn-login">
                Send Verification Code
            </button>

        </form>

    </div>

</div>

</body>
</html>