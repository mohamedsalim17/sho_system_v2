<?php
namespace App\Http\Controllers;
use App\Models\Invoice; use App\Models\Product; use App\Models\Customer;
class InvoiceController extends Controller{
 public function index(){
  $invoices=Invoice::with('customer')->latest()->get();
  $products=Product::all();
  $customers=Customer::all();
  return view('invoices.index',compact('invoices','products','customers'));
 }
 public function create(){ $products=Product::all(); $customers=Customer::all(); return view('invoices.create',compact('products','customers')); }
 public function store(\Illuminate\Http\Request $r){ Invoice::create($r->all()); return redirect('/invoices'); }
 public function show(Invoice $invoice){ return view('invoices.show',compact('invoice')); }
 public function destroy(Invoice $invoice){ $invoice->delete(); return back(); }
}