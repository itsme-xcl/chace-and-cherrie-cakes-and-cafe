<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>Confirm Order</title>

    <link rel="stylesheet" href="{{ asset('css/confirm_order.css') }}">

</head>

<body>

<div class="confirm-wrapper">

    {{-- TITLE --}}
    <div class="confirm-header">

        <h1>🎂 Confirm Your Order</h1>

        <p>
            Review your customized cake order and upload your payment proof.
        </p>

    </div>

    <div class="confirm-grid">

        {{-- LEFT SIDE --}}
        <div class="confirm-card">

            <div class="section-title">
                Order Summary
            </div>

            <div class="summary-grid">

                <div class="summary-item">
                    <span class="summary-label">Customer Name</span>
                    <span class="summary-value">
                        {{ $data['customer_name'] }}
                    </span>
                </div>

                <div class="summary-item">
                    <span class="summary-label">Contact Number</span>
                    <span class="summary-value">
                        {{ $data['contact_number'] }}
                    </span>
                </div>

                <div class="summary-item">
                    <span class="summary-label">Recipient</span>
                    <span class="summary-value">
                        {{ $data['recipient_name'] }}
                    </span>
                </div>

                <div class="summary-item">
                    <span class="summary-label">Theme</span>
                    <span class="summary-value">
                        {{ $themeName }}
                    </span>
                </div>

                <div class="summary-item">
                    <span class="summary-label">Flavor</span>
                    <span class="summary-value">
                        {{ $flavorName }}
                    </span>
                </div>

                <div class="summary-item">
                    <span class="summary-label">Cake Size</span>
                    <span class="summary-value">
                        {{ $sizeName }}
                    </span>
                </div>

                <div class="summary-item">
                    <span class="summary-label">Frosting</span>
                    <span class="summary-value">
                        {{ $frostingName }}
                    </span>
                </div>

                <div class="summary-item">
                    <span class="summary-label">Fondant</span>
                    <span class="summary-value">
                        {{ $fondantName }}
                    </span>
                </div>

                <div class="summary-item">
                    <span class="summary-label">Tiers</span>
                    <span class="summary-value">
                        {{ $data['tiers'] }} Tier
                    </span>
                </div>

                <div class="summary-item">
                    <span class="summary-label">Color Scheme</span>
                    <span class="summary-value">
                        {{ $data['color'] ?? '-' }}
                    </span>
                </div>

                <div class="summary-item">
                    <span class="summary-label">Method</span>
                    <span class="summary-value">
                        {{ $data['method'] }}
                    </span>
                </div>

                @if($data['method'] == 'Pickup')

                    <div class="summary-item">
                        <span class="summary-label">Pickup Date</span>
                        <span class="summary-value">
                            {{ $data['pickup_date'] }}
                        </span>
                    </div>

                @else

                    <div class="summary-item">
                        <span class="summary-label">Delivery Date</span>
                        <span class="summary-value">
                            {{ $data['delivery_date'] }}
                        </span>
                    </div>

                    <div class="summary-item full-width">
                        <span class="summary-label">Address</span>
                        <span class="summary-value">
                            {{ $data['address'] }}
                        </span>
                    </div>

                @endif

                @if(!empty($addonNames))

                    <div class="summary-item full-width">

                        <span class="summary-label">
                            Add-ons
                        </span>

                        <span class="summary-value">
                            {{ implode(', ', $addonNames) }}
                        </span>

                    </div>

                @endif

            </div>

            {{-- PRICE BOX --}}
            <div class="price-box">

                <div class="price-row">
                    <span>Total Price</span>

                    <span>
                        ₱{{ $data['total_price'] }}
                    </span>
                </div>

                <div class="price-row">
                    <span>Down Payment</span>

                    <span>
                        ₱{{ $data['down_payment'] }}
                    </span>
                </div>

            </div>

        </div>

        {{-- RIGHT SIDE --}}
        <div class="confirm-card">

            <div class="section-title">
                GCash Payment
            </div>

            <div class="payment-box">

                <img src="{{ asset('images/gcash.jpg') }}"
                     class="qr-image">

                <div class="payment-info">

                    <p>
                        <strong>GCash Number:</strong>
                        0356410233
                    </p>

                    <p>
                        <strong>Account Name:</strong>
                        Chace & Cherrie Cakes
                    </p>

                </div>

                <div class="payment-warning">
                    ⚠ Send exactly
                    ₱{{ $data['down_payment'] }}
                </div>

            </div>

            {{-- ERROR DISPLAY --}}
            @if ($errors->any())

                <div style="
                    background: #ffebee;
                    padding: 15px;
                    border-radius: 12px;
                    margin-bottom: 20px;
                    color: #c62828;
                    border: 1px solid #ef9a9a;
                ">

                    <strong>
                        Please fix the following errors:
                    </strong>

                    <ul style="margin-top:10px;padding-left:20px;">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))

                <div style="
                    background: #e8f5e9;
                    padding: 15px;
                    border-radius: 12px;
                    margin-bottom: 20px;
                    color: #2e7d32;
                    border: 1px solid #a5d6a7;
                ">

                    {{ session('success') }}

                </div>

            @endif

            {{-- FORM --}}
            <form method="POST"
                  action="{{ route('orders.store') }}"
                  enctype="multipart/form-data">

                @csrf

                {{-- HIDDEN FIELDS --}}
                <input type="hidden" name="customer_name" value="{{ $data['customer_name'] }}">
                <input type="hidden" name="contact_number" value="{{ $data['contact_number'] }}">
                <input type="hidden" name="recipient_name" value="{{ $data['recipient_name'] }}">

                <input type="hidden" name="theme" value="{{ $data['theme'] }}">
                <input type="hidden" name="cake_flavor" value="{{ $data['cake_flavor'] }}">
                <input type="hidden" name="cake_size" value="{{ $data['cake_size'] }}">
                <input type="hidden" name="frosting_type" value="{{ $data['frosting_type'] }}">
                <input type="hidden" name="fondant_option" value="{{ $data['fondant_option'] }}">

                <input type="hidden" name="tiers" value="{{ $data['tiers'] }}">
                <input type="hidden" name="color" value="{{ $data['color'] ?? '' }}">
                <input type="hidden" name="method" value="{{ $data['method'] }}">

                <input type="hidden" name="pickup_date" value="{{ $data['pickup_date'] ?? '' }}">
                <input type="hidden" name="delivery_date" value="{{ $data['delivery_date'] ?? '' }}">
                <input type="hidden"
                    name="delivery_time"
                    value="{{ $data['delivery_time'] ?? '' }}">
                <input type="hidden" name="address" value="{{ $data['address'] ?? '' }}">

                <input type="hidden" name="total_price" value="{{ $data['total_price'] }}">
                <input type="hidden" name="down_payment" value="{{ $data['down_payment'] }}">

                {{-- ADDONS --}}
                @if(isset($data['addons']) && is_array($data['addons']))

                    @foreach($data['addons'] as $addon)

                        <input type="hidden"
                               name="addons[]"
                               value="{{ $addon }}">

                    @endforeach

                @endif

                {{-- UPLOAD --}}
                <div class="upload-section">

                    <label class="upload-label">
                        Upload Proof of Payment *
                    </label>

                    <input type="file"
                           name="payment_proof"
                           accept="image/*"
                           required>

                </div>

                <button type="submit"
                        class="confirm-btn">

                    Submit Payment & Confirm Order

                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>