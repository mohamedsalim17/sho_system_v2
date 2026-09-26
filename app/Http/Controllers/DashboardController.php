<?php
namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Invoice;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index(){
        $sales = 0;
        $paid = 0;
        $latestInvoices = collect();
        
        if (Schema::hasTable('invoices')) {
            if (Schema::hasColumn('invoices', 'total')) {
                $sales = Invoice::sum('total');
            }
            if (Schema::hasColumn('invoices', 'paid')) {
                $paid = Invoice::sum('paid');
            }
            try {
                $latestInvoices = Invoice::with('customer')->latest()->take(5)->get();
            } catch (\Exception $e) {
                $latestInvoices = Invoice::latest()->take(5)->get();
            }
        }

        return view('dashboard', [
            'employees' => Employee::count(),
            'customers' => Customer::count(),
            'products' => Product::count(),
            'invoices' => class_exists(Invoice::class) && Schema::hasTable('invoices') ? Invoice::count() : 0,
            'sales' => $sales,
            'paid' => $paid,
            'latestInvoices' => $latestInvoices,
            'latestEmployees' => Employee::latest()->take(5)->get(),
        ]);
    }
}
