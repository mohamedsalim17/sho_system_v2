<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Schema;

class ReportController extends Controller
{
    public function index(Request $request){
        $q = Employee::query();
        if($request->address) $q->where('address','like','%'.$request->address.'%');
        if($request->job_title) $q->where('job_title','like','%'.$request->job_title.'%');
        if($request->department) $q->where('department','like','%'.$request->department.'%');
        if($request->search) $q->where('name','like','%'.$request->search.'%');
        $employees = $q->latest()->get();
        $columns = Schema::getColumnListing('employees');
        return view('reports.index', compact('employees','columns'));
    }

    public function excel(Request $request){
        $q = Employee::query();
        if($request->address) $q->where('address','like','%'.$request->address.'%');
        if($request->job_title) $q->where('job_title','like','%'.$request->job_title.'%');
        if($request->department) $q->where('department','like','%'.$request->department.'%');
        if($request->search) $q->where('name','like','%'.$request->search.'%');
        $employees = $q->get();
        $columns = Schema::getColumnListing('employees');

        // الترجمة للاكسل
        $labels = [
            'id'=>'م','employee_no'=>'الرقم الوظيفي','national_id'=>'الرقم الوطني','name'=>'الاسم',
            'phone'=>'الهاتف','birth_date'=>'تاريخ الميلاد','death_date'=>'تاريخ الوفاة','death_place'=>'مكان الوفاة',
            'marital_status'=>'الحالة الاجتماعية','job_title'=>'الوظيفة','department'=>'القسم','salary'=>'المرتب',
            'hire_date'=>'تاريخ التعيين','state'=>'الولاية','city'=>'المدينة','neighborhood'=>'الحي','street'=>'الشارع',
            'created_at'=>'تاريخ الاضافة','updated_at'=>'اخر تحديث','address'=>'السكن'
        ];
        $marital = ['single'=>'أعزب','married'=>'متزوج','divorced'=>'مطلق','widowed'=>'أرمل'];

        $filename = "التقرير_الشامل_".date('Y-m-d').".csv";
        $headers = ["Content-type"=>"text/csv; charset=UTF-8","Content-Disposition"=>"attachment; filename=$filename"];
        
        $callback = function() use ($employees, $columns, $labels, $marital) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // عشان العربي يظهر في الاكسل
            
            // العناوين
            $headerRow = ['#'];
            foreach($columns as $col){
                if($col!='id') $headerRow[] = $labels[$col] ?? $col;
            }
            fputcsv($file, $headerRow);

            // البيانات
            foreach($employees as $i=>$e){
                $row = [$i+1];
                foreach($columns as $col){
                    if($col=='id') continue;
                    $val = $e->$col;
                    if($col=='marital_status') $val = $marital[$val] ?? $val;
                    $row[] = $val;
                }
                fputcsv($file, $row);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
    public function custom(Request $request){
    $allColumns = Schema::getColumnListing('employees');
    $labels = [
        'employee_no'=>'الرقم الوظيفي','national_id'=>'الرقم الوطني','name'=>'الاسم',
        'phone'=>'الهاتف','birth_date'=>'تاريخ الميلاد','death_date'=>'تاريخ الوفاة','death_place'=>'مكان الوفاة',
        'marital_status'=>'الحالة الاجتماعية','job_title'=>'الوظيفة','department'=>'القسم','salary'=>'المرتب',
        'hire_date'=>'تاريخ التعيين','state'=>'الولاية','city'=>'المدينة','neighborhood'=>'الحي','street'=>'الشارع',
        'address'=>'السكن','created_at'=>'تاريخ الاضافة'
    ];
    // الحقول الافتراضية لو ما اختار
    $selected = $request->input('fields', ['name','phone','job_title','department','state']);
    
    $q = Employee::query();
    if($request->search) $q->where('name','like','%'.$request->search.'%');
    $employees = $q->latest()->get();

    return view('reports.custom', compact('allColumns','labels','selected','employees'));
}

}
