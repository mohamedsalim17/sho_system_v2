<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['search' => ['nullable', 'string', 'max:255']]);

        $customers = Customer::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->trim()->toString();
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%')
                        ->orWhere('phone', 'like', '%'.$search.'%')
                        ->orWhere('national_id', 'like', '%'.$search.'%');
                });
            })
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    public function store(Request $request)
    {
        Customer::create($this->validatedData($request));

        return redirect()->route('customers.index')->with('success', 'تم حفظ بيانات العميل بنجاح.');
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $customer->update($this->validatedData($request, $customer));

        return redirect()->route('customers.index')->with('success', 'تم تحديث بيانات العميل بنجاح.');
    }

    public function destroy(Customer $customer)
    {
        if ($customer->invoices()->exists()) {
            return back()->with('error', 'لا يمكن حذف عميل مرتبط بفواتير. يمكنك تعديل بياناته بدلًا من ذلك.');
        }

        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'تم حذف العميل.');
    }

    private function validatedData(Request $request, ?Customer $customer = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'national_id' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('customers', 'national_id')->ignore($customer?->id),
            ],
            'gender' => ['nullable', Rule::in(['ذكر', 'انثى'])],
            'birth_date' => ['nullable', 'date', 'before_or_equal:today'],
            'education_level' => ['nullable', 'string', 'max:100'],
            'job' => ['nullable', 'string', 'max:150'],
            'state' => ['nullable', 'string', 'max:150'],
            'city' => ['nullable', 'string', 'max:150'],
            'address' => ['nullable', 'string', 'max:2000'],
            'date_of_death' => ['nullable', 'date', 'after_or_equal:birth_date', 'before_or_equal:today'],
            'place_of_death' => ['nullable', 'string', 'max:255'],
        ]);
    }
}
