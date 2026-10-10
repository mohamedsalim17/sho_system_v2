<?php
namespace App\Http\Controllers;
use App\Models\Customer; use App\Models\Employee; use App\Models\Product; use App\Models\Invoice;
class DashboardController extends Controller{
 public function index(){
  $employees=Employee::count(); $customers=Customer::count(); $products=Product::count(); $invoices=Invoice::count();
  $latestInvoices=Invoice::with('customer')->latest()->take(10)->get();
  return view('dashboard',['employees'=>$employees,'customers'=>$customers,'products'=>$products,'invoices'=>$invoices,'latestInvoices'=>$latestInvoices,'e'=>$employees,'c'=>$customers,'p'=>$products,'i'=>$invoices]);
 }
}