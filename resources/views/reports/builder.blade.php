@extends('layouts.main')
@section('title', 'منشئ التقارير')
@section('content')
<main class="report-page">
    @if(isset($errors) && $errors->any())
        <div class="report-errors" role="alert">{{ $errors->first() }}</div>
    @endif
    <header class="report-heading">
        <h1>منشئ التقارير</h1>
        <p>اختر مصدر البيانات، ثم حدّد الحقول المطلوبة للتصفية والعرض أو التصدير المحلي.</p>
    </header>

    <form method="GET" action="{{ route('reports.builder') }}">
        <section class="report-panel">
            <h2 style="font-size:17px;margin-bottom:14px">معايير البحث</h2>
            <div class="report-form">
                <div>
                    <label for="report-source">مصدر البيانات</label>
                    <select id="report-source" name="source">
                        <option value="employees" @selected($reportSource === 'employees')>الموظفون</option>
                        <option value="customers" @selected($reportSource === 'customers')>العملاء</option>
                    </select>
                </div>
                <div>
                    <label for="employee-global-search">بحث عام</label>
                    <input id="employee-global-search" type="search" name="search" value="{{ request('search') }}" placeholder="الاسم أو رقم الهوية أو الهاتف أو مكان الوفاة">
                </div>
                @foreach($allColumns as $column => $label)
                    <div>
                        <label for="filter-{{ $column }}">{{ $label }}</label>
                        @if(isset($filterData[$column]))
                            <select id="filter-{{ $column }}" name="{{ $column }}">
                                <option value="">الكل</option>
                                @foreach($filterData[$column] as $value)
                                    <option value="{{ $value }}" @selected((string) request($column) === (string) $value)>{{ $value }}</option>
                                @endforeach
                            </select>
                        @elseif(in_array($column, ['birth_date', 'death_date', 'hire_date'], true))
                            <input id="filter-{{ $column }}" type="date" name="{{ $column }}" value="{{ request($column) }}">
                        @else
                            <input id="filter-{{ $column }}" type="text" name="{{ $column }}" value="{{ request($column) }}" placeholder="بحث {{ $label }}">
                        @endif
                    </div>
                @endforeach
                @if(isset($allColumns['hire_date']))
                    <div><label for="filter-from-date">التعيين من</label><input id="filter-from-date" type="date" name="from_date" value="{{ request('from_date') }}"></div>
                    <div><label for="filter-to-date">التعيين إلى</label><input id="filter-to-date" type="date" name="to_date" value="{{ request('to_date') }}"></div>
                @endif
            </div>
        </section>

        <section class="report-panel">
            <h2 style="font-size:17px;margin-bottom:14px">الأعمدة الظاهرة</h2>
            <div class="report-featured-fields">
                @foreach(['death_date' => 'تاريخ الوفاة', 'death_place' => 'مكان الوفاة'] as $column => $label)
                    @if(isset($allColumns[$column]))
                        <label class="report-featured-field">
                            <input type="checkbox" name="columns[]" value="{{ $column }}" @checked(in_array($column, $selectedColumns, true))>
                            {{ $label }}
                        </label>
                    @endif
                @endforeach
            </div>
            <div class="report-grid">
                @foreach($allColumns as $column => $label)
                    @if(!in_array($column, ['death_date', 'death_place'], true))
                        <label style="display:flex;align-items:center;gap:8px;margin:0">
                            <input type="checkbox" name="columns[]" value="{{ $column }}" @checked(in_array($column, $selectedColumns, true))>
                            {{ $label }}
                        </label>
                    @endif
                @endforeach
            </div>
            <div class="report-actions report-print-hidden">
                <button class="report-btn" type="submit">تطبيق وعرض التقرير</button>
                <a class="report-btn report-btn-light" href="{{ route('reports.builder') }}">عرض الكل</a>
                <button class="report-btn report-btn-light" type="button" onclick="window.print()">طباعة / حفظ PDF</button>
                <a class="report-btn report-btn-red" href="{{ route('reports.pdf', request()->query()) }}" target="_blank" rel="noopener">فتح نسخة PDF للطباعة</a>
                <a class="report-btn report-btn-green" href="{{ route('reports.excel', request()->query()) }}">تصدير CSV</a>
            </div>
        </section>
    </form>

    <section class="report-panel">
        <div class="report-muted">عدد السجلات المطابقة: {{ number_format($employees->total()) }}</div>
        <div class="report-table-wrap">
            <table>
                <thead>
                    <tr><th>#</th>@foreach($selectedColumns as $column)<th>{{ $allColumns[$column] }}</th>@endforeach</tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                        <tr>
                            <td>{{ $employees->firstItem() + $loop->index }}</td>
                            @foreach($selectedColumns as $column)
                                <td>{{ $employee->{$column} ?? '-' }}</td>
                            @endforeach
                        </tr>
                    @empty
                        <tr><td class="report-empty" colspan="{{ count($selectedColumns) + 1 }}">لا توجد نتائج مطابقة.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="report-pager">{{ $employees->links() }}</div>
    </section>
</main>
@endsection
