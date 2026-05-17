<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Admin</title>

    <link rel="stylesheet" href="/css/customer.css">
</head>
<body>

<div class="main-container">

    <!-- Logo -->
    <div class="header-logo">
        <div class="logo-circle">
            🔑
        </div>
    </div>

    <!-- Title -->
    <h1 class="main-title">Chace and Cherrie Cakes</h1>
    <p class="main-subtitle">Admin Password Recovery</p>

    <!-- Card -->
    <div class="login-card">

        <a href="{{ route('admin.login') }}"
           class="back-link">

            ← Back to Login

        </a>

        <div class="customer-icon-wrapper">
            <div class="customer-icon">
                📧
            </div>
        </div>

        <h2 class="login-title">
            Forgot Password
        </h2>

        <!-- ERROR -->
        @if(session('error'))
            <div style="color:red; margin-bottom:15px;">
                {{ session('error') }}
            </div>
        @endif

        <!-- FORM -->
        <form method="POST"
              action="{{ route('admin.send.code') }}"
              class="login-form">

            @csrf

            <div class="form-group">

                <label class="form-label">
                    Admin Email
                </label>

                <div class="input-group">

                    <span class="input-icon">
                        📧
                    </span>

                    <input
                        type="email"
                        name="email"
                        class="form-input"
                        placeholder="Enter admin email"
                        required
                    >

                </div>

            </div>

            <button type="submit"
                    class="btn-login">

                Send Verification Code

            </button>

        </form>

    </div>

</div>

</body>
</html>