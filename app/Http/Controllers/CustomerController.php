<?php
namespace App\Http\Controllers;
use App\Models\Customer; use Illuminate\Http\Request;
class CustomerController extends Controller{
 public function index(){ $customers=Customer::latest()->paginate(20); return view('customers.index',compact('customers')); }
 public function create(){ return view('customers.create'); }
 public function store(Request $r){ Customer::create($r->all()); return redirect('/customers')->with('ok','تم'); }
 public function edit(Customer $customer){ return view('customers.edit',compact('customer')); }
 public function update(Request $r, Customer $customer){ $customer->update($r->all()); return redirect('/customers'); }
 public function destroy(Customer $customer){ $customer->delete(); return back(); }
}