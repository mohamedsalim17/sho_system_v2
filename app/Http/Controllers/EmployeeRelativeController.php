<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeRelative;
use Illuminate\Http\Request;

class EmployeeRelativeController extends Controller
{
    public function index(Employee $employee)
    {
        $relatives = $employee->relatives()->latest('id')->paginate(20);
        $relative = new EmployeeRelative();

        return view('employees.relatives', compact('employee', 'relatives', 'relative'));
    }

    public function store(Request $request, Employee $employee)
    {
        $data = $this->validatedData($request);
        $data['is_dependent'] = $request->boolean('is_dependent');
        $employee->relatives()->create($data);

        return redirect()->route('employees.relatives.index', $employee)
            ->with('success', 'تمت إضافة بيانات القريب بنجاح.');
    }

    public function edit(Employee $employee, EmployeeRelative $relative)
    {
        $relative = $employee->relatives()->findOrFail($relative->id);

        return view('employees.relative-edit', compact('employee', 'relative'));
    }

    public function update(Request $request, Employee $employee, EmployeeRelative $relative)
    {
        $relative = $employee->relatives()->findOrFail($relative->id);
        $data = $this->validatedData($request);
        $data['is_dependent'] = $request->boolean('is_dependent');
        $relative->update($data);

        return redirect()->route('employees.relatives.index', $employee)
            ->with('success', 'تم تحديث بيانات القريب.');
    }

    public function destroy(Employee $employee, EmployeeRelative $relative)
    {
        $employee->relatives()->findOrFail($relative->id)->delete();

        return redirect()->route('employees.relatives.index', $employee)
            ->with('success', 'تم حذف سجل القريب.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'relation' => ['required', 'string', 'max:255'],
            'national_id' => ['nullable', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date', 'before_or_equal:today'],
            'death_date' => ['nullable', 'date', 'after_or_equal:birth_date', 'before_or_equal:today'],
            'death_place' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'in:male,female'],
            'is_dependent' => ['sometimes', 'boolean'],
            'bank_account_no' => ['nullable', 'string', 'max:255'],
            'bank_account_name' => ['nullable', 'string', 'max:255'],
            'bank_name' => ['nullable', 'string', 'max:255'],
        ]);
    }
}
