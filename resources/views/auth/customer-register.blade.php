<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Signup - Chace and Cherrie Cakes</title>
    <link rel="stylesheet" href="/css/customer.css">
</head>
<body>
    <div class="main-container">

        <!-- Header Logo -->
        <div class="header-logo">
            <div class="logo-circle">🍰</div>
        </div>

        <!-- Title -->
        <h1 class="main-title">Chace and Cherrie Cakes</h1>
        <p class="main-subtitle">Order Management System</p>

        <!-- Signup Card -->
        <div class="login-card">

            <!-- Back Link -->
            <a href="{{ route('login') }}" class="back-link">
                ← Back to role selection
            </a>

            <!-- Customer Icon -->
            <div class="customer-icon-wrapper">
                <div class="customer-icon">👤</div>
            </div>

            <!-- Signup Title -->
            <h2 class="login-title">Customer Signup</h2>

            <!-- Signup Form -->
            <form method="POST" action="{{ route('customer.register.submit') }}" class="login-form">
                @csrf

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div style="color:red; margin-bottom:10px;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Full Name -->
                <!-- First Name & Last Name -->
<div class="form-row">

    <!-- First Name -->
                    <div class="form-group half">
                        <label class="form-label">First Name</label>
                        <input
                            type="text"
                            name="first_name"
                            class="form-input"
                            placeholder="Enter first name"
                            value="{{ old('first_name') }}"
                            required
                        >
                    </div>

                    <!-- Last Name -->
                    <div class="form-group half">
                        <label class="form-label">Last Name</label>
                        <input
                            type="text"
                            name="last_name"
                            class="form-input"
                            placeholder="Enter last name"
                            value="{{ old('last_name') }}"
                            required
                        >
                    </div>

                </div>

                <!-- Email -->
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input
                        type="email"
                        name="email"
                        class="form-input"
                        placeholder="Enter your email"
                        value="{{ old('email') }}"
                        required
                    >
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label class="form-label">Password</label>
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
                    <label class="form-label">Confirm Password</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-input"
                        placeholder="Confirm password"
                        required
                    >
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-login">
                    Sign Up
                </button>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/customer.js') }}"></script>
</body>
</html>
