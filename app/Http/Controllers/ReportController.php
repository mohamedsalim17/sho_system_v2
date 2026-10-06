<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\Employee;

class ReportController extends Controller
{
    // صفحة السلايد الرئيسية
    public function index(){ 
        return view('reports.index'); 
    }

    // 1- تقرير عام + فترة + بحث
    public function general(Request $request){
        $query = Employee::query();

        // بحث عام
        if($request->filled('search')){
            $query->where('name','LIKE',"%{$request->search}%")
                  ->orWhere('employee_no','LIKE',"%{$request->search}%");
        }

        // فلتر الفترة بتاريخ الاستشهاد
        if($request->filled('from_date')){
            $query->where('death_date','>=',$request->from_date);
        }
        if($request->filled('to_date')){
            $query->where('death_date','<=',$request->to_date);
        }

        $employees = $query->get();
        return view('reports.general', compact('employees'));
    }

    // 2- تقرير مخصص - تختار الحقول + بحث
    public function custom(Request $request){
        $allColumns = array_diff(Schema::getColumnListing('employees'), ['id','created_at','updated_at']);
        $selected = $request->get('fields', ['employee_no','name','department','state','death_date']);
        
        $query = Employee::query();
        if($request->filled('search')){
            $query->where('name','LIKE',"%{$request->search}%");
        }
        // فترة
        if($request->filled('from_date')) $query->where('death_date','>=',$request->from_date);
        if($request->filled('to_date')) $query->where('death_date','<=',$request->to_date);

        $employees = $query->get();
        return view('reports.custom', compact('allColumns','selected','employees'));
    }

    // 3- تقرير مفلتر + بحث متقدم لكل عمود + فترة
    public function builder(Request $request){
        $allColumns = array_diff(Schema::getColumnListing('employees'), ['id','created_at','updated_at']);
        $selectedColumns = $request->get('columns', ['employee_no','name','department','state','death_place','death_date']);

        $query = Employee::query();

        // بحث سريع
        if($request->filled('search')){
            $query->where('name','LIKE',"%{$request->search}%");
        }

        // فلترة لكل عمود
        foreach($request->except(['columns','fields','search','page','from_date','to_date']) as $key=>$value){
            if($value!==null && $value!=='' && in_array($key,$allColumns)){
                $query->where($key,'LIKE',"%{$value}%");
            }
        }

        // فلترة الفترة
        if($request->filled('from_date')) $query->where('death_date','>=',$request->from_date);
        if($request->filled('to_date')) $query->where('death_date','<=',$request->to_date);

        $employees = $query->get();
        return view('reports.builder', compact('allColumns','selectedColumns','employees'));
    }

    // تصدير اكسل (بستخدم نفس الفلترة)
    public function export(Request $request){
        $allColumns = array_diff(Schema::getColumnListing('employees'), ['id','created_at','updated_at']);
        $selectedColumns = $request->get('columns', $request->get('fields', ['employee_no','name','department','state']));
        $query = Employee::query();
        foreach($request->except(['columns','fields','search','page','from_date','to_date']) as $key=>$value){
            if($value!==null && $value!=='' && in_array($key,$allColumns)){
                $query->where($key,'LIKE',"%{$value}%");
            }
        }
        if($request->filled('from_date')) $query->where('death_date','>=',$request->from_date);
        if($request->filled('to_date')) $query->where('death_date','<=',$request->to_date);

        $employees = $query->get();
        // لو عندك export view استخدمو، لو لا برجع builder
        if(view()->exists('reports.export')){
            return view('reports.export', compact('employees','selectedColumns'));
        }
        return view('reports.builder', compact('allColumns','selectedColumns','employees'));
    }
}
