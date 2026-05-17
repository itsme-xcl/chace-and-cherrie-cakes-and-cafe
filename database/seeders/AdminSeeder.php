<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::updateOrCreate(
            [
                'email' => 'admin@chacecakes.com',
            ],
            [
                'name' => 'System Admin',
                'password' => Hash::make('admin123'),
            ]
        );
    }
}