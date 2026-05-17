<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Baker Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/adminaccount.css') }}">
</head>
<body>

<div class="layout">

    <aside class="sidebar">
        <h2>👨‍🍳 Baker</h2>

        <a href="#orders-section" class="active">🍰 Orders</a>
        <a href="#completed-orders">📦 Completed Orders</a>

        <form method="POST" action="{{ route('baker.logout') }}">
            @csrf
            <button class="btn-outline" style="margin-top:20px; width:100%;">
                Logout
            </button>
        </form>
    </aside>

    <div class="main">

        <header class="admin-header">
            <h1>Baker Dashboard</h1>
            <p>Prepare and manage cake orders</p>
        </header>

        <div class="container">

            <!-- DASHBOARD STATUS CARDS -->
            <div class="dashboard-cards">

                <div class="dash-card">
                    <h4>📦 Pending Orders</h4>
                    <p>{{ $pendingOrders ?? 0 }}</p>
                </div>

                <div class="dash-card">
                    <h4>🎂 Preparing</h4>
                    <p>{{ $preparingOrders ?? 0 }}</p>
                </div>

                <div class="dash-card">
                    <h4>🚚 Ready for Pickup</h4>
                    <p>{{ $readyOrders ?? 0 }}</p>
                </div>

                <div class="dash-card">
                    <h4>🛵 Delivery Orders</h4>
                    <p>{{ $deliveryOrders ?? 0 }}</p>
                </div>

                <div class="dash-card">
                    <h4>✅ Completed Today</h4>
                    <p>{{ $completedToday ?? 0 }}</p>
                </div>

            </div>


            {{-- ACTIVE ORDERS --}}
            <h2 id="orders-section">🍰 Orders to Prepare</h2>

            @forelse($activeOrders as $order)
            <div class="card">

                <h3>🎂 Order #{{ $order->id }}</h3>

                {{-- CUSTOMER --}}
                <h4>Customer Details</h4>
                <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                <p><strong>Contact:</strong> {{ $order->contact_number }}</p>
                <p><strong>Recipient:</strong> {{ $order->recipient_name ?? 'N/A' }}</p>

                {{-- CAKE --}}
                <h4>🍰 Cake Details</h4>

                <p><strong>Flavor:</strong> {{ $order->flavor->name ?? 'N/A' }}</p>
                <p><strong>Size:</strong> {{ $order->size->name ?? 'N/A' }}</p>
                <p><strong>Theme:</strong> {{ $order->themeRel->name ?? 'N/A' }}</p>

                <p><strong>Add-ons:</strong>
                    @if(is_iterable($order->addons))
                        {{ collect($order->addons)->pluck('name')->join(', ') }}
                    @else
                        None
                    @endif
                </p>

                <p><strong>Frosting:</strong>
                    {{ is_object($order->frosting) ? $order->frosting->name : 'N/A' }}
                </p>

                <p><strong>Fondant:</strong>
                    {{ is_object($order->fondant) ? $order->fondant->name : 'N/A' }}
                </p>

                <p><strong>Tiers:</strong> {{ $order->tiers ?? 'N/A' }}</p>
                <p><strong>Color:</strong> {{ $order->color ?? 'N/A' }}</p>

                {{-- DELIVERY --}}
                <h4>🚚 Delivery Info</h4>
                <p><strong>Date:</strong> {{ $order->delivery_date }}</p>
                <p><strong>Time:</strong> {{ $order->delivery_time ?? 'N/A' }}</p>
                <p><strong>Type:</strong> {{ $order->delivery_type ?? 'Pickup' }}</p>

                {{-- STATUS --}}
                <p>
                    <strong>Status:</strong>
                    <span class="badge 
                        {{ $order->status === 'paid' ? 'badge-approved' : '' }}
                        {{ $order->status === 'baking' ? 'badge-pending' : '' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>

                {{-- ACTIONS --}}
                @if($order->status === 'paid')
                    <form method="POST" action="{{ route('baker.orders.start', $order->id) }}">
                        @csrf
                        <button class="btn-primary">Start Baking</button>
                    </form>
                @endif

                @if($order->status === 'baking')
                    <form method="POST" action="{{ route('baker.orders.ready', $order->id) }}">
                        @csrf
                        <button class="btn-outline">Mark as Ready</button>
                    </form>
                @endif

            </div>
            @empty
                <div class="card">
                    <p>No active orders</p>
                </div>
            @endforelse


            {{-- COMPLETED ORDERS --}}
            <h2 id="completed-orders" style="margin-top:40px;">📦 Completed Orders</h2>

            @forelse($completedOrders as $order)
            <div class="card">

                <h3>🎂 Order #{{ $order->id }}</h3>

                <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                <p><strong>Flavor:</strong> {{ $order->flavor->name ?? 'N/A' }}</p>
                <p><strong>Size:</strong> {{ $order->size->name ?? 'N/A' }}</p>
                <p><strong>Date:</strong> {{ $order->delivery_date }}</p>

                <span class="badge badge-approved">Completed</span>

            </div>
            @empty
                <div class="card">
                    <p>No completed orders</p>
                </div>
            @endforelse

        </div>
    </div>
</div>

</body>
</html>