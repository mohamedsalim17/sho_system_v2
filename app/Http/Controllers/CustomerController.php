<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->paginate(10);
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:customers,name',
        'phone' => 'nullable|unique:customers,phone',
        'national_id' => 'nullable|unique:customers,national_id',
    ], [
        'name.required' => 'الاسم مطلوب',
        'name.unique' => 'هذا الاسم موجود مسبقا',
        'phone.unique' => 'رقم الهاتف موجود مسبقا',
        'national_id.unique' => 'الرقم الوطني موجود مسبقا',
    ]);


        $customer = new Customer();
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->gender = $request->gender;
        $customer->birth_date = $request->birth_date;
        $customer->national_id = $request->national_id;
        $customer->job = $request->job;
        $customer->education_level = $request->education_level;
        $customer->state = $request->state;
        $customer->city = $request->city;
        $customer->address = $request->address;
        $customer->date_of_death = $request->date_of_death;
        $customer->place_of_death = $request->place_of_death;
        $customer->save();

        return redirect()->route('customers.index')->with('success', 'تم الحفظ');
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|unique:customers,name,' . $customer->id,
        ], [
            'name.required' => 'الاسم مطلوب',
            'name.unique' => 'هذا الاسم موجود مسبقاً',
        ]);

        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->gender = $request->gender;
        $customer->birth_date = $request->birth_date;
        $customer->national_id = $request->national_id;
        $customer->job = $request->job;
        $customer->education_level = $request->education_level;
        $customer->state = $request->state;
        $customer->city = $request->city;
        $customer->address = $request->address;
        $customer->date_of_death = $request->date_of_death;
        $customer->place_of_death = $request->place_of_death;
        $customer->save();

        return redirect()->route('customers.index')->with('success', 'تم التعديل');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'تم الحذف');
    }
}
