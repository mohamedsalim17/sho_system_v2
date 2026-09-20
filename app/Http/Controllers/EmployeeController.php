<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function create(){
        return view('employees.create');
    }

    public function store(Request $request){

        // تحويل الحالة من عربي لانجليزي عشان الجدول
        $marital = 'single';
        if(in_array($request->marital_status, ['متزوج','married'])){
            $marital = 'married';
        }

        \DB::table('employees')->insert([
            'employee_no'    => $request->employee_no, // لازم
            'national_id'    => $request->national_id,
            'name'           => $request->name, // لازم
            'phone'          => $request->phone,
            'birth_date'     => $request->birth_date ?: null,
            'hire_date'      => $request->hire_date ?: null,
            'death_date'     => $request->death_date ?: null,
            'marital_status' => $marital, // هنا كان الخلل
            'job_title'      => $request->job_title,
            'department'     => $request->department,
            'salary'         => $request->salary ?: null,
            'state'          => $request->state ?? null,
            'city'           => $request->city ?? null,
            'neighborhood'   => $request->neighborhood ?? null,
            'street'         => $request->street ?? null,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        return back()->with('success','تم حفظ الموظف بنجاح');
    }
}
