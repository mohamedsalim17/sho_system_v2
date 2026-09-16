<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    // بعرض صفحة الفورم
    public function create()
    {
        return view('employees.create');
    }

    // بحفظ البيانات
    public function store(Request $request)
    {
        // 1. شيل الاقارب برا
        $data = $request->except('relatives');

        // 2. احفظ الموظف
        $employee = Employee::create($data);

        // 3. احفظ الاقارب
        if($request->has('relatives')){
            foreach($request->relatives as $relative){
                if(!empty($relative['name'])){ 
                    $employee->relatives()->create($relative);
                }
            }
        }

        return redirect()->route('employees.create')->with('success', 'تم حفظ الموظف بنجاح');
    }

    // لعرض كل الموظفين
    public function index()
    {
        $employees = Employee::with('relatives')->latest()->get();
        return view('employees.index', compact('employees'));
    }
}
