<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cashier Dashboard</title>
<link rel="stylesheet" href="/css/adminaccount.css">
</head>

<body>

<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <h2>💰 Cashier</h2>

        <a href="{{ route('cashier.dashboard') }}" class="active">
            📦 Orders
        </a>

        <a href="{{ route('cashier.sales') }}">
            📊 Sales
        </a>

        <form method="POST" action="{{ route('cashier.logout') }}">
            @csrf

            <button class="btn-outline"
                    style="margin-top:20px; width:100%;">
                Logout
            </button>
        </form>

    </aside>

    <!-- MAIN -->
    <div class="main">

        <!-- HEADER -->
        <header class="admin-header">

            <div>
                <h1>Cashier Dashboard</h1>
                <p>Chace and Cherrie Cakes</p>
            </div>

        </header>

        <div class="container">

            <h2>📦 Orders for Verification</h2>

            <!-- DASHBOARD -->
            <div class="dashboard-cards" style="margin-bottom:20px;">

                <div class="dash-card">
                    <h4>Total Orders Today</h4>
                    <p>{{ $totalOrdersToday ?? 0 }}</p>
                </div>

                <div class="dash-card">
                    <h4>Paid Orders</h4>
                    <p>{{ $totalPaidToday ?? 0 }}</p>
                </div>

                <div class="dash-card">
                    <h4>Total Sales</h4>
                    <p>₱{{ number_format($totalSalesToday ?? 0, 2) }}</p>
                </div>

                <div class="dash-card">
                    <h4>Rejected Payments</h4>
                    <p>{{ $totalRejectedToday ?? 0 }}</p>
                </div>

            </div>

            <!-- SUCCESS -->
            @if(session('success'))

                <p style="
                    color:green;
                    margin-bottom:10px;
                    font-weight:bold;
                ">
                    {{ session('success') }}
                </p>

            @endif

            <!-- SEARCH -->
            <div class="card" style="margin-bottom:20px;">

                <input type="text"
                       id="searchInput"
                       placeholder="Search customer..."
                       style="
                        width:100%;
                        padding:12px;
                        border-radius:10px;
                        border:1px solid #ddd;
                       ">
            </div>

            @if($orders->count() == 0)

                <p>No orders available.</p>

            @else

            <div class="card">

            <table id="ordersTable">

                <thead>

                    <tr>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Down Payment</th>
                        <th>Balance</th>
                        <th>Status</th>
                        <th>Proof</th>
                        <th>Action</th>
                    </tr>

                </thead>

                <tbody>

                @foreach($orders as $order)

                <tr>

                    <td>{{ $order->customer_name }}</td>

                    <td>
                        {{ $order->created_at->format('M d, Y') }}
                    </td>

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

                        @if($order->payment_proof)

                            <a href="{{ asset('storage/' . $order->payment_proof) }}"
                               target="_blank">

                                View

                            </a>

                        @else

                            No proof

                        @endif

                    </td>

                    <td class="actions">

                        @if($order->status === 'pending')

                            <form method="POST"
                                  action="{{ route('cashier.orders.approve', $order->id) }}">

                                @csrf

                                <button title="Verify">
                                    ✔
                                </button>

                            </form>

                            <form method="POST"
                                  action="{{ route('cashier.orders.reject', $order->id) }}">

                                @csrf

                                <button title="Reject">
                                    ✖
                                </button>

                            </form>

                        @elseif($order->status === 'paid')

                            ✔ Paid

                        @elseif($order->status === 'rejected')

                            ✖ Rejected

                        @else

                            ✔ Done

                        @endif

                    </td>

                </tr>

                @endforeach

                </tbody>

            </table>

            </div>

            @endif

        </div>

    </div>

</div>

<script>

document.getElementById('searchInput').addEventListener('keyup', function() {

    let value = this.value.toLowerCase();

    let rows = document.querySelectorAll('#ordersTable tbody tr');

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