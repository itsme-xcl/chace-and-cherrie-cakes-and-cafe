<!DOCTYPE html>
<html>
<head>
    <title>Sales Report PDF</title>

    <style>

        body{
            font-family: Arial, sans-serif;
            padding:20px;
            color:#333;
        }

        h1{
            text-align:center;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
        }

        th, td{
            border:1px solid #ccc;
            padding:10px;
            font-size:12px;
            text-align:center;
        }

        th{
            background:#f3f4f6;
        }

    </style>
</head>

<body>

    {{-- COMPLETED & READY --}}
<h2>Completed / Ready Orders</h2>

<table>

    <thead>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>

    @forelse($orders->whereIn('status', ['completed', 'ready']) as $order)

        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->customer_name }}</td>
            <td>₱{{ number_format($order->total_price, 2) }}</td>
            <td>{{ ucfirst($order->status) }}</td>
        </tr>

    @empty

        <tr>
            <td colspan="4">
                No completed/ready orders
            </td>
        </tr>

    @endforelse

    </tbody>

</table>


{{-- PENDING --}}
<h2 style="margin-top:40px;">
    Pending Orders
</h2>

<table>

    <thead>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>

    @forelse($orders->where('status', 'pending') as $order)

        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->customer_name }}</td>
            <td>₱{{ number_format($order->total_price, 2) }}</td>
            <td>{{ ucfirst($order->status) }}</td>
        </tr>

    @empty

        <tr>
            <td colspan="4">
                No pending orders
            </td>
        </tr>

    @endforelse

    </tbody>

</table>


{{-- BAKING --}}
<h2 style="margin-top:40px;">
    Baking Orders
</h2>

<table>

    <thead>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>

    @forelse($orders->where('status', 'baking') as $order)

        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->customer_name }}</td>
            <td>₱{{ number_format($order->total_price, 2) }}</td>
            <td>{{ ucfirst($order->status) }}</td>
        </tr>

    @empty

        <tr>
            <td colspan="4">
                No baking orders
            </td>
        </tr>

    @endforelse

    </tbody>

</table>


{{-- REJECTED --}}
    <h2 style="margin-top:40px;">
        Rejected Orders
    </h2>

    <table>

        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>

        @forelse($orders->where('status', 'rejected') as $order)

            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>₱{{ number_format($order->total_price, 2) }}</td>
                <td>{{ ucfirst($order->status) }}</td>
            </tr>

        @empty

            <tr>
                <td colspan="4">
                    No rejected orders
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</body>
</html>