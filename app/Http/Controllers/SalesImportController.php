<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Rap2hpoutre\FastExcel\FastExcel;

class SalesImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,csv']);

        $path = $request->file('file')->getRealPath();
        $rows = (new FastExcel)->import($path);

        $platform = $this->detectPlatform($rows);

        foreach ($rows as $row) {
            $data = $this->mapRow($row, $platform);
            if ($data) {
                Sale::create($data);
            }
        }

        return back()->with('success', "File dari {$platform} berhasil diimpor!");
    }

    private function detectPlatform($rows)
    {
        $headers = array_keys($rows->first());

        if (in_array('Order ID', $headers) && in_array('Order Date', $headers)) return 'Shopee';
        if (in_array('Created Time', $headers) && in_array('Product Name', $headers)) return 'TikTok';
        if (in_array('No Pesanan', $headers) && in_array('Tanggal Pesanan', $headers)) return 'Tokopedia';

        return 'Unknown';
    }

    private function mapRow($row, $platform)
    {
        switch ($platform) {
            case 'Shopee':
                return [
                    'platform' => 'Shopee',
                    'date' => $row['Order Date'],
                    'product_name' => $row['Product Name'],
                    'quantity' => $row['Quantity'],
                    'price' => $row['Item Price'],
                    'ads_cost' => 0,
                    'affiliate_fee' => 0,
                    'total' => $row['Total Amount'] ?? ($row['Quantity'] * $row['Item Price']),
                ];

            case 'TikTok':
                return [
                    'platform' => 'TikTok',
                    'date' => $row['Created Time'],
                    'product_name' => $row['Product Name'],
                    'quantity' => $row['Quantity'],
                    'price' => $row['Unit Price'],
                    'ads_cost' => 0,
                    'affiliate_fee' => 0,
                    'total' => $row['Total Payment'] ?? ($row['Quantity'] * $row['Unit Price']),
                ];

            case 'Tokopedia':
                return [
                    'platform' => 'Tokopedia',
                    'date' => $row['Tanggal Pesanan'],
                    'product_name' => $row['Nama Produk'],
                    'quantity' => $row['Jumlah'],
                    'price' => $row['Harga Satuan'],
                    'ads_cost' => 0,
                    'affiliate_fee' => 0,
                    'total' => $row['Total Pembayaran'] ?? ($row['Jumlah'] * $row['Harga Satuan']),
                ];

            default:
                return null;
        }
    }
}
