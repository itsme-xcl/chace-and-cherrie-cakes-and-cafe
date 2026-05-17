<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // USER
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // CUSTOMER
            $table->string('customer_name');
            $table->string('contact_number');
            $table->string('recipient_name');

            // CAKE (FK)
            $table->foreignId('flavor_id')->constrained('cake_flavors')->cascadeOnDelete();
            $table->foreignId('size_id')->constrained('cake_sizes')->cascadeOnDelete();
            $table->foreignId('theme_id')->constrained('cake_themes')->cascadeOnDelete();

            // OPTIONAL
            $table->text('addons')->nullable();

            $table->foreignId('frosting_type')
                ->nullable()
                ->constrained('frosting_types')
                ->nullOnDelete();

            $table->foreignId('fondant_option')
                ->nullable()
                ->constrained('fondant_options')
                ->nullOnDelete();

            $table->integer('tiers')->nullable();

            $table->string('color_scheme')->nullable();
            $table->text('design_description')->nullable();
            $table->string('cake_image')->nullable();

            // DELIVERY
            $table->date('delivery_date');
            $table->time('delivery_time')->nullable();
            $table->string('delivery_method');
            $table->string('address')->nullable();

            // PAYMENT
            $table->decimal('total_price', 10, 2);
            $table->decimal('down_payment', 10, 2);

            $table->string('payment_proof')->nullable();
            $table->string('status')->default('pending');

            // CASHIER
            $table->foreignId('cashier_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
