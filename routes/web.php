<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
 

Route::resource('products', ProductController::class);
Route::resource('customers', CustomerController::class)->except(['show']);
Route::resource('invoices', InvoiceController::class);
Route::resource('employees', EmployeeController::class);
Route::get('/employees/create', [EmployeeController::class, 'create']);
Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');



