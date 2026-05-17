<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CakeFlavor;
use App\Models\CakeSize;
use App\Models\CakeTheme;
use App\Models\FrostingType;
use App\Models\FondantOption;
use App\Models\CakeAddon; // ✅ ADD THIS

class CustomerController extends Controller
{
    public function account()
    {
        return view('auth.customer_account', [
            'themes'     => CakeTheme::where('status', 'available')->get(),
            'flavors'    => CakeFlavor::where('status', 'available')->get(),
            'sizes'      => CakeSize::where('status', 'available')->get(),
            'frostings'  => FrostingType::where('status', 'available')->get(),
            'fondants'   => FondantOption::where('status', 'available')->get(),

            // ✅ THIS FIXES YOUR ERROR
            'addons'     => CakeAddon::where('status', 'available')->get(),
        ]);
    }
}