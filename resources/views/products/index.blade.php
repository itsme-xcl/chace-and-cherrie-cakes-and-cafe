<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select a Cake</title>

    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
</head>
<body>

<header class="topbar">

    <h1>Select a Cake</h1>

    <a href="{{ route('customer.account') }}"
       class="back-btn">

        ← Back

    </a>

</header>

<main class="container">

    <!-- CATEGORY FILTER -->
    <div class="category-bar">

        <button class="active">Cakes</button>

        <button>Customize Cakes</button>

        <button>Drinks</button>

        <button>Savory Pastries</button>

        <button>Sweet Pastries</button>

    </div>

    <!-- PRODUCT GRID -->
    <div class="product-grid">

        {{-- READY CAKES FROM DATABASE --}}
        @foreach ($products as $product)

        <div class="product-card">

            <img src="{{ asset($product->image) }}"
                 alt="{{ $product->name }}">

            <h3>{{ $product->name }}</h3>

            <p class="price">
                ₱{{ number_format($product->price, 2) }}
            </p>

            <p class="stock">
                Stock: {{ $product->stock }}
            </p>

            @if($product->stock > 0)

                <a href="{{ route('products.show', $product->id) }}"
                   class="buy-btn">

                    View Details

                </a>

            @else

                <button class="buy-btn out-stock" disabled>

                    Out of Stock

                </button>

            @endif

        </div>

        @endforeach


        {{-- CUSTOM CAKES --}}
        @for ($i = 1; $i <= 9; $i++)

        <div class="product-card">

            <img src="{{ asset("images/cakes/customize{$i}.jpg") }}"
                 alt="Customize Cake {{ $i }}">

            <h3>Customize {{ $i }} Cake</h3>

            <p class="price">
                ₱1,500.00
            </p>

            <a href="{{ route('customer.account', [
                'cake'  => "Customize {$i} Cake",
                'price' => 1500,
                'image' => "images/cakes/customize{$i}.jpg"
            ]) }}"
               class="buy-btn">

                Customize

            </a>

        </div>

        @endfor

    </div>

</main>

</body>
</html>