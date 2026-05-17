<?php

namespace App\Http\Controllers;

use App\Models\Customer; // Import the Customer model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; // Import the Validator class
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function register(Request $request)
    {
        // Validate inputs
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Combine first and last name
        $fullName = $request->first_name . ' ' . $request->last_name;

        // Create customer
        $customer = new Customer();
        $customer->name = $fullName;
        $customer->email = $request->email;
        $customer->password = Hash::make($request->password);

        // Save
        $customer->save();

        // Login customer
        Auth::guard('customer')->login($customer);

        // Redirect
        return redirect('/customer/dashboard');
    }
}