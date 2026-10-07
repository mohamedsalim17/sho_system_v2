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
Route::get('/reports', [ReportController::class,'index'])->name('reports.index');

// اليوزرات للادمن فقط
Route::middleware(['role:admin'])->group(function(){
 Route::resource('users', UserController::class);
});
