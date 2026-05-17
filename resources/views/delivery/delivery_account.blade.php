# resources/views/delivery/delivery_account.blade.php

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Dashboard</title>

    <link rel="stylesheet" href="{{ asset('css/adminaccount.css') }}">

    <style>

        .delivery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .delivery-card {
            background: #fff;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border: 2px solid #fce7f3;
            transition: 0.3s;
        }

        .delivery-card:hover {
            transform: translateY(-4px);
            border-color: #ec4899;
        }

        .delivery-card h3 {
            margin-bottom: 15px;
            color: #db2777;
        }

        .delivery-card p {
            margin: 8px 0;
            color: #444;
            font-size: 15px;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 14px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            margin-top: 10px;
        }

        .ready {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .delivery {
            background: #fef3c7;
            color: #b45309;
        }

        .completed {
            background: #dcfce7;
            color: #15803d;
        }

        .top-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .summary-card {
            background: white;
            padding: 25px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border: 2px solid #fce7f3;
        }

        .summary-card h2 {
            color: #ec4899;
            margin-bottom: 10px;
        }

        .summary-card p {
            font-size: 28px;
            font-weight: bold;
            color: #111;
        }

    </style>

</head>
<body>

<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <h2>🚚 Delivery</h2>

        <a href="#pending" class="active">
            📦 Delivery Orders
        </a>

        <a href="#completed">
            ✅ Completed Deliveries
        </a>

        <form method="POST"
            action="{{ route('delivery.logout') }}"
            style="margin-top:20px;">

            @csrf

            <button type="submit"
                    class="btn-outline"
                    style="margin-top:20px; width:100%;">

                Logout

            </button>

        </form>

    </aside>


    <!-- MAIN -->
    <div class="main">

        <header class="admin-header">

            <div>
                <h1>Delivery Dashboard</h1>
                <p>Manage and deliver customer cake orders</p>
            </div>

        </header>


        <div class="container">

            @php

                $deliveryOrders = \App\Models\Order::whereIn('status', ['ready', 'delivery'])
                    ->where('delivery_method', 'Delivery')
                    ->latest()
                    ->get();

                $completedOrders = \App\Models\Order::where('status', 'completed')
                    ->where('delivery_method', 'Delivery')
                    ->latest()
                    ->get();

                $todayDeliveries = \App\Models\Order::where('delivery_method', 'Delivery')
                    ->whereDate('delivery_date', today())
                    ->count();

                $inTransit = \App\Models\Order::where('status', 'delivery')
                    ->where('delivery_method', 'Delivery')
                    ->count();

                $doneToday = \App\Models\Order::where('status', 'completed')
                    ->where('delivery_method', 'Delivery')
                    ->whereDate('updated_at', today())
                    ->count();

            @endphp

            <!-- SUMMARY -->
            <div class="top-summary">

                <div class="summary-card">
                    <h2>📦 Today's Deliveries</h2>
                    <p>{{ $todayDeliveries }}</p>
                </div>

                <div class="summary-card">
                    <h2>🚚 In Transit</h2>
                    <p>{{ $inTransit }}</p>
                </div>

                <div class="summary-card">
                    <h2>✅ Delivered Today</h2>
                    <p>{{ $doneToday }}</p>
                </div>

            </div>


            <!-- ACTIVE DELIVERY -->
            <h2 id="pending" style="margin-top:40px;">
                🚚 Orders to Deliver
            </h2>

            <div class="delivery-grid">

                @forelse($deliveryOrders as $order)

                <div class="delivery-card">

                    <h3>🎂 Order #{{ $order->id }}</h3>

                    <p><strong>Customer:</strong> {{ $order->customer_name }}</p>

                    <p><strong>Contact:</strong> {{ $order->contact_number }}</p>

                    <p><strong>Address:</strong> {{ $order->address }}</p>

                    <p><strong>Cake:</strong>
                        {{ $order->flavor->name ?? 'Custom Cake' }}
                    </p>

                    <p><strong>Size:</strong>
                        {{ $order->size->name ?? 'N/A' }}
                    </p>

                    <p><strong>Delivery Date:</strong>
                        {{ $order->delivery_date }}
                    </p>

                    <p><strong>Delivery Time:</strong>
                        {{ $order->delivery_time ?? 'N/A' }}
                    </p>

                    <p><strong>Total:</strong>
                        ₱{{ number_format($order->total_price,2) }}
                    </p>

                    @if($order->status === 'ready')

                        <span class="status-badge ready">
                            📦 Ready for Delivery
                        </span>

                        <form method="POST"
                              action="{{ route('delivery.start', $order->id) }}"
                              style="margin-top:15px;">

                            @csrf

                            <button class="btn-primary">
                                🚚 Start Delivery
                            </button>

                        </form>

                    @endif


                    @if($order->status === 'delivery')

                        <span class="status-badge delivery">
                            🚚 Delivering
                        </span>

                        <form method="POST"
                              action="{{ route('delivery.complete', $order->id) }}"
                              style="margin-top:15px;">

                            @csrf

                            <button class="btn-outline">
                                ✅ Mark Delivered
                            </button>

                        </form>

                    @endif

                </div>

                @empty

                <div class="delivery-card">
                    <p>No delivery orders available.</p>
                </div>

                @endforelse

            </div>


            <!-- COMPLETED -->
            <h2 id="completed" style="margin-top:50px;">
                ✅ Completed Deliveries
            </h2>

            <div class="delivery-grid">

                @forelse($completedOrders as $order)

                <div class="delivery-card">

                    <h3>🎂 Order #{{ $order->id }}</h3>

                    <p><strong>Customer:</strong> {{ $order->customer_name }}</p>

                    <p><strong>Address:</strong> {{ $order->address }}</p>

                    <p><strong>Cake:</strong>
                        {{ $order->flavor->name ?? 'Custom Cake' }}
                    </p>

                    <p><strong>Delivered On:</strong>
                        {{ $order->updated_at->format('F d, Y h:i A') }}
                    </p>

                    <span class="status-badge completed">
                        ✅ Delivered
                    </span>

                </div>

                @empty

                <div class="delivery-card">
                    <p>No completed deliveries yet.</p>
                </div>

                @endforelse

            </div>

        </div>
    </div>
</div>

</body>
</html>