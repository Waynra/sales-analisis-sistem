<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SalesImportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Semua route aplikasi penjualan didefinisikan di bawah ini.
| Halaman utama (/) akan langsung redirect ke dashboard penjualan.
|--------------------------------------------------------------------------
*/

// Redirect root ke halaman sales
Route::get('/', fn() => redirect()->route('sales.index'));

// Sales routes
Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
Route::post('/sales/import', [SalesController::class, 'import'])->name('sales.import');
Route::post('/sales/import-platform', [SalesImportController::class, 'import'])->name('sales.import.platform');

// Export routes
Route::get('/sales/export/excel', [SalesController::class, 'exportExcel'])->name('sales.exportExcel');
Route::get('/sales/export/csv', [SalesController::class, 'exportCSV'])->name('sales.exportCSV');
Route::get('/sales/export/pdf', [SalesController::class, 'exportPDF'])->name('sales.exportPDF');

// Optional future routes
// Route::get('/welcome', function () {
//     return view('welcome');
// });
