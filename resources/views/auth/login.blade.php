<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Chace and Cherrie Cakes</title>

    <!-- LINK YOUR CSS -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

<div class="container">

    <!-- Logo -->
    <div class="logo">🍰</div>

    <!-- Title -->
    <h1>Chace and Cherrie Cakes</h1>
    <p class="subtitle">Order Management System</p>

    <h2 class="section-title">Select Your Role</h2>

    <!-- Roles -->
    <div class="roles-grid">

        <!-- Customer -->
        <a href="{{ route('customer.login') }}" class="role-card">
            <div class="role-icon customer-icon">👤</div>
            <div class="role-info">
                <div class="role-title">Customer</div>
                <div class="role-description">
                    Browse products, place orders, and track your purchases
                </div>
            </div>
        </a>

        <!-- Admin -->
        <a href="{{ route('admin.login') }}" class="role-card">
            <div class="role-icon admin-icon">⚙️</div>
            <div class="role-info">
                <div class="role-title">Admin</div>
                <div class="role-description">
                    Manage system maintenance and configurations
                </div>
            </div>
        </a>

        <!-- ✅ CASHIER (NEW) -->
        <a href="{{ route('cashier.login') }}" class="role-card">
            <div class="role-icon cashier-icon">💰</div>
            <div class="role-info">
                <div class="role-title">Cashier</div>
                <div class="role-description">
                    Verify payments and approve or reject orders
                </div>
            </div>
        </a>

        <!-- Baker -->
        <a href="{{ route('baker.login') }}" class="role-card">
            <div class="role-icon baker-icon">👨‍🍳</div>
            <div class="role-info">
                <div class="role-title">Baker</div>
                <div class="role-description">
                    View and prepare assigned orders
                </div>
            </div>
        </a>

        <!-- Delivery -->
        <a href="{{ route('delivery.login') }}" class="role-card">
            <div class="role-icon delivery-icon">🚚</div>

            <div class="role-info">

                <div class="role-title">
                    Delivery
                </div>

                <div class="role-description">
                    Deliver orders and update delivery status
                </div>

            </div>
        </a>

    </div>

</div>

</body>
</html>