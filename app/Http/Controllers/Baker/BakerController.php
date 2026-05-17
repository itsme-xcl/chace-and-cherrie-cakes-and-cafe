<?php

namespace App\Http\Controllers\Baker;

use App\Http\Controllers\Controller;
use App\Models\Order;

class BakerController extends Controller
{
    public function index()
    {
        // 🔐 Check login
        if (!session('baker_logged_in')) {
            return redirect()->route('baker.login');
        }

        // 🔥 Active Orders (to work on)
        $activeOrders = Order::whereIn('status', ['paid', 'baking'])
            ->latest()
            ->get();

        // ✅ Completed Orders (finished)
        $completedOrders = Order::whereIn('status', ['ready', 'completed'])
            ->latest()
            ->get();

        // ✅ SEND BOTH VARIABLES
        return view('baker.bakeraccount', [
            'activeOrders' => $activeOrders,
            'completedOrders' => $completedOrders
        ]);
    }


    public function start($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'paid') {
            return back()->with('error', 'Order is not ready to start.');
        }

        $order->update([
            'status' => 'baking'
        ]);

        return back()->with('success', 'Baking started!');
    }


    public function ready($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'baking') {
            return back()->with('error', 'Order is not in baking stage.');
        }

        $order->update([
            'status' => 'ready'
        ]);

        return back()->with('success', 'Order is ready!');
    }


    public function complete($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'ready') {
            return back()->with('error', 'Order is not ready to complete.');
        }

        $order->update([
            'status' => 'completed'
        ]);

        return back()->with('success', 'Order completed!');
    }

    public function dashboard()
    {
        // ACTIVE ORDERS
        $activeOrders = Order::whereIn('status', ['paid', 'baking'])
            ->latest()
            ->get();

        // COMPLETED SECTION
        $completedOrders = Order::whereIn('status', ['ready', 'completed'])
            ->latest()
            ->get();

        // DASHBOARD COUNTS
        $pendingOrders = Order::where('status', 'paid')->count();

        $preparingOrders = Order::where('status', 'baking')->count();

        $readyOrders = Order::where('status', 'ready')->count();

        $deliveryOrders = Order::where('status', 'completed')->count();

        // READY + COMPLETED TODAY
        $completedToday = Order::whereIn('status', ['ready', 'completed'])
            ->whereDate('updated_at', today())
            ->count();

        return view('baker.bakeraccount', compact(
            'activeOrders',
            'completedOrders',
            'pendingOrders',
            'preparingOrders',
            'readyOrders',
            'deliveryOrders',
            'completedToday'
        ));
    }
    }