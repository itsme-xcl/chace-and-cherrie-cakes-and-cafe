<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Admin</title>

    <link rel="stylesheet" href="{{ asset('css/customer.css') }}">
</head>
<body>

<div class="main-container">

    <!-- Logo -->
    <div class="header-logo">
        <div class="logo-circle">
            🔒
        </div>
    </div>

    <!-- Title -->
    <h1 class="main-title">Chace and Cherrie Cakes</h1>
    <p class="main-subtitle">Reset Admin Password</p>

    <!-- Card -->
    <div class="login-card">

        <div class="customer-icon-wrapper">
            <div class="customer-icon">
                🛠️
            </div>
        </div>

        <h2 class="login-title">
            Create New Password
        </h2>

        <!-- ERROR -->
        @if(session('error'))
            <div style="color:red; margin-bottom:15px;">
                {{ session('error') }}
            </div>
        @endif

        <!-- FORM -->
        <form method="POST"
              action="{{ route('admin.reset.password') }}"
              class="login-form">

            @csrf

            <!-- PASSWORD -->
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

            <!-- CONFIRM PASSWORD -->
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

            <button type="submit"
                    class="btn-login">

                Reset Password

            </button>

        </form>

    </div>

</div>

</body>
</html>