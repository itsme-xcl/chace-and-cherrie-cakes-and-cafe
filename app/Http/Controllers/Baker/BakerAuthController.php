<?php

namespace App\Http\Controllers\Baker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Baker;
use Illuminate\Support\Facades\Hash;

class BakerAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.bakerlogin');
    }

    public function login(Request $request)
    {
        // validate input
        $request->validate([
            'username' => 'required|email',
            'password' => 'required'
        ]);

        // find baker by email
        $baker = Baker::where('email', $request->username)->first();

        // check password
        if ($baker && Hash::check($request->password, $baker->password)) {

            session([
                'baker_logged_in' => true,
                'baker_id' => $baker->id,
                'baker_email' => $baker->email
            ]);

            return redirect()->route('baker.dashboard');
        }

        return back()->with('error', 'Invalid email or password');
    }

    public function logout()
    {
        session()->forget([
            'baker_logged_in',
            'baker_id',
            'baker_email'
        ]);

        return redirect()->route('baker.login');
    }
}