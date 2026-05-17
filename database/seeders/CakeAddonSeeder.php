<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CakeAddon;

class CakeAddonSeeder extends Seeder
{
    public function run()
    {
        $addons = [
            ['name' => 'Extra Chocolate Drip', 'additional_price' => 150],
            ['name' => 'Fresh Fruits Topping', 'additional_price' => 200],
            ['name' => 'Edible Photo Print', 'additional_price' => 250],
            ['name' => 'Gold Leaf Accent', 'additional_price' => 300],
            ['name' => 'Custom Cake Topper', 'additional_price' => 180],
        ];

        foreach ($addons as $addon) {
            CakeAddon::firstOrCreate(
                ['name' => $addon['name']],
                [
                    'additional_price' => $addon['additional_price'],
                    'status' => 'available',
                ]
            );
        }
    }
}
