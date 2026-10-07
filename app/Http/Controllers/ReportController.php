<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\Employee;

class ReportController extends Controller
{
    public function index(){
        return view('reports.index');
    }

    // تقرير عام + بحث + تاريخ
    public function general(Request $request){
        $query = Employee::query();
        if($request->filled('search')){
            $query->where('name','LIKE',"%{$request->search}%")
                  ->orWhere('employee_no','LIKE',"%{$request->search}%");
        }
        if($request->filled('from_date')) $query->where('death_date','>=',$request->from_date);
        if($request->filled('to_date')) $query->where('death_date','<=',$request->to_date);

        $employees = $query->get();
        return view('reports.general', compact('employees'));
    }

    // تقرير مخصص - اختيار أعمدة
    public function custom(Request $request){
        $allColumns = array_diff(Schema::getColumnListing('employees'), ['id','created_at','updated_at']);
        $selected = $request->get('fields', ['employee_no','name','department','status']);
        
        $query = Employee::query();
        if($request->filled('search')) $query->where('name','LIKE',"%{$request->search}%");
        if($request->filled('from_date')) $query->where('death_date','>=',$request->from_date);
        if($request->filled('to_date')) $query->where('death_date','<=',$request->to_date);
        
        $employees = $query->get();
        return view('reports.custom', compact('allColumns','selected','employees'));
    }

    // تقرير بناء + فلتر تفصيلي
    public function builder(Request $request){
        $allColumns = array_diff(Schema::getColumnListing('employees'), ['id','created_at','updated_at']);
        $selectedColumns = $request->get('columns', ['employee_no','name','department','status']);
        
        $query = Employee::query();
        if($request->filled('search')) $query->where('name','LIKE',"%{$request->search}%");

        foreach($request->except(['columns','fields','search','page','from_date','to_date']) as $key=>$value){
            if($value!==null && $value!=='' && in_array($key,$allColumns)){
                $query->where($key,'LIKE',"%{$value}%");
            }
        }
        if($request->filled('from_date')) $query->where('death_date','>=',$request->from_date);
        if($request->filled('to_date')) $query->where('death_date','<=',$request->to_date);

        $employees = $query->get();
        return view('reports.builder', compact('allColumns','selectedColumns','employees'));
    }

    // تصدير للطباعة
    public function export(Request $request){
        return $this->builder($request); // نفس منطق builder بس view مختلف
    }
    public function excel(Request $request){
        $allColumns = array_diff(Schema::getColumnListing('employees'), ['id','created_at','updated_at']);
        $selectedColumns = $request->get('columns', $request->get('fields', ['employee_no','name']));
        $query = Employee::query();
        if($request->filled('from_date')) $query->where('death_date','>=',$request->from_date);
        if($request->filled('to_date')) $query->where('death_date','<=',$request->to_date);
        $employees = $query->get();
        return view('reports.excel', compact('employees','selectedColumns'));
    }
}
