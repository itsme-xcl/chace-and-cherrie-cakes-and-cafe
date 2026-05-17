<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class CashierController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | VALID SALES STATUSES
    |--------------------------------------------------------------------------
    */

    private $salesStatuses = [
        'paid',
        'baking',
        'ready',
        'completed'
    ];

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        if (!session('cashier_logged_in')) {
            return redirect()->route('cashier.login');
        }

        $orders = Order::latest()->get();

        $today = now()->toDateString();

        $totalOrdersToday = Order::whereDate('created_at', $today)
            ->count();

        $totalPaidToday = Order::whereDate('created_at', $today)
            ->whereIn('status', $this->salesStatuses)
            ->count();

        $totalSalesToday = Order::whereDate('created_at', $today)
            ->whereIn('status', $this->salesStatuses)
            ->sum('total_price');

        $totalRejectedToday = Order::whereDate('created_at', $today)
            ->where('status', 'rejected')
            ->count();

        return view('cashier.cashieraccount', compact(
            'orders',
            'totalOrdersToday',
            'totalPaidToday',
            'totalSalesToday',
            'totalRejectedToday'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVE
    |--------------------------------------------------------------------------
    */

    public function approve($id)
    {
        $order = Order::findOrFail($id);

        $order->status = 'paid';

        $order->cashier_id = session('cashier_id');

        $order->save();

        return back()->with('success', 'Payment verified!');
    }

    /*
    |--------------------------------------------------------------------------
    | REJECT
    |--------------------------------------------------------------------------
    */

    public function reject($id)
    {
        $order = Order::findOrFail($id);

        $order->status = 'rejected';

        $order->cashier_id = session('cashier_id');

        $order->save();

        return back()->with('success', 'Payment marked invalid!');
    }

    /*
    |--------------------------------------------------------------------------
    | SALES PAGE
    |--------------------------------------------------------------------------
    */

    public function sales(Request $request)
    {
        if (!session('cashier_logged_in')) {
            return redirect()->route('cashier.login');
        }

        $type = $request->type ?? 'day';

        $date = $request->date
            ? Carbon::parse($request->date)
            : now();

        /*
        |--------------------------------------------------------------------------
        | FILTER QUERY
        |--------------------------------------------------------------------------
        */

        $query = Order::query();

        if ($type === 'day') {

            $query->whereDate('created_at', $date);

        } elseif ($type === 'week') {

            $query->whereBetween('created_at', [
                $date->copy()->startOfWeek(),
                $date->copy()->endOfWeek()
            ]);

        } elseif ($type === 'month') {

            $query->whereMonth('created_at', $date->month)
                  ->whereYear('created_at', $date->year);

        } elseif ($type === 'year') {

            $query->whereYear('created_at', $date->year);
        }

        $orders = $query->latest()->get();

        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */

        $totalOrders = $orders->count();

        $totalPaid = $orders
            ->whereIn('status', $this->salesStatuses)
            ->count();

        $totalSales = $orders
            ->whereIn('status', $this->salesStatuses)
            ->sum('total_price');

        $rejected = $orders
            ->where('status', 'rejected')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | REVENUE BREAKDOWN
        | FILTER-BASED
        |--------------------------------------------------------------------------
        */

        if ($type === 'day') {

            $dailyRevenue = Order::whereDate('created_at', $date)
                ->whereIn('status', $this->salesStatuses)
                ->sum('total_price');

            $weeklyRevenue = Order::whereBetween('created_at', [
                    $date->copy()->startOfWeek(),
                    $date->copy()->endOfWeek()
                ])
                ->whereIn('status', $this->salesStatuses)
                ->sum('total_price');

            $monthlyRevenue = Order::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->whereIn('status', $this->salesStatuses)
                ->sum('total_price');

            $yearlyRevenue = Order::whereYear('created_at', $date->year)
                ->whereIn('status', $this->salesStatuses)
                ->sum('total_price');

        } elseif ($type === 'week') {

            $dailyRevenue = Order::whereDate('created_at', $date)
                ->whereIn('status', $this->salesStatuses)
                ->sum('total_price');

            $weeklyRevenue = Order::whereBetween('created_at', [
                    $date->copy()->startOfWeek(),
                    $date->copy()->endOfWeek()
                ])
                ->whereIn('status', $this->salesStatuses)
                ->sum('total_price');

            $monthlyRevenue = Order::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->whereIn('status', $this->salesStatuses)
                ->sum('total_price');

            $yearlyRevenue = Order::whereYear('created_at', $date->year)
                ->whereIn('status', $this->salesStatuses)
                ->sum('total_price');

        } elseif ($type === 'month') {

            $dailyRevenue = Order::whereDate('created_at', $date)
                ->whereIn('status', $this->salesStatuses)
                ->sum('total_price');

            $weeklyRevenue = Order::whereBetween('created_at', [
                    $date->copy()->startOfWeek(),
                    $date->copy()->endOfWeek()
                ])
                ->whereIn('status', $this->salesStatuses)
                ->sum('total_price');

            $monthlyRevenue = Order::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->whereIn('status', $this->salesStatuses)
                ->sum('total_price');

            $yearlyRevenue = Order::whereYear('created_at', $date->year)
                ->whereIn('status', $this->salesStatuses)
                ->sum('total_price');

        } else {

            $dailyRevenue = Order::whereDate('created_at', $date)
                ->whereIn('status', $this->salesStatuses)
                ->sum('total_price');

            $weeklyRevenue = Order::whereBetween('created_at', [
                    $date->copy()->startOfWeek(),
                    $date->copy()->endOfWeek()
                ])
                ->whereIn('status', $this->salesStatuses)
                ->sum('total_price');

            $monthlyRevenue = Order::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->whereIn('status', $this->salesStatuses)
                ->sum('total_price');

            $yearlyRevenue = Order::whereYear('created_at', $date->year)
                ->whereIn('status', $this->salesStatuses)
                ->sum('total_price');
        }

        /*
        |--------------------------------------------------------------------------
        | CHART DATA
        |--------------------------------------------------------------------------
        */

        $labels = [];

        $chartData = [];

        /*
        |--------------------------------------------------------------------------
        | DAILY
        |--------------------------------------------------------------------------
        */

        if ($type === 'day') {

            for ($i = 6; $i >= 0; $i--) {

                $day = $date->copy()->subDays($i);

                $labels[] = $day->format('M d');

                $chartData[] = Order::whereDate('created_at', $day)
                    ->whereIn('status', $this->salesStatuses)
                    ->sum('total_price');
            }
        }

        /*
        |--------------------------------------------------------------------------
        | WEEKLY
        |--------------------------------------------------------------------------
        */

        elseif ($type === 'week') {

            for ($i = 3; $i >= 0; $i--) {

                $start = $date->copy()
                    ->subWeeks($i)
                    ->startOfWeek();

                $end = $date->copy()
                    ->subWeeks($i)
                    ->endOfWeek();

                $labels[] = 'Week ' . $start->format('W');

                $chartData[] = Order::whereBetween('created_at', [$start, $end])
                    ->whereIn('status', $this->salesStatuses)
                    ->sum('total_price');
            }
        }

        /*
        |--------------------------------------------------------------------------
        | MONTHLY
        |--------------------------------------------------------------------------
        */

        elseif ($type === 'month') {

            for ($m = 1; $m <= 12; $m++) {

                $labels[] = Carbon::create()
                    ->month($m)
                    ->format('M');

                $chartData[] = Order::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $m)
                    ->whereIn('status', $this->salesStatuses)
                    ->sum('total_price');
            }
        }

        /*
        |--------------------------------------------------------------------------
        | YEARLY
        |--------------------------------------------------------------------------
        */

        elseif ($type === 'year') {

            for ($y = 4; $y >= 0; $y--) {

                $year = $date->copy()
                    ->subYears($y)
                    ->year;

                $labels[] = $year;

                $chartData[] = Order::whereYear('created_at', $year)
                    ->whereIn('status', $this->salesStatuses)
                    ->sum('total_price');
            }
        }

        return view('cashier.sales', compact(
            'orders',
            'type',
            'date',
            'totalOrders',
            'totalPaid',
            'totalSales',
            'rejected',
            'labels',
            'chartData',
            'dailyRevenue',
            'weeklyRevenue',
            'monthlyRevenue',
            'yearlyRevenue'
        ));
    }
}