<!DOCTYPE html>
<html>
<head>
    <title>Print Sales Report</title>

    <style>

        body{
            font-family: Arial, sans-serif;
            padding:20px;
            color:#333;
        }

        h1{
            margin-bottom:5px;
        }

        .date{
            margin-bottom:20px;
            color:#666;
        }

        .cards{
            display:flex;
            gap:15px;
            margin-bottom:30px;
        }

        .card{
            flex:1;
            border:1px solid #ccc;
            border-radius:10px;
            padding:15px;
        }

        .card h3{
            margin:0 0 10px;
            font-size:16px;
        }

        .card p{
            font-size:22px;
            font-weight:bold;
            margin:0;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
        }

        th, td{
            border:1px solid #ccc;
            padding:10px;
            text-align:left;
        }

        th{
            background:#f8c8dc;
        }

    </style>
</head>

<body onload="window.print()">

<h1>📄 Sales Report</h1>

<p class="date">
    Generated on:
    {{ now()->format('F d, Y h:i A') }}
</p>

{{-- SALES SUMMARY --}}
<div class="cards">

    <div class="card">
        <h3>💰 Daily Sales</h3>
        <p>₱{{ number_format($todayRevenue ?? 0, 2) }}</p>
    </div>

    <div class="card">
        <h3>📅 Weekly Sales</h3>
        <p>₱{{ number_format($weeklyRevenue ?? 0, 2) }}</p>
    </div>

    <div class="card">
        <h3>📆 Monthly Sales</h3>
        <p>₱{{ number_format($monthlyRevenue ?? 0, 2) }}</p>
    </div>

</div>

{{-- ORDERS TABLE --}}
<h2>📦 Orders List</h2>

<table>

    <thead>

        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Method</th>
            <th>Total</th>
            <th>Status</th>
            <th>Date</th>
        </tr>

    </thead>

    <tbody>

    @forelse($orders as $order)

        <tr>

            <td>{{ $order->id }}</td>

            <td>{{ $order->customer_name }}</td>

            <td>
                {{ ucfirst($order->delivery_method) }}
            </td>

            <td>
                ₱{{ number_format($order->total_price, 2) }}
            </td>

            <td>
                {{ ucfirst($order->status) }}
            </td>

            <td>
                {{ $order->created_at->format('M d, Y') }}
            </td>

        </tr>

    @empty

        <tr>
            <td colspan="6">
                No orders found.
            </td>
        </tr>

    @endforelse

    </tbody>

</table>

</body>
</html>