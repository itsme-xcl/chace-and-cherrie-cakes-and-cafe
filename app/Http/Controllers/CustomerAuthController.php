<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CustomerAuthController extends Controller
{
    // REGISTER
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Combine names
        $fullName = $request->first_name . ' ' . $request->last_name;

        // Save customer
        $customer = new User();

        $customer->name = $fullName;
        $customer->email = $request->email;
        $customer->password = Hash::make($request->password);

        $customer->save();
        Auth::login($customer);


        Session::put('user_id', $customer->id);
        Session::put('user_name', $customer->name);
        Session::put('user_email', $customer->email);

        return redirect()->route('customer.account');
    }

    // LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = DB::table('users')
            ->where('email', $request->email)
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {

            // LOGIN USING AUTH
            Auth::loginUsingId($user->id);

            // STORE SESSION
            Session::put('user_id', $user->id);
            Session::put('user_name', $user->name);
            Session::put('user_email', $user->email);

            return redirect()->route('customer.account');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password',
        ])->withInput();
    }

    // LOGOUT
    public function logout()
    {
        Session::forget('user_id');
        Session::forget('user_name');
        Session::forget('user_email');

        return redirect()->route('customer.login');
    }

    // SEND CODE
    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = DB::table('users')
            ->where('email', $request->email)
            ->first();

        if (!$user) {
            return back()->with('error', 'Email not found');
        }

        $code = rand(100000, 999999);

        Session::put('customer_reset_code', $code);
        Session::put('customer_reset_email', $request->email);

        Mail::raw(
            "Your customer verification code is: $code",
            function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Customer Password Reset Code');
            }
        );

        return redirect()->route('customer.verify');
    }

    // VERIFY CODE
    public function verifyCode(Request $request)
    {
        if ($request->code == session('customer_reset_code')) {

            return redirect()->route('customer.reset');
        }

        return back()->with('error', 'Invalid verification code');
    }

    // RESET PASSWORD
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:4|confirmed'
        ]);

        DB::table('users')
            ->where('email', session('customer_reset_email'))
            ->update([
                'password' => Hash::make($request->password)
            ]);

        Session::forget('customer_reset_code');
        Session::forget('customer_reset_email');

        return redirect()->route('customer.login')
            ->with('success', 'Password reset successful');
    }
}