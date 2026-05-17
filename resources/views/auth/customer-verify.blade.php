<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Code</title>

    <link rel="stylesheet" href="/css/customer.css">
</head>
<body>

<div class="main-container">

    <div class="header-logo">
        <div class="logo-circle">
            🔐
        </div>
    </div>

    <h1 class="main-title">Chace and Cherrie Cakes</h1>
    <p class="main-subtitle">Email Verification</p>

    <div class="login-card">

        <a href="{{ route('customer.login') }}" class="back-link">
            ← Back to Login
        </a>

        <div class="customer-icon-wrapper">
            <div class="customer-icon">
                ✉️
            </div>
        </div>

        <h2 class="login-title">Verify Code</h2>

        @if(session('error'))
            <div style="color:red; margin-bottom:15px;">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST"
              action="{{ route('customer.verify.code') }}"
              class="login-form">

            @csrf

            <div class="form-group">

                <label class="form-label">
                    Verification Code
                </label>

                <div class="input-group">

                    <span class="input-icon">
                        🔢
                    </span>

                    <input
                        type="text"
                        name="code"
                        class="form-input"
                        placeholder="Enter 6-digit code"
                        required
                    >

                </div>

            </div>

            <button type="submit" class="btn-login">
                Verify Code
            </button>

        </form>

    </div>

</div>

</body>
</html>