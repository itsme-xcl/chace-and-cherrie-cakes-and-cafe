<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>

    <link rel="stylesheet" href="{{ asset('css/customer.css') }}">
</head>
<body>

<div class="main-container">

    <div class="header-logo">
        <div class="logo-circle">
            🔑
        </div>
    </div>

    <h1 class="main-title">Chace and Cherrie Cakes</h1>
    <p class="main-subtitle">Reset Customer Password</p>

    <div class="login-card">

        <a href="{{ route('customer.login') }}" class="back-link">
            ← Back to Login
        </a>

        <div class="customer-icon-wrapper">
            <div class="customer-icon">
                🔒
            </div>
        </div>

        <h2 class="login-title">Reset Password</h2>

        @if(session('error'))
            <div style="color:red; margin-bottom:15px;">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST"
              action="{{ route('customer.reset.password') }}"
              class="login-form">

            @csrf

            <div class="form-group">

                <label class="form-label">
                    New Password
                </label>

                <div class="input-group">

                    <span class="input-icon">
                        🔒
                    </span>

                    <input
                        type="password"
                        name="password"
                        class="form-input"
                        placeholder="Enter new password"
                        required
                    >

                </div>

            </div>

            <div class="form-group">

                <label class="form-label">
                    Confirm Password
                </label>

                <div class="input-group">

                    <span class="input-icon">
                        🔐
                    </span>

                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-input"
                        placeholder="Confirm password"
                        required
                    >

                </div>

            </div>

            <button type="submit" class="btn-login">
                Reset Password
            </button>

        </form>

    </div>

</div>

</body>
</html>