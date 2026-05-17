<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
    {
        Schema::create('cake_flavors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('additional_price', 8, 2)->default(0);
            $table->enum('status', ['available', 'unavailable'])->default('available');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cake_flavors');
    }
};
