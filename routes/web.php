<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\EmployeeRelativeController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SystemSettingsController;

// كل الروتات القديمة حقتك قاعدة زي ما هي
Route::middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('installments', InstallmentController::class);

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('reports/sales/export.csv', [ReportController::class, 'exportSalesCsv'])->name('reports.sales.csv');
    Route::get('reports/customers', [ReportController::class, 'customers'])->name('reports.customers');
    Route::get('reports/employees', [ReportController::class, 'employees'])->name('reports.employees');
    Route::get('reports/products', [ReportController::class, 'products'])->name('reports.products');
    Route::get('reports/general', [ReportController::class, 'general'])->name('reports.general');
    Route::get('reports/custom', [ReportController::class, 'custom'])->name('reports.custom');
    Route::get('reports/filter', [ReportController::class, 'filter'])->name('reports.filter');
    Route::get('reports/builder', [ReportController::class, 'builder'])->name('reports.builder');
    Route::get('reports/excel', [ReportController::class, 'exportExcel'])->name('reports.excel');
    Route::get('reports/pdf', [ReportController::class, 'exportPdf'])->name('reports.pdf');
    Route::get('reports/export', [ReportController::class, 'exportPdf'])->name('reports.export');

    // User and system administration routes are restricted to administrators.
    Route::middleware(['role:admin'])->group(function(){
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    Route::middleware(['role:admin,hr'])->group(function () {
        Route::get('/employees/import', [ImportController::class, 'create'])->name('employees.import.create');
        Route::post('/employees/import', [ImportController::class, 'import'])->name('employees.import');
        Route::post('/employees/{employee}/relatives', [EmployeeRelativeController::class, 'store'])->name('employees.relatives.store');
        Route::get('/employees/{employee}/relatives/{relative}/edit', [EmployeeRelativeController::class, 'edit'])->name('employees.relatives.edit');
        Route::put('/employees/{employee}/relatives/{relative}', [EmployeeRelativeController::class, 'update'])->name('employees.relatives.update');
        Route::delete('/employees/{employee}/relatives/{relative}', [EmployeeRelativeController::class, 'destroy'])->name('employees.relatives.destroy');
        Route::resource('employees', EmployeeController::class)->except(['index', 'show']);
        Route::resource('customers', CustomerController::class)->except(['index', 'show']);
        Route::resource('products', ProductController::class)->except(['index', 'show']);
        Route::resource('invoices', InvoiceController::class)->except(['index', 'show']);
    });

    Route::get('/employees/{employee}/relatives', [EmployeeRelativeController::class, 'index'])->name('employees.relatives.index');
    Route::resource('employees', EmployeeController::class)->only(['index', 'show']);
    Route::resource('customers', CustomerController::class)->only(['index', 'show']);
    Route::resource('products', ProductController::class)->only(['index', 'show']);
    Route::resource('invoices', InvoiceController::class)->only(['index', 'show']);

    // Profile - رجعتها جوة ال auth
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/system-settings', [SystemSettingsController::class, 'index'])->name('system.settings');
        Route::post('/system-settings/company', [SystemSettingsController::class, 'storeCompany'])->name('system.settings.company.store');
        Route::post('/system-settings/logo', [SystemSettingsController::class, 'storeLogo'])->name('system.settings.logo.store');
        Route::post('/system-settings/user', [SystemSettingsController::class, 'storeUser'])->name('system.settings.user.store');
        Route::delete('/system-settings/users/{id}', [SystemSettingsController::class, 'deleteUser'])->name('system.settings.user.delete');
        Route::get('/system-settings/backup', [SystemSettingsController::class, 'downloadBackup'])->name('system.settings.backup');
        Route::post('/system-settings/clean', [SystemSettingsController::class, 'clean'])->name('system.settings.clean');
    });
});

require __DIR__.'/auth.php';

// قفل التسجيل العام - حقك القديم قاعد
Route::get('/register', function () {
    return redirect('/login');
})->name('register');

Route::post('/register', function () {
    return redirect('/login');
});
