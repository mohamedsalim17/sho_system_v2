<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmployeeRelative;

class EmployeeController extends Controller
{
    public function index(){
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    public function store(Request $r){
        $data = $r->all();
        Employee::create($data);
        return back()->with('success','تم الحفظ');
    }

    public function edit($id){
        $employee = Employee::findOrFail($id);
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $r, $id){
        $employee = Employee::findOrFail($id);
        $employee->update($r->all());
        return redirect()->route('employees.index')->with('success','تم التعديل بنجاح');
    }

    public function destroy($id){
        Employee::findOrFail($id)->delete();
        return back()->with('success','تم الحذف');
    }

    public function relatives($id){
        $emp = Employee::with('relatives')->findOrFail($id);
        return view('employees.relatives', compact('emp'));
    }

    public function relativesStore(Request $r, $id){
        EmployeeRelative::create(array_merge($r->all(), ['employee_id'=>$id]));
        return back()->with('success','تم حفظ القريب');
    }
}
