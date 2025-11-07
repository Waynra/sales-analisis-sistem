<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SalesImportController;
use App\Http\Controllers\AnalyticsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Semua route aplikasi penjualan dan dashboard analytics.
| Halaman utama (/) langsung diarahkan ke halaman analytics dashboard.
|--------------------------------------------------------------------------
*/

// Redirect root ke halaman analytics
Route::get('/', fn() => redirect()->route('sales.analytics'));

// Sales Data Routes
Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
Route::post('/sales/import', [SalesController::class, 'import'])->name('sales.import');
Route::post('/sales/import-platform', [SalesImportController::class, 'import'])->name('sales.import.platform');

// Export Routes
Route::get('/sales/export/excel', [SalesController::class, 'exportExcel'])->name('sales.exportExcel');
Route::get('/sales/export/csv', [SalesController::class, 'exportCSV'])->name('sales.exportCSV');
Route::get('/sales/export/pdf', [SalesController::class, 'exportPDF'])->name('sales.exportPDF');

// Analytics Dashboard
Route::get('/sales/analytics', [AnalyticsController::class, 'index'])->name('sales.analytics');

// Optional future routes
// Route::get('/welcome', function () {
//     return view('welcome');
// });
