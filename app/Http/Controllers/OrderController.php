<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\Order;
use App\Models\CakeFlavor;
use App\Models\CakeSize;
use App\Models\CakeAddon;
use App\Models\CakeTheme;
use App\Models\FrostingType;
use App\Models\FondantOption;

class OrderController extends Controller
{
    public function index()
    {
        if (!Session::has('user_id')) {
            return redirect()
                ->route('customer.login')
                ->with('error', 'Please login first.');
        }

        $orders = Order::with([
            'flavor',
            'size',
            'themeRel',
            'frosting',
            'fondant'
        ])
        ->where('user_id', Session::get('user_id'))
        ->latest()
        ->get();
        

        foreach ($orders as $order) {

            // ADDONS
            if ($order->addons) {

                $addonIds = explode(',', $order->addons);

                $order->addon_names = CakeAddon::whereIn('id', $addonIds)
                    ->pluck('name')
                    ->toArray();

            } else {

                $order->addon_names = [];
            }

            // FROSTING NAME
            $order->frosting_name = $order->frosting
                ? $order->frosting->name
                : null;

            // FONDANT NAME
            $order->fondant_name = $order->fondant
                ? $order->fondant->name
                : null;

            // TIERS LABEL
            $order->tiers_label = $order->tiers
                ? $order->tiers . ' Tier' . ($order->tiers > 1 ? 's' : '')
                : null;
        }

        return view('customer.my_orders', compact('orders'));
    }

    public function create(Request $request)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('customer.login');
        }

        return view('customer.orders', [

            'selectedCake' => $request->cake ?? null,
            'cakeImage'    => $request->image ?? null,
            'basePrice'    => $request->price ?? 0,

            'flavors' => CakeFlavor::orderBy('name')->get(),

            'sizes' => CakeSize::orderBy('name')->get(),

            'addons' => CakeAddon::orderBy('name')->get(),

            'themes' => CakeTheme::orderBy('name')->get(),

            'frostings' => FrostingType::orderBy('name')->get(),

            'fondants' => FondantOption::orderBy('name')->get(),
        ]);
    }

    public function confirm(Request $request)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('customer.login');
        }

        $request->validate([
            'customer_name'  => 'required',
            'contact_number' => 'required',
            'recipient_name' => 'required',

            'theme'          => 'required',
            'cake_size'      => 'required',
            'cake_flavor'    => 'required',
            'frosting_type'  => 'required',
            'fondant_option' => 'required',

            'tiers'          => 'required',

            'total_price'    => 'required|numeric',
            'down_payment'   => 'required|numeric',
        ]);

        // KEEP ORIGINAL FORM DATA
        $data = $request->all();

        // GET DATABASE RECORDS USING IDS
        $theme = CakeTheme::find($request->theme);

        $flavor = CakeFlavor::find($request->cake_flavor);

        $size = CakeSize::find($request->cake_size);

        $frosting = FrostingType::find($request->frosting_type ?? $request->frosting_id);

        $fondant = FondantOption::find($request->fondant_option ?? $request->fondant_id);

        // DISPLAY NAMES
        $themeName = $theme ? $theme->name : 'N/A';

        $flavorName = $flavor ? $flavor->name : 'N/A';

        $sizeName = $size ? $size->name : 'N/A';

        $frostingName = $frosting ? $frosting->name : 'N/A';

        $fondantName = $fondant ? $fondant->name : 'N/A';

        // ADDONS
        $addonNames = [];

        if ($request->has('addons') && is_array($request->addons)) {

            $addons = CakeAddon::whereIn('id', $request->addons)->get();

            foreach ($addons as $addon) {

                $addonNames[] = $addon->name;
            }
        }

        return view('customer.confirm_order', compact(
            'data',
            'themeName',
            'flavorName',
            'sizeName',
            'frostingName',
            'fondantName',
            'addonNames'
        ));
    }

    public function store(Request $request)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('customer.login');
        }

        $request->validate([
            'customer_name'  => 'required',
            'contact_number' => 'required',
            'recipient_name' => 'required',

            'theme'          => 'nullable|exists:cake_themes,id',
            'cake_size'      => 'nullable|exists:cake_sizes,id',
            'cake_flavor'    => 'nullable|exists:cake_flavors,id',
            'frosting_type'  => 'nullable|exists:frosting_types,id',
            'fondant_option' => 'nullable|exists:fondant_options,id',

            'tiers' => 'nullable|numeric',

            'total_price'  => 'required|numeric',
            'down_payment' => 'required|numeric',

            'payment_proof' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        // UPLOAD PAYMENT PROOF
                // PAYMENT PROOF
        // PAYMENT PROOF
            $proofPath = null;

            if ($request->hasFile('payment_proof')) {

                $file = $request->file('payment_proof');

                if ($file->isValid()) {

                    $filename = time() . '_' . $file->getClientOriginalName();

                    // STORE FILE INSIDE storage/app/public/payment_proofs
                    $proofPath = $file->storeAs(
                        'payment_proofs',
                        $filename,
                        'public'
                    );
                }
            }

        // ADDONS
        $addons = null;

        if ($request->has('addons') && is_array($request->addons)) {

            $addons = implode(',', $request->addons);
        }

        // PRODUCT STOCK
        if ($request->filled('product_id')) {

            $product = \App\Models\Product::find($request->product_id);

            if ($product) {

                if ($product->stock <= 0) {

                    return back()->with(
                        'error',
                        'Product out of stock.'
                    );
                }

                $product->decrement('stock', 1);
            }
        }
        // SAVE ORDER
       try {

    // SAVE ORDER
                Order::create([

                    'user_id' => Session::get('user_id'),
                    'product_id' => $request->product_id,

                    // CUSTOMER
                    'customer_name'  => $request->customer_name,
                    'contact_number' => $request->contact_number,
                    'recipient_name' => $request->recipient_name,

                    // FOREIGN KEYS
                    'flavor_id' => $request->cake_flavor,
                    'size_id'   => $request->cake_size,
                    'theme_id'  => $request->theme,

                    // CUSTOMIZATION
                    'addons' => $addons,

                    'frosting_type' => $request->frosting_type,

                    'fondant_option' => $request->fondant_option,

                    'tiers' => $request->tiers,

                    'color_scheme' => $request->color ?? null,

                    'design_description' => $request->design_description ?? null,

                    'cake_image' => null,

                    // DELIVERY
                    'delivery_date' => $request->delivery_date,

                    'delivery_time' => date(
                        'H:i:s',
                        strtotime($request->delivery_time)
                    ),

                    'delivery_method' =>
                        $request->delivery_method
                        ?? $request->method,

                    'address' => $request->address ?? null,

                    // PAYMENT
                    'total_price' => $request->total_price,

                    'down_payment' => $request->down_payment,

                    'payment_proof' => $proofPath,

                    'status' => 'pending',
                ]);
                

return redirect()
    ->route('customer.orders')
    ->with('success', 'Order submitted successfully!');



    } catch (\Exception $e) {

        dd($e->getMessage());
    }
    }

    public function myOrders()
    {
        if (!Session::has('user_id')) {
            return redirect()->route('customer.login');
        }

        return $this->index();
    }
}