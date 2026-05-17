<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>{{ $product->name }}</title>

    <link rel="stylesheet"
          href="{{ asset('css/product-details.css') }}">
</head>
<body>

<div class="details-container">

    <div class="top-bar">

        <a href="{{ route('products.index') }}"
           class="back-btn">

            ← Back to Products

        </a>

    </div>

    <div class="details-card">

        <!-- IMAGE -->
        <div class="image-section">

            <img src="{{ asset($product->image) }}"
                 alt="{{ $product->name }}"
                 class="details-image">

        </div>

        <!-- DETAILS -->
        <div class="details-info">

            <span class="category-badge">
                🎂 Premium Cake
            </span>

            <h1 class="product-title">
                {{ $product->name }}
            </h1>

            <div class="price">
                ₱{{ number_format($product->price, 2) }}
            </div>

            <div class="stock">
                ✅ Available Stock:
                {{ $product->stock }}
            </div>

            <!-- SIZES -->
            <div class="section">

                <h3>Available Sizes</h3>

                <div class="tag-group">

                    <div class="tag">6 Inches</div>
                    <div class="tag">8 Inches</div>
                    <div class="tag">10 Inches</div>

                </div>

            </div>

            <!-- FLAVORS -->
            <div class="section">

                <h3>Available Flavors</h3>

                <div class="tag-group">

                    <div class="tag">Chocolate</div>
                    <div class="tag">Vanilla</div>
                    <div class="tag">Mocha</div>
                    <div class="tag">Strawberry</div>

                </div>

            </div>

            <!-- DESCRIPTION -->
            <div class="section">

                <h3>Description</h3>

                <p class="description">

                    Delicious freshly baked
                    <strong>{{ $product->name }}</strong>
                    made with premium ingredients and designed
                    perfectly for birthdays, anniversaries,
                    celebrations, and special occasions.

                </p>

            </div>

            <!-- BUTTON -->
            <a href="{{ route('products.checkout', $product->id) }}"
            class="buy-btn">

                🛒 Buy Now

            </a>

        </div>

    </div>

</div>

</body>
</html>