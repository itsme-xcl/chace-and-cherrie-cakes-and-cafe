<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Excel;
use App\Exports\SalesReportExport;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
   private $salesStatuses = [
    'Paid',
    'Ready',
    'Delivery',
    'Completed'
];

    /*
    |--------------------------------------------------------------------------
    | REPORT PAGE
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();

        $base = Order::whereIn('status', $this->salesStatuses);

        // SALES
        $todayRevenue = (clone $base)
            ->whereDate('created_at', $today)
            ->sum('total_price');

        $weeklyRevenue = (clone $base)
            ->whereBetween('created_at', [$startOfWeek, Carbon::now()])
            ->sum('total_price');

        $monthlyRevenue = (clone $base)
            ->whereBetween('created_at', [$startOfMonth, Carbon::now()])
            ->sum('total_price');

        // ORDERS
        $orders = Order::whereIn('status', [
            'Pending',
            'Paid',
            'Ready',
            'Delivery',
            'Completed',
            'Rejected'
        ])->latest()->get();

        $monthlySalesChart = Order::select(
        DB::raw('MONTH(created_at) as month'),
        DB::raw('SUM(total_price) as total')
                )
                ->whereIn('status', ['Ready', 'Completed'])
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            $chartLabels = [];
            $chartData = [];

            foreach ($monthlySalesChart as $sale) {

                $chartLabels[] = date('F', mktime(0, 0, 0, $sale->month, 1));

                $chartData[] = $sale->total;
            }

            $pendingOrders = Order::where('status', 'Pending')->latest()->get();

            $bakingOrders = Order::whereIn('status', [
                'Paid',
                'Ready',
                'Delivery'
            ])->latest()->get();

            $completedOrders = Order::where('status', 'Completed')->latest()->get();

            $rejectedOrders = Order::where('status', 'Rejected')->latest()->get();
       return view('admin.reports', compact(
            'orders',
            'todayRevenue',
            'weeklyRevenue',
            'monthlyRevenue',

            'pendingOrders',
            'bakingOrders',
            'completedOrders',
            'rejectedOrders'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT PDF
    |--------------------------------------------------------------------------
    */
        public function exportPDF(Request $request)
        {
            $orders = \App\Models\Order::latest()->get();

            $pdf = Pdf::loadView('admin.reports_pdf', compact('orders'));

            return $pdf->download('sales-report.pdf');
        }

    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL
    |--------------------------------------------------------------------------
    */
    public function exportExcel()
    {
        return Excel::download(
            new SalesReportExport,
            'sales-report.xlsx'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PRINT REPORT
    |--------------------------------------------------------------------------
    */
        public function print()
    {
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();

       $base = Order::whereIn('status', [
            'Paid',
            'Ready',
            'Delivery',
            'Completed'
        ]);

        $todayRevenue = (clone $base)
            ->whereDate('created_at', $today)
            ->sum('total_price');

        $weeklyRevenue = (clone $base)
            ->whereBetween('created_at', [$startOfWeek, Carbon::now()])
            ->sum('total_price');

        $monthlyRevenue = (clone $base)
            ->whereBetween('created_at', [$startOfMonth, Carbon::now()])
            ->sum('total_price');

        // ONLY READY + COMPLETED
        $orders = Order::latest()->get();

        return view('admin.reports_print', compact(
            'orders',
            'todayRevenue',
            'weeklyRevenue',
            'monthlyRevenue'
        ));
    }
}