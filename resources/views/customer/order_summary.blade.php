<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Order Summary</title>

    <link rel="stylesheet" href="/css/order-summary.css">

</head>

@php
    use Illuminate\Support\Facades\Session;
@endphp

<body>

<div class="checkout-container">

    <div class="checkout-card">

        <!-- LEFT SIDE -->
        <div class="product-section">

            <img src="{{ asset($product->image) }}"
                 alt="{{ $product->name }}"
                 class="product-image">

            <div class="product-info">

                <span class="badge">
                    🎂 Ready Cake
                </span>

                <h1>
                    {{ $product->name }}
                </h1>

                <div class="price">
                    ₱{{ number_format($product->price, 2) }}
                </div>

                <div class="stock">
                    Available Stock:
                    {{ $product->stock }}
                </div>

                <div class="details-box">

                    <h3>Cake Details</h3>

                    <p>
                        <strong>Size:</strong>
                        8 Inches
                    </p>

                    <p>
                        <strong>Flavor:</strong>
                        Chocolate
                    </p>

                    <p>
                        <strong>Frosting:</strong>
                        Buttercream
                    </p>

                    <p>
                        <strong>Theme:</strong>
                        Minimalist
                    </p>

                </div>

            </div>

        </div>

        <!-- RIGHT SIDE -->
        <div class="form-section">

            <h2>
                Order Summary
            </h2>
            @if ($errors->any())
                <div style="
                    background:#ffe5e5;
                    color:red;
                    padding:15px;
                    border-radius:10px;
                    margin-bottom:20px;
                ">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session('error'))
            <div style="
                background:#ffe5e5;
                color:red;
                padding:15px;
                border-radius:10px;
                margin-bottom:20px;
            ">
                {{ session('error') }}
            </div>
        @endif

            {{-- ERROR DISPLAY --}}
           

            <form action="{{ route('orders.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <!-- PRODUCT ID -->
                <input type="hidden"
                       name="product_id"
                       value="{{ $product->id }}">

                <!-- REQUIRED ORDER FIELDS -->
                <input type="hidden" name="theme" value="">
                <input type="hidden" name="cake_size" value="">
                <input type="hidden" name="cake_flavor" value="">
                <input type="hidden" name="frosting_type" value="">
                <input type="hidden" name="fondant_option" value="">
                <input type="hidden" name="tiers" value="">
                <input type="hidden" name="addons" value="">
                

                <!-- CUSTOMER -->

                <div class="form-group">

                    <label>
                        Customer Name
                    </label>

                    <input type="text"
                           name="customer_name"
                           value="{{ Session::get('user_name') }}"
                           readonly>

                </div>

                <!-- RECIPIENT -->

                <div class="form-group">

                    <label>
                        Recipient Name
                    </label>

                    <input type="text"
                           name="recipient_name"
                           required>

                </div>

                <!-- CONTACT -->

                <div class="form-group">

                    <label>
                        Contact Number
                    </label>

                    <input type="text"
                           name="contact_number"
                           required>

                </div>

                <!-- METHOD -->

                <div class="form-group">

                    <label>
                        Order Method
                    </label>

                    <select name="delivery_method"
                            id="deliveryMethod"
                            required>

                        <option value="">
                            Select Method
                        </option>

                        <option value="Pickup">
                            Pickup
                        </option>

                        <option value="Delivery">
                            Delivery
                        </option>

                    </select>

                </div>

                <!-- ADDRESS -->

                <div class="form-group"
                     id="addressField">

                    <label>
                        Delivery Address
                    </label>

                    <textarea name="address"
                              rows="3"></textarea>
                    <input type="hidden"
                        name="delivery_time"
                        value="12:00 PM">

                </div>

                <!-- DATE -->

                <div class="form-group">

                    <label>
                        Delivery / Pickup Date
                    </label>

                    <input type="date"
                           name="delivery_date"
                           required>

                </div>

                <!-- SUMMARY -->

                <div class="summary-box">

                    <div class="summary-row">

                        <span>
                            Total Price
                        </span>

                        <strong>
                            ₱{{ number_format($product->price, 2) }}
                        </strong>

                    </div>

                    <div class="summary-row">

                        <span>
                            Required Downpayment
                        </span>

                        <strong>
                            ₱{{ number_format($product->price * 0.5, 2) }}
                        </strong>

                    </div>

                </div>

                <!-- HIDDEN VALUES -->

                <input type="hidden"
                       name="total_price"
                       value="{{ $product->price }}">

                <input type="hidden"
                       name="down_payment"
                       value="{{ $product->price * 0.5 }}">

                <!-- PAYMENT -->

                <div class="form-group">

                    <label>
                        Upload Payment Proof
                    </label>

                    <input type="file"
                           name="payment_proof"
                           required>

                </div>

                <!-- SUBMIT -->

                <button type="submit"
                        class="checkout-btn">

                    Confirm Order

                </button>

            </form>

        </div>

    </div>

</div>

<script>

    const methodSelect =
        document.getElementById('deliveryMethod');

    const addressField =
        document.getElementById('addressField');

    methodSelect.addEventListener('change', function () {

        if (this.value === 'Pickup') {

            addressField.style.display = 'none';

        } else {

            addressField.style.display = 'block';

        }

    });

</script>

</body>
</html>