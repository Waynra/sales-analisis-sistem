<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Carbon\Carbon;
use DB;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        // Filter: default bulan ini
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());
        $platform = $request->input('platform', null);

        // Query dasar
        $query = Sale::whereBetween('date', [$startDate, $endDate]);
        if ($platform) {
            $query->where('platform', $platform);
        }

        // 🔹 Summary utama
        $summary = [
            'total_sales'       => $query->sum('total'),
            'total_ads'         => $query->sum('ads_cost'),
            'total_affiliate'   => $query->sum('affiliate_fee'),
            'total_transactions'=> $query->count(),
        ];

        // 🔹 Profit dan ROI
        $summary['profit'] = $summary['total_sales'] - ($summary['total_ads'] + $summary['total_affiliate']);
        $summary['roi'] = ($summary['total_ads'] + $summary['total_affiliate']) > 0
            ? round(($summary['profit'] / ($summary['total_ads'] + $summary['total_affiliate'])) * 100, 2)
            : 0;

        // 🔹 Tren penjualan per tanggal
        $salesTrend = $query->select(
                DB::raw('date'),
                DB::raw('SUM(total) as total_sales')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // 🔹 Perbandingan Sales vs Ads Cost per Platform
        $platformComparison = Sale::select(
                'platform',
                DB::raw('SUM(total) as total_sales'),
                DB::raw('SUM(ads_cost) as total_ads'),
                DB::raw('SUM(total - ads_cost) as profit')
            )
            ->whereBetween('date', [$startDate, $endDate])
            ->groupBy('platform')
            ->orderByDesc('total_sales')
            ->get();

        // 🔹 Platform terlaris (untuk filter)
        $topPlatforms = Sale::select('platform', DB::raw('SUM(total) as total'))
            ->groupBy('platform')
            ->orderByDesc('total')
            ->get();

        // 🔹 Produk terlaris (Top 5)
        $topProducts = $query->select('product_name', DB::raw('SUM(quantity) as qty'))
            ->groupBy('product_name')
            ->orderByDesc('qty')
            ->limit(5)
            ->get();

        // 🔹 Response AJAX
        if ($request->ajax()) {
            return response()->json([
                'summary'           => $summary,
                'salesTrend'        => $salesTrend,
                'topProducts'       => $topProducts,
                'platformComparison'=> $platformComparison
            ]);
        }

        // 🔹 Return ke view utama
        return view('sales.analytics', compact(
            'summary',
            'salesTrend',
            'topProducts',
            'topPlatforms',
            'platformComparison',
            'startDate',
            'endDate',
            'platform'
        ));
    }
}
