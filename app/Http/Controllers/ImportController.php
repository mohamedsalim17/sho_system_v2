<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use PhpOffice\PhpSpreadsheet\Reader\Exception as SpreadsheetReaderException;

class ImportController extends Controller
{
    public function create()
    {
        return view('employees.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'],
        ]);

        try {
            $rows = IOFactory::load($request->file('file')->getPathname())
                ->getActiveSheet()
                ->toArray();
        } catch (SpreadsheetReaderException $exception) {
            throw ValidationException::withMessages([
                'file' => 'تعذر قراءة الملف. تحقق من سلامة ملف Excel أو CSV.',
            ]);
        }

        array_shift($rows);
        $imported = 0;

        DB::transaction(function () use ($rows, &$imported) {
            foreach ($rows as $index => $row) {
                if (trim((string) ($row[2] ?? '')) === '') {
                    continue;
                }

                $employeeNo = trim((string) ($row[0] ?? ''));
                if ($employeeNo === '') {
                    $employeeNo = 'IMP-' . str()->uuid();
                }

                try {
                    $data = [
                        'employee_no' => mb_substr($employeeNo, 0, 50),
                        'national_id' => $this->cellText($row[4] ?? null),
                        'name' => trim((string) $row[2]),
                        'phone' => $this->cellText($row[10] ?? null),
                        'birth_date' => $this->parseDate($row[3] ?? null),
                        'death_date' => $this->parseDate($row[6] ?? null),
                        'death_place' => $this->cellText($row[7] ?? null),
                        'marital_status' => 'single',
                        'job_title' => $this->cellText($row[5] ?? null),
                        'department' => $this->cellText($row[8] ?? null),
                        'state' => $this->cellText($row[8] ?? null),
                        'city' => $this->cellText($row[9] ?? null),
                        'salary' => 0,
                    ];
                } catch (\InvalidArgumentException $exception) {
                    throw ValidationException::withMessages([
                        'file' => 'التاريخ غير صالح في الصف رقم ' . ($index + 2) . '.',
                    ]);
                }

                $validator = Validator::make($data, [
                    'employee_no' => ['required', 'string', 'max:50', 'unique:employees,employee_no'],
                    'national_id' => ['nullable', 'string', 'max:255', 'unique:employees,national_id'],
                    'name' => ['required', 'string', 'max:255'],
                    'phone' => ['nullable', 'string', 'max:30'],
                    'birth_date' => ['nullable', 'date'],
                    'death_date' => ['nullable', 'date'],
                    'death_place' => ['nullable', 'string', 'max:255'],
                    'marital_status' => ['required', 'in:single,married'],
                    'job_title' => ['nullable', 'string', 'max:255'],
                    'department' => ['nullable', 'string', 'max:255'],
                    'state' => ['nullable', 'string', 'max:255'],
                    'city' => ['nullable', 'string', 'max:255'],
                    'salary' => ['nullable', 'numeric', 'min:0'],
                ]);

                if ($validator->fails()) {
                    throw ValidationException::withMessages([
                        'file' => 'بيانات غير صالحة أو رقم وظيفي مكرر في الصف رقم ' . ($index + 2) . '.',
                    ]);
                }

                Employee::create($validator->validated());
                $imported++;
            }
        });

        return redirect()->route('employees.index')
            ->with('success', 'تم استيراد ' . $imported . ' موظف دون حذف البيانات الموجودة.');
    }

    private function cellText($value): ?string
    {
        if ($value === null || trim((string) $value) === '' || trim((string) $value) === '-') {
            return null;
        }

        return trim((string) $value);
    }

    private function parseDate($value): ?string
    {
        if ($value === null || trim((string) $value) === '' || trim((string) $value) === '-') {
            return null;
        }

        try {
            if (is_numeric($value) && $value > 0 && $value < 100000) {
                return ExcelDate::excelToDateTimeObject($value)->format('Y-m-d');
            }

            return Carbon::parse(trim(str_replace(['،', 'ـ'], '', (string) $value)))->format('Y-m-d');
        } catch (\Throwable $exception) {
            throw new \InvalidArgumentException('Invalid employee date.', 0, $exception);
        }
    }
}
