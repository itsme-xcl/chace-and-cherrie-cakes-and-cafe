<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        Product::create($request->all());
        return redirect()->route('products.index');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('products.details', compact('product'));
    }


    public function checkout($id)
    {
        $product = Product::findOrFail($id);

        $customerName = session('user_name');

        return view('customer.order_summary', compact(
            'product',
            'customerName'
        ));
    }
}
