<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery;
use Illuminate\Support\Facades\Hash;

class DeliveryController extends Controller
{
    public function register(Request $request)
    {
        Delivery::create([
            'name' => $request->name,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('delivery.login');
    }

    public function login(Request $request)
    {
        $delivery = Delivery::where('email', $request->email)->first();

        if ($delivery && Hash::check($request->password, $delivery->password)) {

            session([
                'delivery_id' => $delivery->id
            ]);

            return redirect()->route('delivery.dashboard');
        }

        return back()->with('error', 'Invalid email or password');
    }
}