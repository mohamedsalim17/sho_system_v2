<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class ImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);

        Schema::dropIfExists('employees_1');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('employees')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $file = $request->file('file')->getPathname();
        $spreadsheet = IOFactory::load($file);
        $rows = $spreadsheet->getActiveSheet()->toArray();
        array_shift($rows);

        foreach ($rows as $index => $row) {
            if (empty($row[2])) continue;

            try {
                DB::table('employees')->insert([
                    'employee_no' => isset($row[0])? substr((string)$row[0],0,50) : null,
                    'national_id' => isset($row[4])? (string)$row[4] : null,
                    'name' => (string)$row[2],
                    'phone' => isset($row[10])? (string)$row[10] : null,
                    'birth_date' => $this->parseDate($row[3]),
                    'death_date' => $this->parseDate($row[6]),
                    'death_place' => isset($row[7])? (string)$row[7] : null,
                    'marital_status'=> 'single',
                    'job_title' => isset($row[5])? (string)$row[5] : null,
                    'department' => isset($row[8])? (string)$row[8] : null,
                    'state' => isset($row[8])? (string)$row[8] : null,
                    'city' => isset($row[9])? (string)$row[9] : null,
                    'salary' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (\Exception $e) {
                // لو صف بايظ وريهو رقم الصف والسبب بدل 500 عامة
                return back()->withErrors("خطأ في الصف رقم ".($index+2).": ".$e->getMessage()." | البيانات: ".json_encode($row, JSON_UNESCAPED_UNICODE));
            }
        }

        return back()->with('success', 'تم الاستيراد بنجاح');
    }

    private function parseDate($value)
    {
        if (empty($value) || $value == '-') return null;
        try {
            if (is_numeric($value)) {
                // تاريخ اكسل رقمي
                if ($value > 0 && $value < 100000) {
                    return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
                }
            }
            // حاول تقرا التاريخ العربي
            $value = trim(str_replace(['،', 'ـ'], '', $value));
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null; // لو ما قدر يقراهو خليهو null وما يوقف الاستيراد
        }
    }
}
