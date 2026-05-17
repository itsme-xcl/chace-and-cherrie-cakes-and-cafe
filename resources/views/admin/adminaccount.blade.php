<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>

<link rel="stylesheet" href="{{ asset('css/adminaccount.css') }}">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

.calendar-grid{
    display:grid;
    grid-template-columns:repeat(7,1fr);
    gap:15px;
    margin-top:20px;
}

.calendar-day{
    background:#fff;
    border-radius:16px;
    padding:15px;
    min-height:120px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
    border:2px solid #fce7f3;
    transition:0.3s;
    cursor:pointer;
}

.calendar-day:hover{
    transform:translateY(-3px);
    border-color:#ec4899;
}

.calendar-day h4{
    margin:0 0 10px;
    color:#db2777;
    font-size:18px;
}

.calendar-day p{
    margin:5px 0;
    font-size:14px;
    color:#444;
}

.delivery-badge{
    display:inline-block;
    padding:6px 14px;
    border-radius:30px;
    font-size:13px;
    font-weight:600;
}

.delivery{
    background:#dbeafe;
    color:#1d4ed8;
}

.pickup{
    background:#dcfce7;
    color:#15803d;
}

</style>

</head>

<body>

@php
    $page = $page ?? 'dashboard';
@endphp

<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">

    <h2>🍰 Admin</h2>

    <a href="{{ route('admin.account') }}"
       class="{{ $page === 'dashboard' ? 'active' : '' }}">
        📊 Dashboard
    </a>

    <a href="{{ route('admin.account', ['page'=>'maintenance']) }}"
       class="{{ $page === 'maintenance' ? 'active' : '' }}">
        🛠 Maintenance
    </a>

    <a href="{{ route('admin.orders') }}"
       class="{{ $page === 'orders' ? 'active' : '' }}">
        📦 Orders
    </a>

    <a href="{{ route('admin.account', ['page'=>'delivery']) }}"
       class="{{ $page === 'delivery' ? 'active' : '' }}">
        🚚 Delivery
    </a>

    <a href="{{ route('admin.account', ['page'=>'reports']) }}"
       class="{{ $page === 'reports' ? 'active' : '' }}">
        📄 Reports
    </a>

    <a href="{{ route('admin.inventory') }}"
       class="{{ request()->routeIs('admin.inventory') ? 'active' : '' }}">
        📦 Inventory
    </a>

</aside>

    <!-- MAIN -->
    <div class="main">

        <!-- HEADER -->
        <header class="admin-header">

            <div>
                <h1>Admin Dashboard</h1>
                <p>Chace and Cherrie Cakes</p>
            </div>

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="btn-outline">Logout</button>
            </form>

        </header>

        <div class="container">

        {{-- ================= DASHBOARD ================= --}}
        @if($page === 'dashboard')

        <h2>Dashboard Overview</h2>

        <div class="dashboard-cards">

            <div class="dash-card">
                <h4>Total Revenue</h4>
                <p>₱{{ number_format($totalRevenue ?? 0, 2) }}</p>
            </div>

            <div class="dash-card">
                <h4>Daily Sales</h4>
                <p>₱{{ number_format($dailySales ?? 0, 2) }}</p>
            </div>

            <div class="dash-card">
                <h4>Monthly Sales</h4>
                <p>₱{{ number_format($monthlySales ?? 0, 2) }}</p>
            </div>

            <div class="dash-card">
                <h4>Yearly Sales</h4>
                <p>₱{{ number_format($yearlySales ?? 0, 2) }}</p>
            </div>

        </div>

        <div class="card" style="margin-top:20px;">

            <h3>📈 Revenue Trend (Last 7 Days)</h3>

            <canvas id="salesChart" height="100"></canvas>

        </div>

        @endif


        {{-- ================= MAINTENANCE ================= --}}
        @if($page === 'maintenance')

            @include('admin.maintenance')

        @endif


        {{-- ================= ORDERS ================= --}}
        @if($page === 'orders')

            <h2>📦 Orders</h2>

            <div class="card">

                <form method="GET"
                    action="{{ route('admin.orders') }}"
                    class="form-row">

                    {{-- SEARCH CUSTOMER --}}
                    <input type="text"
                        name="search"
                        placeholder="Search customer name..."
                        value="{{ request('search') }}">

                    {{-- DATE FILTER --}}
                    <input type="date"
                        name="date"
                        value="{{ request('date') }}">

                    {{-- STATUS FILTER --}}
                    <select name="status">

                        <option value="">All Status</option>

                        <option value="pending"
                            {{ request('status')=='pending'?'selected':'' }}>
                            Pending
                        </option>

                        <option value="paid"
                            {{ request('status')=='paid'?'selected':'' }}>
                            Paid
                        </option>

                        <option value="baking"
                            {{ request('status')=='baking'?'selected':'' }}>
                            Baking
                        </option>

                        <option value="ready"
                            {{ request('status')=='ready'?'selected':'' }}>
                            Ready
                        </option>

                        <option value="delivery"
                            {{ request('status')=='delivery'?'selected':'' }}>
                            Delivery
                        </option>

                        <option value="completed"
                            {{ request('status')=='completed'?'selected':'' }}>
                            Completed
                        </option>

                        <option value="rejected"
                            {{ request('status')=='rejected'?'selected':'' }}>
                            Rejected
                        </option>

                    </select>

                    <button class="btn-primary">
                        Filter
                    </button>

                </form>

            </div>

            {{-- CUSTOMER ANALYTICS --}}
            <div class="card" style="margin-bottom:20px;">

                <h3>👥 Customer Analytics</h3>

                @if($customerAnalytics->count() == 0)

                    <p>No customer data found.</p>

                @else

                <table>

                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Total Orders</th>
                            <th>Favorite Flavor</th>
                            <th>Total Spent</th>
                        </tr>
                    </thead>

                    <tbody>

                    @foreach($customerAnalytics as $customer)

                        <tr>

                            <td>
                                {{ $customer['customer_name'] }}
                            </td>

                            <td>
                                {{ $customer['total_orders'] }}
                            </td>

                            <td>
                                {{ $customer['favorite_flavor'] }}
                            </td>

                            <td>
                                ₱{{ number_format($customer['total_spent'], 2) }}
                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

                @endif

            </div>

            {{-- ORDERS TABLE --}}
            @if($orders->count() == 0)

                <p>No orders found.</p>

            @else

            <div class="card">

            <table>

                <thead>

                    <tr>
                        <th>Customer</th>
                        <th>Address</th>
                        <th>Method</th>
                        <th>Delivery/Pickup Date</th>
                        <th>Order Date</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>

                </thead>

                <tbody>

                @foreach($orders as $order)

                <tr>

                    <td>{{ $order->customer_name }}</td>

                    <td>
                        {{ $order->address ?? 'N/A' }}
                    </td>

                    <td>
                        <strong>
                            {{ ucfirst($order->delivery_method) }}
                        </strong>
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($order->delivery_date)->format('M d, Y') }}
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}
                    </td>

                    <td>
                        ₱{{ number_format($order->total_price,2) }}
                    </td>

                    <td>

                        <span class="badge
                            {{ $order->status === 'pending' ? 'badge-pending' : '' }}
                            {{ in_array($order->status, ['paid','baking','ready','delivery','completed']) ? 'badge-approved' : '' }}
                            {{ $order->status === 'rejected' ? 'badge-rejected' : '' }}">

                            {{ ucfirst($order->status) }}

                        </span>

                    </td>

                </tr>

                @endforeach

                </tbody>

            </table>

            </div>

            @endif

            @endif


        {{-- ================= DELIVERY ================= --}}
        {{-- ================= DELIVERY ================= --}}
        @if($page === 'delivery')

        <h2>📅 Delivery Schedule</h2>

        <div class="card">

        @php
            // FILTER BY DAY (if clicked)
            $query = \App\Models\Order::with('flavor')
                ->whereMonth('delivery_date', now()->month);

            if(request('day')) {
                $query->whereDay('delivery_date', request('day'));
            }

            $filteredOrders = $query->get();

            // FOR CALENDAR COUNTS
           $ordersByDate = \App\Models\Order::whereMonth('delivery_date', now()->month)
            ->where('status', '!=', 'rejected')
            ->get()
            ->groupBy(function($order) {
                return \Carbon\Carbon::parse($order->delivery_date)->day;
            });
        @endphp


        {{-- CALENDAR --}}
        <div class="calendar-grid">

            @for($i = 1; $i <= now()->daysInMonth; $i++)

                @php

                    $dayOrders = isset($ordersByDate[$i])
                        ? $ordersByDate[$i]
                        : collect();

                    $deliveries = $dayOrders
                        ->where('delivery_method', 'Delivery')
                        ->count();

                    $pickups = $dayOrders
                        ->where('delivery_method', 'Pickup')
                        ->count();

                    $completedOrders = $dayOrders
                        ->whereIn('status', ['completed'])
                        ->count();

                    $allCompleted = $dayOrders->count() > 0
                        && $completedOrders === $dayOrders->count();

                @endphp

                <div class="calendar-day
                    {{ $allCompleted ? 'calendar-completed' : '' }}"
                    onclick="window.location.href='?page=delivery&day={{ $i }}'"
                    style="{{ request('day') == $i ? 'border:2px solid #ec4899;' : '' }}">

                    <h4>{{ $i }}</h4>

                    @if($deliveries > 0)
                        <p>🚚 {{ $deliveries }} Delivery</p>
                    @endif

                    @if($pickups > 0)
                        <p>🛍 {{ $pickups }} Pickup</p>
                    @endif

                </div>

            @endfor

        </div>


        {{-- ================= TABLE (UNDER CALENDAR) ================= --}}
        <div class="card" style="margin-top:20px;">

            <h3>
                @if(request('day'))
                    📦 Orders for Day {{ request('day') }}
                @else
                    📦 All Delivery Orders
                @endif
            </h3>

            @if($filteredOrders->count() == 0)

                <p>No orders found.</p>

            @else

            <table>

                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Cake Flavor</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($filteredOrders as $order)

                <tr>

                    <td>{{ $order->customer_name }}</td>

                    <td>{{ $order->flavor->name ?? 'N/A' }}</td>

                    <td>{{ $order->address ?? 'N/A' }}</td>

                    <td>
                        <span class="badge">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>

                    <td>

                        @if($order->delivery_method == 'Delivery')

                            @if($order->status == 'ready')

                                <form method="POST"
                                    action="{{ route('admin.orders.delivery', $order->id) }}">
                                    @csrf
                                    <button class="btn-primary">
                                        🚚 Send for Delivery
                                    </button>
                                </form>

                            @elseif($order->status == 'delivery')

                                <span style="color:#1d4ed8;">In Delivery</span>

                            @elseif($order->status == 'completed')

                                <span style="color:green;">Delivered</span>

                            @else

                                <span style="color:gray;">{{ ucfirst($order->status) }}</span>

                            @endif


                        @else
                            {{-- PICKUP ORDERS --}}
                            <span style="color:#15803d; font-weight:600;">
                                🛍 For Pickup
                            </span>
                        @endif

                    </td>

                </tr>

                @endforeach

                </tbody>

            </table>

            @endif

        </div>

        </div>

        @endif


        {{-- ================= REPORTS ================= --}}
        {{-- ================= REPORTS ================= --}}
        @if($page === 'reports')

        <h2>📄 Sales Reports Dashboard</h2>

        {{-- SALES SUMMARY CARDS --}}
        <div class="cards">

            <div class="card">
                <h4>💰 Today Sales</h4>
                <p>₱{{ number_format($todayRevenue ?? 0, 2) }}</p>
            </div>

            <div class="card">
                <h4>📅 Weekly Sales</h4>
                <p>₱{{ number_format($weeklyRevenue ?? 0, 2) }}</p>
            </div>

            <div class="card">
                <h4>📆 Monthly Sales</h4>
                <p>₱{{ number_format($monthlyRevenue ?? 0, 2) }}</p>
            </div>

        </div>

        {{-- SALES CHART --}}
        <div class="card" style="margin-top:20px;">

            <h3>📈 Monthly Sales Overview</h3>

            <canvas id="salesChart" height="100"></canvas>

        </div>

        {{-- EXPORT BUTTONS --}}
         <div style="margin:20px 0; display:flex; gap:10px; flex-wrap:wrap;">

            <form id="pdfForm" action="{{ route('admin.reports.pdf') }}" method="POST" style="display:inline;">

    @csrf
                <input
                    type="hidden"
                    name="chart_image"
                    id="chart_image"
                >

                <button
                    type="button"
                    onclick="exportPDF()"
                    style="
                        background:#ec4899;
                        color:white;
                        border:none;
                        padding:12px 22px;
                        border-radius:10px;
                        font-weight:600;
                        font-size:14px;
                        cursor:pointer;
                        box-shadow:0 4px 10px rgba(236,72,153,0.25);
                        transition:0.3s;
                    "
                    onmouseover="this.style.background='#db2777'"
                    onmouseout="this.style.background='#ec4899'"
                >
                    📄 Export PDF
                </button>

            </form>

            <a href="{{ url('/admin/reports/print') }}" class="btn-primary">
                🖨 Print Report
            </a>

        </div>

        {{-- ORDERS TABLE --}}
        {{-- COMPLETED / READY --}}
        <div class="report-section">

            <h2 style="margin-bottom:20px;">
                ✅ Completed / Ready Orders
            </h2>

            <table class="report-table">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Address</th>
                        <th>Method</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>

                        @forelse($orders->whereIn('status', ['Completed', 'ready']) as $order)

                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->address }}</td>
                        <td>{{ ucfirst($order->delivery_method) }}</td>
                        <td>₱{{ number_format($order->total_price, 2) }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7">
                            No completed/ready orders
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>



        {{-- PENDING --}}
        <div class="report-section" style="margin-top:50px;">

            <h2 style="margin-bottom:20px;">
                ⏳ Pending Orders
            </h2>

            <table class="report-table">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Address</th>
                        <th>Method</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($orders->where('status', 'pending') as $order)

                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->address }}</td>
                        <td>{{ ucfirst($order->delivery_method) }}</td>
                        <td>₱{{ number_format($order->total_price, 2) }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7">
                            No pending orders
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>



        {{-- BAKING --}}
        <div class="report-section" style="margin-top:50px;">

            <h2 style="margin-bottom:20px;">
                🎂 Baking Orders
            </h2>

            <table class="report-table">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Address</th>
                        <th>Method</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>

               @forelse($orders->where('status', 'baking') as $order)

                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->address }}</td>
                        <td>{{ ucfirst($order->delivery_method) }}</td>
                        <td>₱{{ number_format($order->total_price, 2) }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7">
                            No baking orders
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>



        {{-- REJECTED --}}
        <div class="report-section" style="margin-top:50px;">

            <h2 style="margin-bottom:20px;">
                ❌ Rejected Orders
            </h2>

            <table class="report-table">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Address</th>
                        <th>Method</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($orders->where('status', 'rejected') as $order)

                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->address }}</td>
                        <td>{{ ucfirst($order->delivery_method) }}</td>
                        <td>₱{{ number_format($order->total_price, 2) }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7">
                            No rejected orders
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        @endif

        </div>

    </div>

</div>

<script>

const ctx = document.getElementById('salesChart');

if (ctx) {

    const chartContext = ctx.getContext('2d');

    const gradient = chartContext.createLinearGradient(0, 0, 0, 300);

    gradient.addColorStop(0, 'rgba(236, 72, 153, 0.6)');
    gradient.addColorStop(1, 'rgba(236, 72, 153, 0.05)');

    new Chart(chartContext, {

       type: 'bar',

        data: {

            labels: @json($chartLabels ?? []),

            datasets: [{

                label: 'Revenue (₱)',

                data: @json($chartData ?? []),

                borderColor: '#db2777',

                backgroundColor: 'rgba(236, 72, 153, 0.7)',

                borderWidth: 3,

                pointRadius: 4
            }]
        },

        options: {

            responsive: true,

            plugins: {

                tooltip: {

                    callbacks: {

                        label: function(context) {

                            return '₱' + context.raw.toLocaleString();
                        }
                    }
                }
            },

            scales: {

                y: {

                    beginAtZero: true,

                    ticks: {

                        callback: value => '₱' + value
                    }
                }
            }
        }
    });
}

function exportPDF(){

    const canvas = document.getElementById('salesChart');

    if(!canvas){

        alert('Chart not found');

        return;
    }

    const image = canvas.toDataURL('image/jpeg', 0.5);

    document.getElementById('chart_image').value = image;

    document.getElementById('pdfForm').submit();
}

</script>


</body>
</html>