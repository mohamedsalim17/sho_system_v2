<?php
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return redirect('/employees');
})->name('dashboard');

Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
Route::put('/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');
Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
Route::post('/employees/{id}/relatives', [EmployeeController::class, 'relativesStore'])->name('employees.relativesStore');

// عشان التصميم الجديد ما يقع تاني
Route::get('/products', function(){ return redirect('/employees'); })->name('products.index');
