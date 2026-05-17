<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ADMIN LOGIN
    |--------------------------------------------------------------------------
    */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $admin = DB::table('admins')
            ->where('email', $request->username)
            ->first();

        if ($admin && Hash::check($request->password, $admin->password)) {

            session([
                'admin_logged_in' => true
            ]);

            return redirect()->route('admin.account')
                ->with('success', 'Welcome Admin!');
        }

        return back()->with('error', 'Invalid username or password');
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN LOGOUT
    |--------------------------------------------------------------------------
    */
    public function logout()
    {
        session()->forget('admin_logged_in');

        return redirect()->route('admin.login');
    }


    /*
    |--------------------------------------------------------------------------
    | SEND VERIFICATION CODE
    |--------------------------------------------------------------------------
    */
    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {

            return back()->with('error', 'Admin email not found');
        }

        // GENERATE 6 DIGIT CODE
        $code = rand(100000, 999999);

        // SAVE TO SESSION
        Session::put('admin_reset_code', $code);
        Session::put('admin_reset_email', $request->email);

        // SEND EMAIL
        Mail::raw(
            "Your Admin verification code is: " . $code,
            function ($message) use ($request) {

                $message->to($request->email)
                    ->subject('Admin Password Reset Verification');
            }
        );

        return redirect()->route('admin.verify')
            ->with('success', 'Verification code sent to your email');
    }


    /*
    |--------------------------------------------------------------------------
    | VERIFY CODE
    |--------------------------------------------------------------------------
    */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        if ($request->code == Session::get('admin_reset_code')) {

            return redirect()->route('admin.reset');
        }

        return back()->with('error', 'Invalid verification code');
    }


    /*
    |--------------------------------------------------------------------------
    | RESET PASSWORD
    |--------------------------------------------------------------------------
    */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:4|confirmed'
        ]);

        $email = Session::get('admin_reset_email');

        if (!$email) {

            return redirect()->route('admin.forgot')
                ->with('error', 'Session expired. Try again.');
        }

        DB::table('admins')
            ->where('email', $email)
            ->update([
                'password' => Hash::make($request->password)
            ]);

        // CLEAR SESSION
        Session::forget('admin_reset_code');
        Session::forget('admin_reset_email');

        return redirect()->route('admin.login')
            ->with('success', 'Password reset successful');
    }
}