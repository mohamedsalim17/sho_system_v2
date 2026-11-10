<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['search' => ['nullable', 'string', 'max:255']]);

        $employees = Employee::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->trim()->toString();
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%')
                        ->orWhere('employee_no', 'like', '%'.$search.'%')
                        ->orWhere('national_id', 'like', '%'.$search.'%')
                        ->orWhere('department', 'like', '%'.$search.'%');
                });
            })
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['employee_no'] = filled($data['employee_no'] ?? null)
            ? $data['employee_no']
            : 'EMP-'.Str::upper(Str::random(10));
        Employee::create($data);

        return redirect()->route('employees.index')->with('success', 'تمت إضافة الموظف بنجاح.');
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $this->validatedData($request, $employee);
        $data['employee_no'] = $employee->employee_no;
        $employee->update($data);

        return redirect()->route('employees.index')->with('success', 'تم تحديث بيانات الموظف.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'تم حذف سجل الموظف.');
    }

    private function validatedData(Request $request, ?Employee $employee = null): array
    {
        return $request->validate([
            'employee_no' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('employees', 'employee_no')->ignore($employee?->id),
            ],
            'national_id' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('employees', 'national_id')->ignore($employee?->id),
            ],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'birth_date' => ['nullable', 'date', 'before_or_equal:today'],
            'death_date' => ['nullable', 'date', 'after_or_equal:birth_date', 'before_or_equal:today'],
            'death_place' => ['nullable', 'string', 'max:255'],
            'marital_status' => ['nullable', Rule::in(['single', 'married'])],
            'job_title' => ['nullable', 'string', 'max:150'],
            'department' => ['nullable', 'string', 'max:150'],
            'salary' => ['nullable', 'numeric', 'min:0', 'max:99999999.99'],
            'hire_date' => ['nullable', 'date', 'before_or_equal:today'],
            'state' => ['nullable', 'string', 'max:150'],
            'city' => ['nullable', 'string', 'max:150'],
            'neighborhood' => ['nullable', 'string', 'max:150'],
            'street' => ['nullable', 'string', 'max:150'],
        ]);
    }
}
