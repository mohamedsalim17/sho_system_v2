<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ImportController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('employees', EmployeeController::class);
Route::resource('customers', CustomerController::class);
Route::resource('products', ProductController::class);
Route::resource('invoices', InvoiceController::class);
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/general', [ReportController::class, 'general'])->name('reports.general');
Route::get('/reports/custom', [ReportController::class, 'custom'])->name('reports.custom');
Route::get('/reports/builder', [ReportController::class, 'builder'])->name('reports.builder');
Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/excel', [App\Http\Controllers\ReportController::class, 'excel'])->name('reports.excel');
Route::get('/reports/custom', [App\Http\Controllers\ReportController::class, 'custom'])->name('reports.custom');
Route::get('/reports/builder', [App\Http\Controllers\ReportController::class, 'builder'])->name('reports.builder');
Route::get('/import', function () {
    return '<form method="POST" action="/import" enctype="multipart/form-data">'
   . csrf_field().
    '<input type="file" name="file"><button>رفع</button></form>';
});

Route::post('/import', [ImportController::class, 'import']);



