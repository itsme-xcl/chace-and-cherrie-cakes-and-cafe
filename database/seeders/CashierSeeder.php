<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CashierSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('cashiers')->insert([
            'username' => 'cashier@gmail.com',
            'password' => Hash::make('cashier123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}