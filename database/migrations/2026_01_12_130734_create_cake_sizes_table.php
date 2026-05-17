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
        // database/migrations/xxxx_create_cake_sizes_table.php
        Schema::create('cake_sizes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('additional_price', 10, 2)->default(0);
            $table->enum('status', ['available', 'unavailable'])->default('available');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cake_sizes');
    }
};
