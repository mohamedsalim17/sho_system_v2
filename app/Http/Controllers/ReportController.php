<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Schema;

class ReportController extends Controller
{
   public function builder(Request $request){
   $data = $this->getBuilderData($request);
   return view('reports.builder', $data);
}
    public function builder(Request $request)
    {
        $labels = [
            'employee_no'=>'الرقم الوظيفي',
            'national_id'=>'الرقم الوطني',
            'name'=>'الاسم',
            'phone'=>'الهاتف',
            'birth_date'=>'تاريخ الميلاد',
            'death_date'=>'تاريخ الوفاة',
            'death_place'=>'مكان الوفاة',
            'marital_status'=>'الحالة الاجتماعية',
            'job_title'=>'المسمى الوظيفي',
            'department'=>'القسم',
            'salary'=>'الراتب',
            'hire_date'=>'تاريخ التعيين',
            'state'=>'الولاية',
            'city'=>'المدينة',
            'neighborhood'=>'الحي',
            'street'=>'الشارع',
        ];

        $realCols = Schema::getColumnListing('employees');
        $allColumns = [];
        foreach($labels as $col=>$lab){
            if(in_array($col, $realCols)) $allColumns[$col]=$lab;
        }

        $q = Employee::query();
        foreach($allColumns as $col=>$lab){
            if($request->filled($col)){
                if(in_array($col, ['birth_date','death_date','hire_date'])){
                    $q->whereDate($col, $request->$col);
                }else{
                    $q->where($col, 'like', '%'.$request->$col.'%');
                }
            }
        }
        if($request->filled('from_date') && $request->filled('to_date')){
            $q->whereBetween('hire_date', [$request->from_date, $request->to_date]);
        }

        $employees = $q->get();
        $selectedColumns = $request->input('columns', array_keys($allColumns));

        $filterData = [];
        foreach(['state','city','department','job_title','marital_status'] as $f){
            if(in_array($f, $realCols)){
                $filterData[$f] = Employee::select($f)->distinct()->whereNotNull($f)->pluck($f);
            }
        }

        return view('reports.builder', compact('allColumns','employees','selectedColumns','filterData'));
    }

    public function filter(Request $request){ return $this->builder($request); }
    public function custom(Request $request){ return $this->builder($request); }
    public function general(){ return view('reports.general'); }
    public function customers(){ return view('reports.customers'); }
    public function employees(){ return view('reports.employees', ['employees'=>Employee::all()]); }
    public function products(){ return view('reports.products'); }
    public function sales(){ return view('reports.sales'); }
          private function getBuilderData($request){
        // نفس كود الـ builder القديم بس بيرجع داتا فقط
        $allColumns = [
            'employee_id'=>'الرقم الوظيفي','national_id'=>'الرقم الوطني','name'=>'الاسم','phone'=>'الهاتف',
            'department'=>'القسم','salary'=>'الراتب','state'=>'الولاية','city'=>'المدينة',
            'hire_date'=>'تاريخ التعيين','birth_date'=>'تاريخ الميلاد','marital_status'=>'الحالة الاجتماعية',
            'address'=>'الشارع','job_title'=>'المسمى الوظيفي','birth_place'=>'مكان الولادة','birth_date2'=>'تاريخ الوفاة'
        ];
        // فلترة حقيقية حسب القيمة المختارة
        $query = \App\Models\Employee::query();
        foreach($allColumns as $col=>$lab){
            if($request->filled($col)){
                $query->where($col, $request->$col);
            }
        }
        $employees = $query->get();
        $selectedColumns = $request->input('columns', array_keys($allColumns));
        
        $filterData = [];
        foreach(['department','state','city','marital_status','job_title'] as $f){
            $filterData[$f] = \App\Models\Employee::whereNotNull($f)->distinct()->pluck($f);
        }
        return compact('allColumns','employees','selectedColumns','filterData');
    }

    public function exportExcel(Request $request)
    {
        $data = $this->getBuilderData($request);
        $employees = $data['employees'];
        $selectedColumns = $data['selectedColumns'];
        $allColumns = $data['allColumns'];
        $filename = "employees_".date('Y-m-d').".csv";
        $headers = ["Content-type"=>"text/csv; charset=UTF-8","Content-Disposition"=>"attachment; filename=$filename"];
        $callback = function() use ($employees,$selectedColumns,$allColumns){
            $file = fopen('php://output','w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, array_map(fn($c)=>$allColumns[$c], $selectedColumns));
            foreach($employees as $e){ fputcsv($file, array_map(fn($c)=>$e->$c, $selectedColumns)); }
            fclose($file);
        };
        return response()->stream($callback,200,$headers);
    }

    public function exportPdf(Request $request)
    {
        $data = $this->getBuilderData($request);
        return view('reports.pdf', $data);
    }


}
