<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales Data Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-4">
<div class="container">
    <h2 class="mb-4 fw-bold text-center">📦 Sales Data Management</h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Import (Template Sistem) --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            Import File Template Sistem
        </div>
        <div class="card-body">
            <form action="{{ route('sales.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="input-group">
                    <input type="file" name="file" class="form-control" required>
                    <button class="btn btn-success" type="submit">Import Template</button>
                </div>
                <small class="text-muted d-block mt-2">
                    Format: .xlsx atau .csv — Header: platform, date, product_name, quantity, price, ads_cost, affiliate_fee, total
                </small>
            </form>
        </div>
    </div>

    {{-- Import (File Resmi Platform) --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-secondary text-white">
            Import File Resmi (Shopee / Tokopedia / TikTok Shop)
        </div>
        <div class="card-body">
            <form action="{{ route('sales.import.platform') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="input-group">
                    <input type="file" name="file" class="form-control" required>
                    <button class="btn btn-dark" type="submit">Import File Resmi</button>
                </div>
                <small class="text-muted d-block mt-2">
                    Upload langsung file dari Shopee, Tokopedia, atau TikTok Shop tanpa ubah header.
                </small>
            </form>
        </div>
    </div>

    {{-- Export Buttons --}}
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('sales.exportExcel') }}" class="btn btn-outline-success me-2">⬇️ Export Excel</a>
        <a href="{{ route('sales.exportCSV') }}" class="btn btn-outline-warning me-2">📄 Export CSV</a>
        <a href="{{ route('sales.exportPDF') }}" class="btn btn-outline-danger">🧾 Export PDF</a>
    </div>

    {{-- Data Table --}}
    <div class="card shadow-sm">
        <div class="card-header bg-light fw-bold">Data Penjualan</div>
        <div class="card-body table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Platform</th>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Biaya Iklan</th>
                        <th>Affiliate Fee</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $index => $sale)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($sale->date)->format('d M Y') }}</td>
                            <td>{{ $sale->platform }}</td>
                            <td>{{ $sale->product_name }}</td>
                            <td class="text-center">{{ $sale->quantity }}</td>
                            <td class="text-end">Rp {{ number_format($sale->price, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($sale->ads_cost, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($sale->affiliate_fee, 0, ',', '.') }}</td>
                            <td class="text-end fw-bold">Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-3">
                                Belum ada data penjualan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $sales->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
