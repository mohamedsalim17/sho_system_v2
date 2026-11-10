<?php
namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $employees = Employee::count();
        $customers = Customer::count();
        $products = Product::count();
        $invoices = Invoice::count();
        $salesTotal = Invoice::sum('total_amount');
        $latestInvoices = Invoice::with('customer')->latest('id')->limit(10)->get();

        return view('dashboard', compact('employees', 'customers', 'products', 'invoices', 'salesTotal', 'latestInvoices'));
    }
}