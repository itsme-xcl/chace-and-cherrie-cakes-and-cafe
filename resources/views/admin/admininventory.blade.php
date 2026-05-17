<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Inventory</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, Helvetica, sans-serif;
        }

        body{
            background:#f8d7e5;
        }

        .container{
            display:flex;
            min-height:100vh;
        }

        /* =========================
           SIDEBAR
        ========================= */

        .sidebar{
            width:260px;
            background:linear-gradient(to bottom,#ff4fa3,#ff6bb5);
            padding:30px 20px;
            color:white;
        }

        .sidebar h2{
            margin-bottom:40px;
            font-size:32px;
        }

        .sidebar a{
            display:block;
            text-decoration:none;
            color:white;
            padding:15px 18px;
            margin-bottom:15px;
            border-radius:14px;
            transition:0.3s;
            font-size:17px;
            font-weight:bold;
        }

        .sidebar a:hover,
        .sidebar a.active{
            background:white;
            color:#ff4fa3;
        }

        /* =========================
           MAIN CONTENT
        ========================= */

        .main{
            flex:1;
            padding:30px;
        }

        .header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:30px;
        }

        .header h1{
            font-size:42px;
            color:#222;
        }

        .header p{
            color:#666;
            margin-top:5px;
        }

        .logout-btn{
            background:white;
            border:none;
            padding:12px 24px;
            border-radius:30px;
            cursor:pointer;
            font-weight:bold;
            transition:0.3s;
        }

        .logout-btn:hover{
            background:#ff4fa3;
            color:white;
        }

        /* =========================
           INVENTORY CARD
        ========================= */

        .inventory-card{
            background:#fff0f6;
            border-radius:20px;
            padding:25px;
            box-shadow:0 5px 20px rgba(0,0,0,0.08);
        }

        .inventory-title{
            font-size:34px;
            margin-bottom:25px;
            color:#111;
        }

        /* =========================
           TABLE
        ========================= */

        table{
            width:100%;
            border-collapse:collapse;
        }

        th{
            background:#ff4fa3;
            color:white;
            padding:16px;
            text-align:left;
            font-size:16px;
        }

        td{
            padding:18px 16px;
            border-bottom:1px solid #eee;
            vertical-align:middle;
        }

        tr:hover{
            background:#fff8fb;
        }

        .product-img{
            width:75px;
            height:75px;
            object-fit:cover;
            border-radius:12px;
        }

        /* =========================
           STATUS
        ========================= */

        .status{
            padding:8px 14px;
            border-radius:30px;
            font-size:13px;
            font-weight:bold;
        }

        .in-stock{
            background:#d4edda;
            color:#155724;
        }

        .low-stock{
            background:#fff3cd;
            color:#856404;
        }

        .out-stock{
            background:#f8d7da;
            color:#721c24;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media(max-width:900px){

            .container{
                flex-direction:column;
            }

            .sidebar{
                width:100%;
            }

            table{
                font-size:14px;
            }

            .header{
                flex-direction:column;
                align-items:flex-start;
                gap:20px;
            }

        }

    </style>

</head>
<body>

<div class="container">

    <!-- SIDEBAR -->

<div class="sidebar">

    <h2>🍰 Admin</h2>

    <a href="{{ route('admin.account') }}">
        📊 Dashboard
    </a>

    <a href="{{ route('admin.account', ['page'=>'maintenance']) }}">
        🛠 Maintenance
    </a>

    <a href="{{ route('admin.orders') }}">
        📦 Orders
    </a>

    <a href="{{ route('admin.account', ['page'=>'delivery']) }}">
        🚚 Delivery
    </a>

    <a href="{{ route('admin.account', ['page'=>'reports']) }}">
        📑 Reports
    </a>

    <a href="{{ route('admin.inventory') }}" class="active">
        📦 Inventory
    </a>

</div>

    <!-- MAIN -->

    <div class="main">

        <!-- HEADER -->

        <div class="header">

            <div>
                <h1>Inventory Monitoring</h1>
                <p>Ready Cakes Stock Monitoring</p>
            </div>

            <button class="logout-btn">
                Logout
            </button>

        </div>

        <!-- INVENTORY -->

        <div class="inventory-card">

            <h2 class="inventory-title">
                📦 Product Inventory
            </h2>

            <table>

                <thead>

                    <tr>

                        <th>Image</th>

                        <th>Product</th>

                        <th>Price</th>

                        <th>Stock</th>

                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($inventoryProducts as $product)

                        <tr>

                            <td>

                                <img
                                    src="{{ asset('storage/' . $product->image) }}"
                                    class="product-img"
                                >

                            </td>

                            <td>

                                {{ $product->name }}

                            </td>

                            <td>

                                ₱{{ number_format($product->price, 2) }}

                            </td>

                            <td>

                                {{ $product->stock }}

                            </td>

                            <td>

                                @if($product->stock <= 0)

                                    <span class="status out-stock">
                                        Out of Stock
                                    </span>

                                @elseif($product->stock <= 5)

                                    <span class="status low-stock">
                                        Low Stock
                                    </span>

                                @else

                                    <span class="status in-stock">
                                        In Stock
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5">

                                No inventory products found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>