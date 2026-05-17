```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>

    <link rel="stylesheet" href="{{ asset('css/myorders.css') }}">
</head>
<body>

<!-- =========================
     HEADER
========================= -->
<header class="topbar">

    <div class="brand">
        <div class="logo">🍰</div>

        <div>
            <h1>My Orders</h1>
            <p>Chace and Cherrie Cakes</p>
        </div>
    </div>

    <div class="top-actions">

        <a href="{{ route('customer.account') }}" class="btn-outline">
            ← Back
        </a>

        <a href="{{ route('customer.orders') }}" class="btn-outline">
            My Orders
        </a>

        <a href="{{ route('customer.account') }}" class="btn-primary">
            + New Order
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="btn-outline">
                Logout
            </button>
        </form>

    </div>

</header>

<!-- =========================
     PAGE CONTENT
========================= -->
<main class="container">

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($orders->count() === 0)

        <div class="empty-orders">

            <h3>No Orders Yet</h3>

            <p>
                Your cake orders will appear here once you place one.
            </p>

        </div>

    @else

        @foreach ($orders as $order)

        <!-- =========================
             ORDER CARD
        ========================= -->
        <div class="summary-card">

            <!-- ORDER HEADER -->
            <div class="order-top">

                <div class="order-title">

                    <div class="order-icon">
                        🎂
                    </div>

                    <div>

                        <h3>Order #{{ $order->id }}</h3>

                        <div class="order-sub">
                            Cake Order Summary
                        </div>

                    </div>

                </div>

                <!-- STATUS -->
                <span class="badge
                    {{ $order->status === 'pending' ? 'badge-pending' : '' }}
                    {{ $order->status === 'paid' ? 'badge-approved' : '' }}
                    {{ $order->status === 'rejected' ? 'badge-rejected' : '' }}
                ">

                    @if($order->status === 'pending')
                        Pending
                    @elseif($order->status === 'paid')
                        Approved
                    @elseif($order->status === 'rejected')
                        Rejected
                    @endif

                </span>

            </div>

            <!-- STATUS ALERT -->
            @if($order->status === 'pending')

                <div class="alert-warning">
                    Waiting for cashier approval.
                </div>

            @elseif($order->status === 'paid')

                <div class="alert-success">
                    Payment approved. Your order is confirmed.
                </div>

            @elseif($order->status === 'rejected')

                <div class="alert-danger">
                    Payment rejected. Please upload again.
                </div>

            @endif

            <!-- CONTENT -->
            <div class="summary-content">

                <!-- LEFT SIDE -->
                <div class="summary-details">

                    <!-- CUSTOMER INFO -->
                    <div class="info-section">

                        <h4>Customer Information</h4>

                        <div class="info-grid">

                            <div class="info-item">
                                <div class="info-label">Customer Name</div>
                                <div class="info-value">
                                    {{ $order->customer_name }}
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Recipient</div>
                                <div class="info-value">
                                    {{ $order->recipient_name }}
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Contact Number</div>
                                <div class="info-value">
                                    {{ $order->contact_number }}
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- CAKE DETAILS -->
                    <div class="info-section">

                        <h4>Cake Details</h4>

                        <div class="info-grid">

                            <div class="info-item">
                                <div class="info-label">Flavor</div>
                                <div class="info-value">
                                    {{ $order->flavor->name ?? 'N/A' }}
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Size</div>
                                <div class="info-value">
                                    {{ $order->size->name ?? 'N/A' }}
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Theme</div>
                                <div class="info-value">
                                    {{ $order->themeRel->name ?? 'N/A' }}
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Frosting</div>
                                <div class="info-value">
                                    {{ $order->frosting_name ?? 'N/A' }}
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Fondant</div>
                                <div class="info-value">
                                    {{ $order->fondant_name ?? 'N/A' }}
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Tiers</div>
                                <div class="info-value">
                                    {{ $order->tiers_label ?? 'N/A' }}
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Color Scheme</div>
                                <div class="info-value">
                                    {{ $order->color_scheme ?? 'N/A' }}
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Add-ons</div>
                                <div class="info-value">

                                    {{ !empty($order->addon_names)
                                        ? implode(', ', $order->addon_names)
                                        : 'None'
                                    }}

                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- DELIVERY -->
                    <div class="info-section">

                        <h4>Delivery Information</h4>

                        <div class="info-grid">

                            <div class="info-item">
                                <div class="info-label">Delivery Date</div>
                                <div class="info-value">
                                    {{ $order->delivery_date }}
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Delivery Time</div>
                                <div class="info-value">
                                    {{ $order->delivery_time ?? 'N/A' }}
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Delivery Method</div>
                                <div class="info-value">
                                    {{ $order->delivery_method }}
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- PAYMENT -->
                    <div class="info-section">

                        <h4>Payment Summary</h4>

                        <div class="info-grid">

                            <div class="info-item">
                                <div class="info-label">Total Price</div>
                                <div class="info-value">
                                    ₱{{ number_format($order->total_price, 2) }}
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Down Payment</div>
                                <div class="info-value">
                                    ₱{{ number_format($order->down_payment, 2) }}
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Remaining Balance</div>
                                <div class="info-value">
                                    ₱{{ number_format($order->total_price - $order->down_payment, 2) }}
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                <!-- RIGHT SIDE IMAGE -->
                @if ($order->cake_image)

                    <div class="summary-image">

                        <img
                            src="{{ asset($order->cake_image) }}"
                            alt="Cake Image"
                        >

                    </div>

                @endif

            </div>

        </div>

        @endforeach

    @endif

</main>

</body>
</html>
```
