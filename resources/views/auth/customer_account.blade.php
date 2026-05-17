<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders - Chace and Cherrie Cakes</title>

    <link rel="stylesheet" href="/css/orders.css">

    <style>
        .full-width {
            grid-column: 1 / -1;
        }

        .addons-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .addon-item {
            display: flex;
            align-items: center;
            gap: 6px;
            background: #fff;
            padding: 10px 14px;
            border-radius: 10px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>

@php
    use Illuminate\Support\Facades\Auth;
@endphp

<header class="topbar">

    <div class="logo">
        🍰 <strong>My Orders</strong>
        <span>Chace and Cherrie Cakes</span>
    </div>

    <div class="top-actions">
        <a href="{{ route('customer.orders') }}" class="btn-outline">
            My Orders
        </a>

        <a href="{{ route('products.index') }}" class="btn-outline">
            Products
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-outline">
                Logout
            </button>
        </form>
    </div>

</header>

<main class="container">

    @if(session('success'))
        <div class="alert-success" style="margin-bottom:20px; color:green;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">

        <h2>Cake Order</h2>
        <p class="subtitle">
            Fill in the customer and cake details
        </p>

        <form method="POST" action="{{ route('orders.confirm') }}">
            @csrf

            <!-- CUSTOMER INFO -->
            <div class="form-section">

                <h3>Customer Information</h3>

                <div class="form-grid">

                   <div>
                        <label>Customer Name *</label>

                        <input type="text"
                            name="customer_name_display"
                            value="{{ session('user_name') }}"
                            readonly
                            style="background:#f3f4f6; cursor:not-allowed;"
                            required>

                        <input type="hidden"
                            name="customer_name"
                            value="{{ session('user_name') }}">
                    </div>

                    <div>
                        <label>Contact Number *</label>
                        <input type="text"
                               name="contact_number"
                               required>
                    </div>

                </div>

            </div>

            <!-- CAKE DETAILS -->
            <div class="form-section">

                <h3>Cake Details</h3>

                <div class="form-grid">

                    <!-- RECIPIENT -->
                    <div>
                        <label>Recipient Name *</label>
                        <input type="text"
                               name="recipient_name"
                               required>
                    </div>

                    <!-- THEME -->
                    <div>
                        <label>Theme *</label>

                        <select name="theme" required>
                            <option value="">Select Theme</option>

                            @foreach($themes as $theme)
                                <option value="{{ $theme->id }}">
                                    {{ $theme->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <!-- COLOR -->
                    <div>
                        <label>Color Scheme *</label>
                        <input type="text"
                               name="color"
                               required>
                    </div>

                    <!-- FLAVOR -->
                    <div>
                        <label>Flavor *</label>

                        <select name="cake_flavor" required>
                            <option value="">Select Flavor</option>

                            @foreach($flavors as $flavor)
                                <option value="{{ $flavor->id }}">
                                    {{ $flavor->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <!-- ADDONS -->
                    <div class="full-width">

                        <label>Add-ons (Optional)</label>

                        <div class="addons-list">

                            @foreach($addons as $addon)

                                <label class="addon-item">

                                    <input type="checkbox"
                                           name="addons[]"
                                           value="{{ $addon->id }}"
                                           onchange="calculatePrice()">

                                    <span>
                                        {{ $addon->name }}
                                        (₱{{ number_format($addon->additional_price, 2) }})
                                    </span>

                                </label>

                            @endforeach

                        </div>

                    </div>

                    <!-- FROSTING -->
                    <div>
                        <label>Frosting Type *</label>

                        <select name="frosting_type" required>
                            <option value="">Select Frosting</option>

                            @foreach($frostings as $frosting)
                                <option value="{{ $frosting->id }}">
                                    {{ $frosting->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <!-- FONDANT -->
                    <div>
                        <label>Fondant Option *</label>

                        <select name="fondant_option"
                                onchange="calculatePrice()"
                                required>

                            <option value="">Select Option</option>

                            @foreach($fondants as $fondant)

                                <option value="{{ $fondant->id }}"
                                        data-price="{{ $fondant->additional_price }}">

                                    {{ $fondant->name }}

                                </option>

                            @endforeach

                        </select>
                    </div>

                    <!-- SIZE -->
                    <div>
                        <label>Size *</label>

                        <select name="cake_size"
                                onchange="calculatePrice()"
                                required>

                            <option value="">Select Size</option>

                            @foreach($sizes as $size)

                                <option value="{{ $size->id }}"
                                        data-price="{{ $size->additional_price }}">

                                    {{ $size->name }}

                                </option>

                            @endforeach

                        </select>
                    </div>

                    <!-- TIERS -->
                    <div>

                        <label>Number of Tiers *</label>

                        <select name="tiers"
                                id="tiers"
                                onchange="generateTierOptions(); calculatePrice();"
                                required>

                            <option value="">Select</option>
                            <option value="1">1 Tier</option>
                            <option value="2">2 Tiers</option>
                            <option value="3">3 Tiers</option>

                        </select>

                    </div>

                    <!-- TIER OPTIONS -->
                    <div id="tierOptions" class="full-width"></div>

                    <!-- DELIVERY -->
                    <div>

                        <label>Delivery Method *</label>

                        <select name="method"
                                id="method"
                                onchange="handleDeliveryMethod(); calculatePrice();"
                                required>

                            <option value="">Select</option>
                            <option value="Pickup">Pickup</option>
                            <option value="Delivery">Delivery</option>

                        </select>

                    </div>

                    <!-- DELIVERY DETAILS -->
                    <div id="dateField" class="full-width"></div>

                    <!-- TOTAL -->
                    <div>
                        <label>Total Price *</label>

                        <input type="number"
                               name="total_price"
                               id="total_price"
                               readonly>
                    </div>

                    <!-- DOWN PAYMENT -->
                    <div>
                        <label>Down Payment (50%) *</label>

                        <input type="number"
                               name="down_payment"
                               id="down_payment"
                               readonly>
                    </div>

                </div>

            </div>

            <!-- SUBMIT -->
            <div class="form-actions">

                <button type="submit" class="btn-primary large">
                    Submit Order
                </button>

            </div>

        </form>

    </div>

</main>

<script>

// GENERATE TIERS
function generateTierOptions() {

    const tiers = document.getElementById('tiers').value;
    const container = document.getElementById('tierOptions');

    container.innerHTML = '';

    for (let i = 1; i <= tiers; i++) {

        container.innerHTML += `
            <div style="margin-top:10px;">
                <label>Tier ${i} Type</label>

                <select name="tier_type_${i}">
                    <option value="">Select</option>
                    <option value="Edible">Edible</option>
                    <option value="Dummy">Dummy</option>
                </select>
            </div>
        `;
    }
}

// DELIVERY METHOD
function handleDeliveryMethod() {

    const method = document.getElementById('method').value;
    const container = document.getElementById('dateField');

    container.innerHTML = '';

    if (method === "Pickup") {

        container.innerHTML = `
            <div>
                <label>Pickup Date *</label>

                <input type="date"
                       name="pickup_date"
                       required>
            </div>
        `;

    } else if (method === "Delivery") {

        container.innerHTML = `
            <div>
                <label>Delivery Date *</label>

                <input type="date"
                       name="delivery_date"
                       required>
            </div>

            <div>
                <label>Delivery Address *</label>

                <input type="text"
                       name="address"
                       required>
            </div>
        `;
    }
}

// CALCULATE PRICE
function calculatePrice() {

    let price = 0;

    // SIZE PRICE
    const size = document.querySelector('[name="cake_size"]');

    const sizePrice =
        size.options[size.selectedIndex]?.dataset.price || 0;

    price += parseFloat(sizePrice);

    // FONDANT PRICE
    const fondant = document.querySelector('[name="fondant_option"]');

    const fondantPrice =
        fondant.options[fondant.selectedIndex]?.dataset.price || 0;

    price += parseFloat(fondantPrice);

    // ADDONS PRICE
    const addonCheckboxes =
        document.querySelectorAll('input[name="addons[]"]:checked');

    addonCheckboxes.forEach(addon => {

        const label = addon.closest('.addon-item')
            .innerText;

        const match = label.match(/₱([\d,.]+)/);

        if (match) {
            price += parseFloat(
                match[1].replace(',', '')
            );
        }
    });

    // TIERS
    const tiers =
        parseInt(document.getElementById('tiers').value) || 0;

    if (tiers > 1) {
        price += (tiers - 1) * 300;
    }

    // DELIVERY
    const method =
        document.getElementById('method').value;

    if (method === "Delivery") {
        price += 100;
    }

    // TOTAL
    document.getElementById('total_price').value = price;

    // DOWNPAYMENT
    document.getElementById('down_payment').value =
        Math.round(price / 2);
}

</script>

</body>
</html>