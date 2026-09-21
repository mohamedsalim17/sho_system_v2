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
        'phone' => 'nullable',
        'gender' => 'nullable',
        'birth_date' => 'nullable|date|before:today',
        'date_of_death' => 'nullable|date|before:today',
    ]);

    $customer = new Customer();
    $customer->name = $request->name;
    $customer->phone = $request->phone ?? null;
    $customer->national_id = $request->national_id ?? null;
    $customer->gender = $request->gender ?? null;
    $customer->birth_date = $request->birth_date ?? null;
    $customer->city = $request->city ?? null;
    $customer->state = $request->state ?? null;
    $customer->education_level = $request->education_level ?? null;
    $customer->job = $request->job ?? null;
    $customer->date_of_death = $request->date_of_death ?? null; // تاريخ الوفاة
    $customer->place_of_death = $request->place_of_death ?? null; // مكان الوفاة
    $customer->address = $request->address ?? null;
    $customer->save();

    return redirect()->route('customers.index')->with('success','تم الحفظ');
}

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }
public function update(Request $request,Customer $customer)
{
   
    $request->validate([
        'name' => 'required',
        'national_id' => 'nullable|unique:customers,national_id',
        'phone' => 'nullable',
        'gender' => 'nullable',
        'birth_date' => 'nullable|date|before:today',
        'date_of_death' => 'nullable|date|before:today',
    ]);

    $customer = new Customer();
    $customer->name = $request->name;
    $customer->phone = $request->phone ?? null;
    $customer->national_id = $request->national_id ?? null;
    $customer->gender = $request->gender ?? null;
    $customer->birth_date = $request->birth_date ?? null;
    $customer->city = $request->city ?? null;
    $customer->state = $request->state ?? null;
    $customer->education_level = $request->education_level ?? null;
    $customer->job = $request->job ?? null;
    $customer->date_of_death = $request->date_of_death ?? null; // تاريخ الوفاة
    $customer->place_of_death = $request->place_of_death ?? null; // مكان الوفاة
    $customer->address = $request->address ?? null;
    $customer->save();

    $customer->route('customer.index')->with('success','تم التعديل ');
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
