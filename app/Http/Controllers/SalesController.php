<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Rap2hpoutre\FastExcel\FastExcel;
use Barryvdh\DomPDF\Facade\Pdf;

class SalesController extends Controller
{
    /**
     * Tampilkan data penjualan
     */
    public function index()
    {
        $sales = Sale::orderBy('date', 'desc')->paginate(10);
        return view('sales.index', compact('sales'));
    }

    /**
     * Import file Excel/CSV (template sistem)
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls'
        ]);

        try {
            (new FastExcel)->import($request->file('file'), function ($row) {
                return Sale::create([
                    'platform' => $row['platform'] ?? 'Unknown',
                    'date' => $row['date'] ?? now(),
                    'product_name' => $row['product_name'] ?? '-',
                    'quantity' => $row['quantity'] ?? 0,
                    'price' => $row['price'] ?? 0,
                    'ads_cost' => $row['ads_cost'] ?? 0,
                    'affiliate_fee' => $row['affiliate_fee'] ?? 0,
                    'total' => $row['total'] ?? (($row['quantity'] ?? 0) * ($row['price'] ?? 0)),
                ]);
            });

            return back()->with('success', '✅ Data berhasil diimpor!');
        } catch (\Exception $e) {
            return back()->with('error', '❌ Gagal impor: ' . $e->getMessage());
        }
    }

    /**
     * Export Excel
     */
    public function exportExcel()
    {
        $sales = Sale::orderBy('date', 'desc')->get();
        return (new FastExcel($sales))->download('sales_report.xlsx');
    }

    /**
     * Export CSV
     */
    public function exportCSV()
    {
        $sales = Sale::orderBy('date', 'desc')->get();
        return (new FastExcel($sales))->download('sales_report.csv');
    }

    /**
     * Export PDF
     */
    public function exportPDF()
    {
        $sales = Sale::orderBy('date', 'desc')->get();
        $pdf = Pdf::loadView('sales.pdf', compact('sales'))->setPaper('a4', 'landscape');
        return $pdf->download('sales_report.pdf');
    }
}
