
<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

// كل الشغل ده محمي بتسجيل دخول
Route::middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('employees', EmployeeController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('products', ProductController::class);
    Route::resource('invoices', InvoiceController::class);
    Route::resource('installments', InstallmentController::class);

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('reports/custom', [ReportController::class, 'custom'])->name('reports.custom');
    Route::get('reports/filter', [ReportController::class, 'filter'])->name('reports.filter');
    Route::get('reports/builder', [ReportController::class, 'builder'])->name('reports.builder');
    Route::get('reports/excel', [ReportController::class, 'excel'])->name('reports.excel');
    Route::get('reports/pdf', [ReportController::class, 'pdf'])->name('reports.pdf');

    Route::middleware(['role:admin'])->group(function(){
        Route::resource('users', UserController::class);
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth'])->group(function(){
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/system-settings', [App\Http\Controllers\SystemSettingsController::class, 'index'])->name('system.settings.index');
   Route::get('/system-settings', [App\Http\Controllers\SystemSettingsController::class, 'index'])->name('system-settings.index');
    Route::post('/system-settings/logo', [App\Http\Controllers\SystemSettingsController::class, 'storeLogo'])->name('system.settings.logo.store');
    Route::post('/system-settings/users', [App\Http\Controllers\SystemSettingsController::class, 'storeUser'])->name('system.settings.users.store');
    Route::get('/system-settings/users/{id}/delete', [App\Http\Controllers\SystemSettingsController::class, 'deleteUser'])->name('system.settings.users.delete');
    Route::get('/system-settings/backup', [App\Http\Controllers\SystemSettingsController::class, 'downloadBackup'])->name('system.settings.backup');
    Route::post('/system-settings/clean', [App\Http\Controllers\SystemSettingsController::class, 'clean'])->name('system.settings.clean');
});


require __DIR__.'/auth.php';
// قفل التسجيل العام
Route::get('/register', function () {
    return redirect('/login');
})->name('register');

Route::post('/register', function () {
    return redirect('/login');
});

