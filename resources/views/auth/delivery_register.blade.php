<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Signup - Chace and Cherrie Cakes</title>

    <link rel="stylesheet" href="{{ asset('css/customer.css') }}">
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

    <!-- Card -->
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
        <h2 class="login-title">Delivery Signup</h2>

        <!-- Form -->
        <form method="POST"
              action="{{ route('delivery.register.submit') }}"
              class="login-form">

            @csrf

            <!-- Validation Errors -->
            @if ($errors->any())

                <div style="color:red; margin-bottom:10px;">

                    <ul>

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <!-- Name -->
            <div class="form-group">

                <label class="form-label">
                    Full Name
                </label>

                <input
                    type="text"
                    name="name"
                    class="form-input"
                    placeholder="Enter full name"
                    value="{{ old('name') }}"
                    required
                >

            </div>

            <!-- Email -->
            <div class="form-group">

                <label class="form-label">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    class="form-input"
                    placeholder="Enter email"
                    value="{{ old('email') }}"
                    required
                >

            </div>

            <!-- Password -->
            <div class="form-group">

                <label class="form-label">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    class="form-input"
                    placeholder="Enter password"
                    required
                >

            </div>

            <!-- Confirm Password -->
            <div class="form-group">

                <label class="form-label">
                    Confirm Password
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    class="form-input"
                    placeholder="Confirm password"
                    required
                >

            </div>

            <!-- Submit -->
            <button type="submit" class="btn-login">
                Create Delivery Account
            </button>

        </form>

    </div>

</div>

<script src="{{ asset('js/customer.js') }}"></script>

</body>
</html>