<?php
namespace App\Http\Controllers;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(){ 
        $employees = Employee::latest()->paginate(20);
        return view('employees.index', compact('employees')); 
    }
    public function create(){ return view('employees.create'); }
    
    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'phone' => 'nullable',
            'national_id' => 'nullable',
        ]);
        // توليد رقم موظف تلقائي عشان ما يضرب
        $data['employee_no'] = 'EMP-' . time();
        Employee::create($data);
        return redirect('/employees')->with('success','تمت الاضافة');
    }
    public function edit(Employee $employee){ return view('employees.edit', compact('employee')); }
    
    public function update(Request $request, Employee $employee){ 
        $employee->update($request->validate(['name'=>'required','phone'=>'nullable','national_id'=>'nullable']));
        return redirect('/employees');
    }
    public function destroy(Employee $employee){ $employee->delete(); return back(); }
}
