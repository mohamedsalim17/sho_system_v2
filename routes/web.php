<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;

Route::get('/', [DashboardController::class,'index'])->name('dashboard');

Route::resource('employees', EmployeeController::class);
Route::resource('customers', CustomerController::class);
Route::resource('products', ProductController::class);
Route::resource('invoices', InvoiceController::class);

// التقارير الجديدة - ما بتهبش القديم
// التقارير - الاصلاح
Route::get('/reports', [ReportController::class, 'index']);
Route::get('/reports/customers', [ReportController::class, 'customers']);
Route::get('/reports/employees', [ReportController::class, 'employees']);
Route::get('/reports/products', [ReportController::class, 'products']);
Route::get('/reports/sales', [ReportController::class, 'sales']);
Route::get('/reports/custom', [ReportController::class, 'custom']);
Route::get('/reports/filter', [ReportController::class, 'filter']);
Route::get('/reports/builder', [ReportController::class,'builder']);

// اليوزرات للادمن فقط
Route::middleware(['role:admin'])->group(function(){
 Route::resource('users', UserController::class);
});
