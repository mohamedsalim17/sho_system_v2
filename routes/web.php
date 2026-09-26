<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('employees', EmployeeController::class);
Route::resource('customers', CustomerController::class);
Route::resource('products', ProductController::class);
Route::resource('invoices', InvoiceController::class);
