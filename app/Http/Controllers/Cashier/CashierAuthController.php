<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cashier;
use Illuminate\Support\Facades\Hash;

class CashierAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.cashierlogin');
    }

    public function login(Request $request)
    {
        $cashier = Cashier::where('username', $request->username)->first();

        if ($cashier && Hash::check($request->password, $cashier->password)) {

            session([
                'cashier_logged_in' => true,
                'cashier_id' => $cashier->id,
                'cashier_name' => $cashier->username
            ]);

            return redirect()->route('cashier.dashboard');
        }

        return back()->with('error', 'Invalid credentials');
    }

    public function logout()
    {
        session()->forget([
            'cashier_logged_in',
            'cashier_id',
            'cashier_name'
        ]);

        return redirect()->route('cashier.login');
    }
}