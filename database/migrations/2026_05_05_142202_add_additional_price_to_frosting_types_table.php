<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('frosting_types', 'additional_price')) {
            Schema::table('frosting_types', function (Blueprint $table) {
                $table->decimal('additional_price', 8, 2)
                      ->default(0)
                      ->after('name');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('frosting_types', 'additional_price')) {
            Schema::table('frosting_types', function (Blueprint $table) {
                $table->dropColumn('additional_price');
            });
        }
    }
};