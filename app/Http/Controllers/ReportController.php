<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class ReportController extends Controller
{
    private const EMPLOYEE_COLUMNS = [
        'employee_no' => 'الرقم الوظيفي',
        'national_id' => 'الرقم الوطني',
        'name' => 'الاسم',
        'phone' => 'الهاتف',
        'birth_date' => 'تاريخ الميلاد',
        'death_date' => 'تاريخ الوفاة',
        'death_place' => 'مكان الوفاة',
        'marital_status' => 'الحالة الاجتماعية',
        'job_title' => 'المسمى الوظيفي',
        'department' => 'القسم',
        'salary' => 'الراتب',
        'hire_date' => 'تاريخ التعيين',
        'state' => 'الولاية',
        'city' => 'المدينة',
        'neighborhood' => 'الحي',
        'street' => 'الشارع',
    ];

    public function index()
    {
        return view('reports.index', [
            'employeeCount' => $this->tableCount('employees'),
            'customerCount' => $this->tableCount('customers'),
            'productCount' => $this->tableCount('products'),
            'invoiceCount' => $this->tableCount('invoices'),
            'salesTotal' => Schema::hasTable('invoices') && Schema::hasColumn('invoices', 'total_amount')
                ? (float) Invoice::sum('total_amount')
                : 0,
        ]);
    }

    public function builder(Request $request)
    {
        $source = $this->reportSource($request);
        $columns = $this->availableReportColumns($source);
        $this->validateBuilderFilters($request, $columns);

        $query = $this->reportQuery($source, $columns);
        $this->applyReportFilters($query, $request, $source, $columns);

        $selectedColumns = $this->selectedColumns($request, $columns);

        $filterData = [];
        foreach (['state', 'city', 'department', 'job_title', 'marital_status', 'gender', 'education_level', 'job'] as $field) {
            if (isset($columns[$field])) {
                $databaseColumn = $this->reportDatabaseColumn($source, $field);
                $filterData[$field] = $query->getConnection()
                    ->table($source)
                    ->whereNotNull($databaseColumn)
                    ->where($databaseColumn, '<>', '')
                    ->distinct()
                    ->orderBy($databaseColumn)
                    ->pluck($databaseColumn);
            }
        }

        return view('reports.builder', [
            'allColumns' => $columns,
            'employees' => $query->orderByDesc('id')->paginate(50)->withQueryString(),
            'selectedColumns' => $selectedColumns,
            'filterData' => $filterData,
            'reportSource' => $source,
        ]);
    }

    public function filter(Request $request)
    {
        $columns = $this->availableEmployeeColumns();
        $filters = $request->input('filters', []);
        if ($filters === [] && $request->filled('field')) {
            $filters = [[
                'field' => $request->input('field'),
                'value' => $request->input('value'),
            ]];
        }

        $request->validate([
            'filters' => ['nullable', 'array', 'max:4'],
            'filters.*' => ['array'],
            'filters.*.field' => ['nullable', Rule::in(array_keys($columns))],
            'filters.*.value' => ['nullable', 'string', 'max:255'],
        ]);

        $query = Employee::query();
        $displayFilters = array_fill(0, 4, ['field' => '', 'value' => '']);
        foreach (array_slice($filters, 0, 4) as $index => $filter) {
            $field = $filter['field'] ?? '';
            $value = trim((string) ($filter['value'] ?? ''));
            $displayFilters[$index] = ['field' => $field, 'value' => $value];

            if ($field === '' || $value === '') {
                continue;
            }

            if ($field === 'salary') {
                $request->validate(["filters.{$index}.value" => ['numeric']]);
            } elseif (str_ends_with($field, '_date')) {
                $request->validate(["filters.{$index}.value" => ['date']]);
            }

            if (in_array($field, ['birth_date', 'death_date', 'hire_date'], true)) {
                $query->whereDate($field, $value);
            } elseif ($field === 'salary') {
                $query->where($field, $value);
            } else {
                $query->where($field, 'like', '%'.$value.'%');
            }

        }

        return view('reports.filter', [
            'employees' => $query->latest('id')->paginate(25)->withQueryString(),
            'allColumns' => $columns,
            'filters' => $displayFilters,
        ]);
    }

    public function custom(Request $request)
    {
        $request->validate([
            'customer_id' => ['nullable', 'integer', Rule::exists('customers', 'id')],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
        ]);
        $query = $this->salesQuery($request);

        return view('reports.custom', [
            'results' => $query->latest('id')->paginate(25)->withQueryString(),
            'customers' => Customer::query()->orderBy('name')->get(['id', 'name', 'phone']),
            'total' => (float) (clone $query)->sum('total_amount'),
        ]);
    }

    public function general(Request $request)
    {
        $columns = $this->availableEmployeeColumns();
        $this->validateBuilderFilters($request, $columns);
        $query = Employee::query();
        $this->applyEmployeeFilters($query, $request, $columns);
        $this->applyHireDateRange($query, $request);

        return view('reports.general', [
            'employees' => $query->latest('id')->paginate(25)->withQueryString(),
        ]);
    }

    public function customers(Request $request)
    {
        $request->validate(['search' => ['nullable', 'string', 'max:255']]);
        $query = Customer::query();
        $searchable = $this->availableColumns('customers', [
            'name', 'phone', 'national_id', 'city', 'state', 'date_of_death', 'place_of_death',
        ]);

        if ($request->filled('search') && $searchable) {
            $search = $request->string('search')->trim()->toString();
            $query->where(function (Builder $builder) use ($searchable, $search) {
                foreach ($searchable as $index => $column) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $builder->{$method}($column, 'like', '%'.$search.'%');
                }
            });
        }

        $customers = $query
            ->withCount('invoices')
            ->latest('id')
            ->paginate(25)
            ->withQueryString();

        return view('reports.customers', compact('customers'));
    }

    public function employees(Request $request)
    {
        $request->validate(['search' => ['nullable', 'string', 'max:255']]);
        $columns = $this->availableEmployeeColumns();
        $query = Employee::query();
        $this->validateBuilderFilters($request, $columns);

        if ($request->filled('search')) {
            $searchable = array_values(array_intersect(
                ['name', 'employee_no', 'national_id', 'phone', 'department', 'job_title'],
                array_keys($columns)
            ));
            $search = $request->string('search')->trim()->toString();
            $query->where(function (Builder $builder) use ($searchable, $search) {
                foreach ($searchable as $index => $column) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $builder->{$method}($column, 'like', '%'.$search.'%');
                }
            });
        }

        $employees = $query->withCount('relatives')->latest('id')->paginate(25)->withQueryString();

        return view('reports.employees', compact('employees'));
    }

    public function products(Request $request)
    {
        $request->validate(['search' => ['nullable', 'string', 'max:255']]);
        $query = Product::query();
        $searchable = $this->availableColumns('products', ['name', 'barcode', 'category']);

        if ($request->filled('search') && $searchable) {
            $search = $request->string('search')->trim()->toString();
            $query->where(function (Builder $builder) use ($searchable, $search) {
                foreach ($searchable as $index => $column) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $builder->{$method}($column, 'like', '%'.$search.'%');
                }
            });
        }

        $products = $query->latest('id')->paginate(25)->withQueryString();
        $productCount = $this->tableCount('products');
        $lowStockCount = Schema::hasTable('products') && Schema::hasColumn('products', 'quantity')
            ? Product::where('quantity', '<=', 5)->count()
            : 0;
        $inventoryValue = 0;
        if (Schema::hasTable('products') && Schema::hasColumn('products', 'quantity')) {
            $costColumn = Schema::hasColumn('products', 'buy_price') ? 'buy_price' : 'price';
            if (Schema::hasColumn('products', $costColumn)) {
                $inventoryValue = (float) Product::sum(DB::raw('quantity * '.$costColumn));
            }
        }

        return view('reports.products', compact('products', 'productCount', 'lowStockCount', 'inventoryValue'));
    }

    public function sales(Request $request)
    {
        $request->validate([
            'customer_id' => ['nullable', 'integer'],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
        ]);

        $query = $this->salesQuery($request);

        $totalSales = Schema::hasColumn('invoices', 'total_amount')
            ? (float) (clone $query)->sum('total_amount')
            : 0;
        $invoiceCount = (clone $query)->count();
        $invoices = $query->latest('id')->paginate(25)->withQueryString();
        $customers = Customer::query()->orderBy('name')->get(['id', 'name']);

        return view('reports.sales', compact('invoices', 'customers', 'totalSales', 'invoiceCount'));
    }

    public function exportSalesCsv(Request $request)
    {
        $request->validate([
            'customer_id' => ['nullable', 'integer'],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
        ]);
        $invoices = $this->salesQuery($request)->latest('id')->get();
        $filename = 'sales_'.now()->format('Y-m-d').'.csv';

        return response()->streamDownload(function () use ($invoices) {
            $file = fopen('php://output', 'w');
            if ($file === false) {
                throw new \RuntimeException('تعذر إنشاء ملف التقرير.');
            }

            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, ['رقم الفاتورة', 'العميل', 'تاريخ الفاتورة', 'الإجمالي']);
            foreach ($invoices as $invoice) {
                fputcsv($file, [
                    $invoice->id,
                    $this->safeCsvValue($invoice->customer->name ?? 'بدون عميل'),
                    $invoice->invoice_date,
                    number_format((float) $invoice->total_amount, 2, '.', ''),
                ]);
            }
            fclose($file);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function exportExcel(Request $request)
    {
        $data = $this->getBuilderData($request);
        $filename = $data['source'].'_'.now()->format('Y-m-d').'.csv';

        return response()->streamDownload(function () use ($data) {
            $file = fopen('php://output', 'w');
            if ($file === false) {
                throw new \RuntimeException('تعذر إنشاء ملف التقرير.');
            }

            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, array_map(fn ($column) => $data['allColumns'][$column], $data['selectedColumns']));
            foreach ($data['employees'] as $employee) {
                fputcsv($file, array_map(
                    fn ($column) => $this->safeCsvValue($employee->{$column}),
                    $data['selectedColumns']
                ));
            }
            fclose($file);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function exportPdf(Request $request)
    {
        return view('reports.pdf', $this->getBuilderData($request));
    }

    private function getBuilderData(Request $request): array
    {
        $source = $this->reportSource($request);
        $columns = $this->availableReportColumns($source);
        $this->validateBuilderFilters($request, $columns);
        $query = $this->reportQuery($source, $columns);
        $this->applyReportFilters($query, $request, $source, $columns);

        $selectedColumns = $this->selectedColumns($request, $columns);
        $employees = $query->orderByDesc('id')->get();

        return [
            'allColumns' => $columns,
            'employees' => $employees,
            'selectedColumns' => $selectedColumns,
            'source' => $source,
        ];
    }

    private function reportSource(Request $request): string
    {
        $request->validate([
            'source' => ['nullable', Rule::in(['employees', 'customers'])],
        ]);

        return $request->input('source') ?: 'employees';
    }

    private function availableReportColumns(string $source): array
    {
        if ($source === 'customers') {
            $columns = [
                'name' => 'الاسم',
                'national_id' => 'الرقم الوطني',
                'phone' => 'الهاتف',
                'gender' => 'النوع',
                'birth_date' => 'تاريخ الميلاد',
                'death_date' => 'تاريخ الوفاة',
                'death_place' => 'مكان الوفاة',
                'state' => 'الولاية',
                'city' => 'المدينة',
                'education_level' => 'المستوى التعليمي',
                'job' => 'الوظيفة',
                'address' => 'العنوان',
            ];
            $databaseColumns = [
                'death_date' => 'date_of_death',
                'death_place' => 'place_of_death',
            ];

            return array_filter($columns, fn ($label, $column) => Schema::hasColumn(
                'customers',
                $databaseColumns[$column] ?? $column
            ), ARRAY_FILTER_USE_BOTH);
        }

        return $this->availableEmployeeColumns();
    }

    private function reportDatabaseColumn(string $source, string $column): string
    {
        if ($source === 'customers') {
            return [
                'death_date' => 'date_of_death',
                'death_place' => 'place_of_death',
            ][$column] ?? $column;
        }

        return $column;
    }

    private function reportQuery(string $source, array $columns): QueryBuilder
    {
        $query = DB::table($source)->select('id');
        foreach ($columns as $column => $label) {
            $databaseColumn = $this->reportDatabaseColumn($source, $column);
            $query->addSelect(DB::raw($databaseColumn.' as '.$column));
        }

        return $query;
    }

    private function applyReportFilters(QueryBuilder $query, Request $request, string $source, array $columns): void
    {
        if ($request->filled('search')) {
            $searchable = array_values(array_intersect(
                ['name', 'employee_no', 'national_id', 'phone', 'department', 'job_title', 'death_date', 'death_place', 'city', 'state'],
                array_keys($columns)
            ));
            $search = $request->string('search')->trim()->toString();
            $query->where(function (QueryBuilder $builder) use ($searchable, $search, $source) {
                foreach ($searchable as $index => $column) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $builder->{$method}($this->reportDatabaseColumn($source, $column), 'like', '%'.$search.'%');
                }
            });
        }

        foreach ($columns as $column => $label) {
            if (! $request->filled($column)) {
                continue;
            }
            $databaseColumn = $this->reportDatabaseColumn($source, $column);
            if (in_array($column, ['birth_date', 'death_date', 'hire_date'], true)) {
                $query->whereDate($databaseColumn, $request->input($column));
            } elseif ($column === 'salary') {
                $query->where($databaseColumn, $request->input($column));
            } else {
                $query->where($databaseColumn, 'like', '%'.$request->input($column).'%');
            }
        }

        if ($source === 'employees' && isset($columns['hire_date'])) {
            if ($request->filled('from_date')) {
                $query->whereDate('hire_date', '>=', $request->input('from_date'));
            }
            if ($request->filled('to_date')) {
                $query->whereDate('hire_date', '<=', $request->input('to_date'));
            }
        }
    }

    private function availableEmployeeColumns(): array
    {
        $available = array_flip($this->availableColumns('employees', array_keys(self::EMPLOYEE_COLUMNS)));

        return array_intersect_key(self::EMPLOYEE_COLUMNS, $available);
    }

    private function selectedColumns(Request $request, array $columns): array
    {
        $selected = $request->input('columns', array_keys($columns));
        if (! is_array($selected)) {
            return [];
        }

        return array_values(array_filter(
            $selected,
            fn ($column) => is_string($column) && array_key_exists($column, $columns)
        ));
    }

    private function availableColumns(string $table, array $columns): array
    {
        if (! Schema::hasTable($table)) {
            return [];
        }

        return array_values(array_filter(
            $columns,
            fn ($column) => Schema::hasColumn($table, $column)
        ));
    }

    private function validateBuilderFilters(Request $request, array $columns): void
    {
        $rules = [
            'from_date' => ['nullable', 'date'],
            'to_date' => ['nullable', 'date', 'after_or_equal:from_date'],
            'search' => ['nullable', 'string', 'max:255'],
        ];
        foreach ($columns as $column => $label) {
            $rules[$column] = $column === 'salary'
                ? ['nullable', 'numeric']
                : (str_ends_with($column, '_date') ? ['nullable', 'date'] : ['nullable', 'string', 'max:255']);
        }
        $request->validate($rules);
    }

    private function applyEmployeeFilters(Builder $query, Request $request, array $columns): void
    {
        if ($request->filled('search')) {
            $searchable = array_values(array_intersect(
                ['name', 'employee_no', 'national_id', 'phone', 'department', 'job_title', 'death_place', 'city', 'state'],
                array_keys($columns)
            ));
            $search = $request->string('search')->trim()->toString();
            $query->where(function (Builder $builder) use ($searchable, $search) {
                foreach ($searchable as $index => $column) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $builder->{$method}($column, 'like', '%'.$search.'%');
                }
            });
        }

        foreach ($columns as $column => $label) {
            if (! $request->filled($column)) {
                continue;
            }
            if (in_array($column, ['birth_date', 'death_date', 'hire_date'], true)) {
                $query->whereDate($column, $request->input($column));
            } elseif ($column === 'salary') {
                $query->where($column, $request->input($column));
            } else {
                $query->where($column, 'like', '%'.$request->input($column).'%');
            }
        }
    }

    private function applyHireDateRange(Builder $query, Request $request): void
    {
        if (! Schema::hasColumn('employees', 'hire_date')) {
            return;
        }
        if ($request->filled('from_date')) {
            $query->whereDate('hire_date', '>=', $request->input('from_date'));
        }
        if ($request->filled('to_date')) {
            $query->whereDate('hire_date', '<=', $request->input('to_date'));
        }
    }

    private function salesQuery(Request $request): Builder
    {
        $query = Invoice::query()->with('customer');
        if ($request->filled('customer_id') && Schema::hasColumn('invoices', 'customer_id')) {
            $query->where('customer_id', $request->integer('customer_id'));
        }
        if ($request->filled('from') && Schema::hasColumn('invoices', 'invoice_date')) {
            $query->whereDate('invoice_date', '>=', $request->input('from'));
        }
        if ($request->filled('to') && Schema::hasColumn('invoices', 'invoice_date')) {
            $query->whereDate('invoice_date', '<=', $request->input('to'));
        }

        return $query;
    }

    private function tableCount(string $table): int
    {
        return Schema::hasTable($table) ? DB::table($table)->count() : 0;
    }

    private function safeCsvValue(mixed $value): mixed
    {
        if (! is_string($value) || ! preg_match('/^[\s]*[=+\-@]/', $value)) {
            return $value;
        }

        return "'".$value;
    }
}
