<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Support\Facades\Schema;

class ReportController extends Controller
{
    public function index(){ return view('reports.index'); }

    // ده الأساسي - ديناميك يجيب أي حقل جديد
    public function builder(Request $request){
        $cols = array_diff(Schema::getColumnListing('employees'), ['id','created_at','updated_at']);
        $labels = ['employee_no'=>'رقم وظيفي','national_id'=>'رقم وطني','name'=>'الاسم','phone'=>'تلفون','birth_date'=>'ميلاد','death_date'=>'وفاة','death_place'=>'مكان وفاة','marital_status'=>'حالة اجتماعية','job_title'=>'مسمى','department'=>'قسم','salary'=>'راتب','hire_date'=>'تعيين','state'=>'ولاية','city'=>'مدينة','neighborhood'=>'حي','street'=>'شارع','email'=>'بريد','gender'=>'جنس','qualification'=>'مؤهل','experience'=>'خبرة','status'=>'حالة','notes'=>'ملاحظات'];
        $allColumns = []; foreach($cols as $c){ $allColumns[$c] = $labels[$c] ?? $c; }
        $q = Employee::query();
        foreach($allColumns as $c=>$l){ if($request->filled($c)) $q->where($c,'like','%'.$request->$c.'%'); }
        if($request->filled('from_date') && $request->filled('to_date')) $q->whereBetween('hire_date',[$request->from_date,$request->to_date]);
        $employees = $q->get();
        $selectedColumns = $request->input('columns', array_keys($allColumns));
        return view('reports.builder', compact('allColumns','employees','selectedColumns'));
    }

    public function filter(Request $request){
        $q = Employee::query();
        foreach(['department','state','city','job_title'] as $f){ if($request->filled($f)) $q->where($f,'like','%'.$request->$f.'%'); }
        $employees = $q->get();
        return view('reports.filter', compact('employees'));
    }

    public function custom(Request $request){ return $this->builder($request); }
    public function general(){ $employees = Employee::all(); return view('reports.general', compact('employees')); }
    public function customers(){ return view('reports.customers',['data'=>Customer::all()]); }
    public function employees(){ return view('reports.employees',['data'=>Employee::all()]); }
    public function products(){ return view('reports.products',['data'=>[]]); }
    public function sales(){ return view('reports.sales',['data'=>[]]); }
}
