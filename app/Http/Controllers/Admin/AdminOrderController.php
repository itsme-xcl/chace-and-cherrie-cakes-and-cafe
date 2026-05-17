<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        // 🔒 Protect admin
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $query = Order::with(['flavor', 'user']);

        // SEARCH CUSTOMER
        if ($request->filled('search')) {

           $query->whereHas('user', function ($q) use ($request) {

            $q->where('name', 'LIKE', '%' . $request->search . '%');

        });
        }

        // FILTER DATE
        if ($request->filled('date')) {

            $query->whereDate('created_at', $request->date);
        }

        // FILTER STATUS
        if ($request->filled('status')) {

            $query->where('status', $request->status);
        }

        $orders = $query->latest()->get();

        // GROUP CUSTOMERS
        $customerAnalytics = $orders->groupBy('user_id')->map(function ($customerOrders) {

            $customerName = $customerOrders->first()->customer_name;

            $totalOrders = $customerOrders->count();

            $totalSpent = $customerOrders->sum('total_price');

            // FAVORITE FLAVOR
            $favoriteFlavor = $customerOrders
                ->groupBy(function ($order) {
                    return optional($order->flavor)->name;
                })
                ->sortByDesc(function ($group) {
                    return $group->count();
                })
                ->keys()
                ->first();

            return [
                'customer_name' => $customerName,
                'total_orders' => $totalOrders,
                'total_spent' => $totalSpent,
                'favorite_flavor' => $favoriteFlavor ?? 'N/A',
                'orders' => $customerOrders
            ];
        });

        return view('admin.adminaccount', [
            'page' => 'orders',
            'orders' => $orders,
            'customerAnalytics' => $customerAnalytics
        ]);
    }

    public function delivery($id)
{
    $order = Order::findOrFail($id);

    $order->update([
        'status' => 'delivery'
    ]);

    return back()->with('success', 'Order sent for delivery!');
}

public function complete($id)
{
    $order = Order::findOrFail($id);

    $order->update([
        'status' => 'completed'
    ]);

    return back()->with('success', 'Order delivered successfully!');
}
}