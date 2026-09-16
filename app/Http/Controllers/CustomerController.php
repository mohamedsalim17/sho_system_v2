<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

Class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }
public function create()
{
    return view('customers.create');
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
    ]);

    Customer::create($request->all());

    return redirect()->route('customers.index')->with('success','تمت الاضافة بنجاح');
}

       
    public function edit(Customer  $customer)
    {
      return view('customers.edit', compact('customer'));
    }
    
   public function update(Request $request, Customer $customer)
    {
       $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
        'national_id' => 'nullable|string|max:20|unique:customers,national_id,'.$customer->id,
        // ... باقي القواعد العندك
    ]);

    $customer->update($request->all());

    return redirect()->route('customers.index')->with('success', 'تم التعديل بنجاح');

    }
    
    public function destroy(Customer $customer)
{
    $customer->delete();
    return redirect()->route('customers.index')->with('success', 'تم الحذف بنجاح');
}
public function show(Customer $customer)
{
    return redirect()->route('customers.index'); 
}


} // <-- دا قفل الكلاس مهم جدا
