<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            // 🔥 Drop old foreign key (users)
            $table->dropForeign(['cashier_id']);

            // 🔥 Add correct foreign key (cashiers)
            $table->foreign('cashier_id')
                ->references('id')
                ->on('cashiers')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            // rollback if needed
            $table->dropForeign(['cashier_id']);

            $table->foreign('cashier_id')
                ->references('id')
                ->on('users');
        });
    }
};