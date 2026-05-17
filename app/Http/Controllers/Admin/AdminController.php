<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\CakeFlavor;
use App\Models\CakeSize;
use App\Models\CakeAddon;
use App\Models\CakeTheme;
use App\Models\FrostingType;
use App\Models\FondantOption;
use App\Models\Product;

use Carbon\Carbon;

class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SALES STATUSES (FOR DASHBOARD ONLY)
    |--------------------------------------------------------------------------
    */
    private $salesStatuses = [
        'paid',
        'baking',
        'ready',
        'completed'
    ];

    public function index(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        /*
        |--------------------------------------------------------------------------
        | PAGE CONTROLS
        |--------------------------------------------------------------------------
        */
        $page = $request->get('page', 'dashboard');
        $section = $request->get('section', 'flavors');

        /*
        |--------------------------------------------------------------------------
        | COUNTS
        |--------------------------------------------------------------------------
        */
        $counts = [
            'flavors'   => CakeFlavor::count(),
            'sizes'     => CakeSize::count(),
            'addons'    => CakeAddon::count(),
            'themes'    => CakeTheme::count(),
            'frostings' => FrostingType::count(),
            'fondants'  => FondantOption::count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | DATE BASES
        |--------------------------------------------------------------------------
        */
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfYear = Carbon::now()->startOfYear();

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD SALES (ALL VALID STATUSES)
        |--------------------------------------------------------------------------
        */
        $baseSales = Order::whereIn('status', $this->salesStatuses);

        $totalRevenue = (clone $baseSales)->sum('total_price');

        $dailySales = (clone $baseSales)
            ->whereDate('created_at', $today)
            ->sum('total_price');

        $weeklySales = (clone $baseSales)
            ->whereBetween('created_at', [$startOfWeek, Carbon::now()])
            ->sum('total_price');

        $monthlySales = (clone $baseSales)
            ->whereBetween('created_at', [$startOfMonth, Carbon::now()])
            ->sum('total_price');

        $yearlySales = (clone $baseSales)
            ->whereBetween('created_at', [$startOfYear, Carbon::now()])
            ->sum('total_price');

        /*
        |--------------------------------------------------------------------------
        | CHART (LAST 7 DAYS)
        |--------------------------------------------------------------------------
        */
        $chartLabels = [];
        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {

            $day = Carbon::now()->subDays($i);

            $chartLabels[] = $day->format('M d');

            $chartData[] = (clone $baseSales)
                ->whereDate('created_at', $day)
                ->sum('total_price');
        }

        /*
        |--------------------------------------------------------------------------
        | REPORT BASE (ONLY READY + COMPLETED)
        |--------------------------------------------------------------------------
        */
        $reportBase = Order::whereIn('status', ['ready', 'completed']);

        /*
        |--------------------------------------------------------------------------
        | REPORT SALES (CLEAN)
        |--------------------------------------------------------------------------
        */
        $todayRevenue = (clone $reportBase)
            ->whereDate('created_at', $today)
            ->sum('total_price');

        $weeklyRevenue = (clone $reportBase)
            ->whereBetween('created_at', [$startOfWeek, Carbon::now()])
            ->sum('total_price');

        $monthlyRevenue = (clone $reportBase)
            ->whereBetween('created_at', [$startOfMonth, Carbon::now()])
            ->sum('total_price');

        /*
        |--------------------------------------------------------------------------
        | REPORT TABLES
        |--------------------------------------------------------------------------
        */
        $todayOrders = (clone $reportBase)
            ->whereDate('created_at', $today)
            ->latest()
            ->get();

        $weeklyOrders = (clone $reportBase)
            ->whereBetween('created_at', [$startOfWeek, Carbon::now()])
            ->latest()
            ->get();

        $monthlyOrders = (clone $reportBase)
            ->whereBetween('created_at', [$startOfMonth, Carbon::now()])
            ->latest()
            ->get();

        // FIX: $orders is what the blade @forelse($orders) expects
        $orders = Order::whereIn('status', [
            'pending',
            'paid',
            'baking',
            'ready',
            'delivery',
            'completed',
            'rejected'
        ])->latest()->get();

        $pendingOrders = Order::where('status', 'pending')
            ->latest()
            ->get();

        $bakingOrders = Order::whereIn('status', [
            'paid',
            'baking',
            'ready',
            'delivery'
        ])->latest()->get();

        $completedOrders = Order::where('status', 'completed')
            ->latest()
            ->get();

        $rejectedOrders = Order::where('status', 'rejected')
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | MAINTENANCE
        |--------------------------------------------------------------------------
        */
        $model = match ($section) {
            'flavors'   => CakeFlavor::class,
            'sizes'     => CakeSize::class,
            'addons'    => CakeAddon::class,
            'themes'    => CakeTheme::class,
            'frostings' => FrostingType::class,
            'fondants'  => FondantOption::class,
            default     => CakeFlavor::class,
        };

        $items = $model::all();

        $editItem = $request->has('edit')
            ? $model::find($request->edit)
            : null;

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */
        return view('admin.adminaccount', compact(

            'items',
            'editItem',
            'section',
            'page',
            'counts',

            // DASHBOARD
            'totalRevenue',
            'dailySales',
            'weeklySales',
            'monthlySales',
            'yearlySales',

            // CHART
            'chartLabels',
            'chartData',

            // REPORTS
            'todayRevenue',
            'weeklyRevenue',
            'monthlyRevenue',

            'todayOrders',
            'weeklyOrders',
            'monthlyOrders',

            'pendingOrders',
            'bakingOrders',
            'completedOrders',
            'rejectedOrders',

            // FIX: pass $orders for the All Orders Report table in the blade
            'orders'
        ));
    }
    public function inventory()
    {
        $inventoryProducts = Product::latest()->get();

        return view('admin.admininventory', compact('inventoryProducts'));
    }
}