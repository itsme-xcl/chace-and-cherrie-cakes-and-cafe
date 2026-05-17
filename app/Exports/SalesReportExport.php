<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;

class SalesReportExport implements FromCollection
{
    public function collection()
    {
        return Order::whereIn('status', [
            'ready',
            'completed'
        ])->latest()->get();
    }
}