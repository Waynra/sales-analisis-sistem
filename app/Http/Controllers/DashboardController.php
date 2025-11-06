<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data penjualan per tanggal
        $sales = Sale::selectRaw('DATE(date) as sale_date, SUM(total) as total_sales')
            ->groupBy('sale_date')
            ->orderBy('sale_date', 'ASC')
            ->get();

        $dates = $sales->pluck('sale_date');
        $totals = $sales->pluck('total_sales');

        // Hitung total keseluruhan bulan ini
        $monthTotal = Sale::whereMonth('date', Carbon::now()->month)->sum('total');

        return view('dashboard', compact('dates', 'totals', 'monthTotal'));
    }
}
