<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sales Report PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #555; padding: 6px; text-align: left; }
        th { background: #ddd; }
    </style>
</head>
<body>
    <h3 style="text-align:center;">Sales Report</h3>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Platform</th>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td>{{ $sale->date }}</td>
                    <td>{{ $sale->platform }}</td>
                    <td>{{ $sale->product_name }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>Rp {{ number_format($sale->price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
