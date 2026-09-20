<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
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
    'national_id' => 'nullable|unique:customers,national_id',
    'date_of_death' => 'nullable|date|before:today',
    'birth_date' => 'nullable|date|before:today',
]);

    $customer = new Customer();
    $customer->name = $request->name;
    $customer->phone = $request->phone ?: null;
    $customer->national_id = $request->national_id ?: null;
    $customer->gender = $request->gender;
  customer->birth_date = $request->filled('birth_date') && strtotime($request->birth_date) ? $request->birth_date : null;
    $customer->city = $request->city;
    $customer->state = $request->state;
    $customer->education_level = $request->education_level;
    $customer->job = $request->job;
    $customer->date_of_death = $request->filled('date_of_death') && strtotime($request->date_of_death) ? $request->date_of_death : null;
    $customer->place_of_death = $request->place_of_death;
    $customer->address = $request->address;
    $customer->save();

    return redirect()->route('customers.index')->with('success', 'تمت إضافة العميل بنجاح');
}




    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

   public function update(Request $request, Customer $customer)
{
 $request->validate([
    'name' => 'required',
    'national_id' => 'nullable|unique:customers,national_id',
    'date_of_death' => 'nullable|date|before:today',
    'birth_date' => 'nullable|date|before:today',
]);

    $data = $request->all();

    // تحويل الفاضي لـ null عشان الـ unique
    if (empty($data['national_id'])) {
        $data['national_id'] = null;
    }
    if (empty($data['phone'])) {
        $data['phone'] = null;
    }

    $customer->update($data);

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
}
