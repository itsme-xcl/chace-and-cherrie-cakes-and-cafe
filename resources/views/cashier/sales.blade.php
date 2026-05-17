<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cashier Sales</title>
<link rel="stylesheet" href="{{ asset('css/adminaccount.css') }}">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <h2>💰 Cashier</h2>

        <a href="{{ route('cashier.dashboard') }}">📦 Orders</a>
        <a href="{{ route('cashier.sales') }}" class="active">📊 Sales</a>

        <form method="POST" action="{{ route('cashier.logout') }}">
            @csrf
            <button class="btn-outline" style="margin-top:20px; width:100%;">
                Logout
            </button>
        </form>
    </aside>

    <!-- MAIN -->
    <div class="main">

        <header class="admin-header">
            <h1>Sales Report</h1>
            <p>Chace and Cherrie Cakes</p>
        </header>

        <div class="container">

            <h2>📊 Sales Analytics</h2>

            <!-- FILTER -->
            <div class="card">
                <form method="GET" class="form-row">
                    <select name="type">
                        <option value="day" {{ $type=='day'?'selected':'' }}>Daily</option>
                        <option value="week" {{ $type=='week'?'selected':'' }}>Weekly</option>
                        <option value="month" {{ $type=='month'?'selected':'' }}>Monthly</option>
                        <option value="year" {{ $type=='year'?'selected':'' }}>Yearly</option>
                    </select>

                    <input type="date"
                           name="date"
                           value="{{ \Carbon\Carbon::parse($date)->format('Y-m-d') }}">

                    <button class="btn-primary">Filter</button>
                </form>
            </div>

            <!-- MAIN SUMMARY -->
            <div class="dashboard-cards" style="margin-top:20px;">

                <div class="dash-card">
                    <h4>Total Orders</h4>
                    <p>{{ $totalOrders }}</p>
                </div>

                <div class="dash-card">
                    <h4>Paid Orders</h4>
                    <p>{{ $totalPaid }}</p>
                </div>

                <div class="dash-card">
                    <h4>Total Sales</h4>
                    <p>₱{{ number_format($totalSales, 2) }}</p>
                </div>

                <div class="dash-card">
                    <h4>Rejected</h4>
                    <p>{{ $rejected }}</p>
                </div>

            </div>

            <!-- 🔥 REVENUE BREAKDOWN -->
            <div class="dashboard-cards" style="margin-top:20px;">

                <div class="dash-card">
                    <h4>Daily Revenue</h4>
                    <p>₱{{ number_format($dailyRevenue, 2) }}</p>
                </div>

                <div class="dash-card">
                    <h4>Weekly Revenue</h4>
                    <p>₱{{ number_format($weeklyRevenue, 2) }}</p>
                </div>

                <div class="dash-card">
                    <h4>Monthly Revenue</h4>
                    <p>₱{{ number_format($monthlyRevenue, 2) }}</p>
                </div>

                <div class="dash-card">
                    <h4>Yearly Revenue</h4>
                    <p>₱{{ number_format($yearlyRevenue, 2) }}</p>
                </div>

            </div>

            <!-- SALES CHART -->
            <div class="card" style="margin-top:20px;">
                <h3>📈 Sales Trend ({{ ucfirst($type) }})</h3>

                <canvas id="salesChart" height="100"></canvas>
            </div>

            <!-- RECENT ORDERS -->
            <div class="card" style="margin-top:20px;">

                <div style="
                    display:flex;
                    justify-content:space-between;
                    align-items:center;
                    margin-bottom:15px;
                ">
                    <h3>🧾 Order Transactions</h3>

                    <input type="text"
                           id="searchInput"
                           placeholder="Search customer..."
                           style="
                            padding:10px;
                            border-radius:10px;
                            border:1px solid #ddd;
                            width:250px;
                           ">
                </div>

                <table id="salesTable">

                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Down Payment</th>
                            <th>Balance</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($orders as $order)

                        <tr>

                            <td>{{ $order->customer_name }}</td>

                            <td>
                                ₱{{ number_format($order->total_price, 2) }}
                            </td>

                            <td>
                                ₱{{ number_format($order->down_payment ?? 0, 2) }}
                            </td>

                            <td>
                                ₱{{ number_format(($order->total_price - ($order->down_payment ?? 0)), 2) }}
                            </td>

                            <td>
                                <span class="badge
                                    {{ $order->status === 'pending' ? 'badge-pending' : '' }}
                                    {{ in_array($order->status, ['paid','baking','ready','completed']) ? 'badge-approved' : '' }}
                                    {{ $order->status === 'rejected' ? 'badge-rejected' : '' }}">
                                    
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}
                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<!-- CHART -->
<script>

const ctx = document.getElementById('salesChart').getContext('2d');

const gradient = ctx.createLinearGradient(0, 0, 0, 300);

gradient.addColorStop(0, 'rgba(236,72,153,0.6)');
gradient.addColorStop(1, 'rgba(236,72,153,0.05)');

new Chart(ctx, {

    type: 'line',

    data: {

        labels: @json($labels),

        datasets: [{
            label: 'Sales (₱)',
            data: @json($chartData),

            borderColor: '#ec4899',
            backgroundColor: gradient,

            borderWidth: 3,
            tension: 0.4,
            fill: true,
            pointRadius: 5,
            pointHoverRadius: 7
        }]
    },

    options: {

        responsive: true,

        plugins: {

            legend: {
                display: true
            },

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


// SEARCH TABLE
document.getElementById('searchInput').addEventListener('keyup', function() {

    let value = this.value.toLowerCase();

    let rows = document.querySelectorAll('#salesTable tbody tr');

    rows.forEach(row => {

        row.style.display =
            row.innerText.toLowerCase().includes(value)
            ? ''
            : 'none';
    });
});

</script>

</body>
</html>