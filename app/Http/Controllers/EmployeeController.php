<?php
namespace App\Http\Controllers;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(){ $employees = Employee::latest()->get(); return view('employees.index', compact('employees')); }
    
    public function create(){ return view('employees.create'); }

    public function store(Request $r){
        $r->validate(['name'=>'required']);
        Employee::create($r->all());
        return redirect('/employees')->with('success','تمت الإضافة');
    }

   public function edit($id){ 
    $employee = Employee::findOrFail($id); 
    return view('employees.edit', compact('employee')); 
}

public function update(Request $request, $id)
{
    $employee = Employee::findOrFail($id);

    $request->validate([
        'name' => 'required|unique:employees,name,'.$employee->id,
        'phone' => 'nullable|unique:employees,phone,'.$employee->id,
        'national_id' => 'nullable|unique:employees,national_id,'.$employee->id,
    ], [
        'name.required' => 'الاسم مطلوب',
        'name.unique' => 'الاسم موجود مسبقا',
        'phone.unique' => 'رقم الهاتف موجود مسبقا',
        'national_id.unique' => 'الرقم الوطني موجود مسبقا',
    ]);

    $data = $request->all();

    // أهم سطر - بصلح مشكلة التاريخ الفاضي
    foreach(['birth_date','date_of_death','id_issue_date','id_expiry_date','hire_date'] as $f){
        if(empty($data[$f])) $data[$f] = null;
    }

    $employee->update($data);

    return redirect('/employees')->with('success','تم التعديل بنجاح');
}



    public function destroy($id){ Employee::findOrFail($id)->delete(); return back(); }
    public function relatives($id){ 
 $employee = Employee::findOrFail($id); 
 $relatives = \App\Models\EmployeeRelative::where('employee_id',$id)->get();
 return view('employees.relatives', compact('employee','relatives')); 
}
public function storeRelative(Request $r,$id){
 \App\Models\EmployeeRelative::create(array_merge($r->all(),['employee_id'=>$id,'is_dependent'=>$r->has('is_dependent')]));
 return back()->with('success','تمت إضافة القريب');
}

}
