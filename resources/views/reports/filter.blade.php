@extends('layouts.main')
@section('title', 'تصفية تقرير الموظفين')
@section('content')
<main class="report-page">
    @if(isset($errors) && $errors->any())<div class="report-errors" role="alert">{{ $errors->first() }}</div>@endif
    <header class="report-heading"><h1>تصفية تقرير الموظفين</h1><p>اختر معيارًا واحدًا أو أكثر. يكفي اختيار حقل وقيمته، والمعايير الأخرى اختيارية.</p></header>
    <section class="report-panel report-print-hidden">
        <form method="GET" action="{{ route('reports.filter') }}" class="report-form">
            @foreach($filters as $index => $filter)
                <div class="filter-criterion" style="padding:14px;border:1px solid #e2e8f0;border-radius:12px;background:#f8fafc">
                    <label for="filter-field-{{ $index }}">معيار {{ $index + 1 }} - الحقل</label>
                    <select id="filter-field-{{ $index }}" name="filters[{{ $index }}][field]" class="filter-field">
                        <option value="">بدون تصفية</option>
                        @foreach($allColumns as $field => $label)
                            <option value="{{ $field }}" @selected(($filter['field'] ?? '') === $field)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <label for="filter-value-{{ $index }}">القيمة</label>
                    <input id="filter-value-{{ $index }}" class="filter-value" name="filters[{{ $index }}][value]" value="{{ $filter['value'] ?? '' }}" placeholder="اكتب قيمة البحث">
                    @if(isset($errors) && $errors->has("filters.$index.field"))<small class="form-flash-error">{{ $errors->first("filters.$index.field") }}</small>@endif
                    @if(isset($errors) && $errors->has("filters.$index.value"))<small class="form-flash-error">{{ $errors->first("filters.$index.value") }}</small>@endif
                </div>
            @endforeach
            <div class="report-toolbar"><button class="report-btn" type="submit">تصفية</button><a class="report-btn report-btn-light" href="{{ route('reports.filter') }}">عرض الكل</a><button class="report-btn report-btn-light" type="button" onclick="window.print()">طباعة</button></div>
        </form>
    </section>
    <section class="report-panel">
        <div class="report-muted">عدد النتائج: {{ number_format($employees->total()) }}</div>
        <div class="report-table-wrap">
            <table><thead><tr><th>#</th><th>رقم الموظف</th><th>الاسم</th><th>الرقم الوطني</th><th>القسم</th><th>المدينة</th><th>الولاية</th><th>الهاتف</th><th>الراتب</th><th>تاريخ الوفاة</th><th>مكان الوفاة</th></tr></thead>
                <tbody>
                    @forelse($employees as $employee)
                        <tr><td>{{ $employees->firstItem() + $loop->index }}</td><td>{{ $employee->employee_no ?: '-' }}</td><td>{{ $employee->name }}</td><td>{{ $employee->national_id ?: '-' }}</td><td>{{ $employee->department ?: '-' }}</td><td>{{ $employee->city ?: '-' }}</td><td>{{ $employee->state ?: '-' }}</td><td>{{ $employee->phone ?: '-' }}</td><td>{{ $employee->salary !== null ? number_format((float) $employee->salary, 2) : '-' }}</td><td>{{ $employee->death_date ?: '-' }}</td><td>{{ $employee->death_place ?: '-' }}</td></tr>
                    @empty
                        <tr><td class="report-empty" colspan="11">لا توجد نتائج مطابقة.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="report-pager">{{ $employees->links() }}</div>
    </section>
</main>
<script>
    document.querySelectorAll('.filter-criterion').forEach((criterion) => {
        const field = criterion.querySelector('.filter-field');
        const value = criterion.querySelector('.filter-value');
        const updateValueType = () => {
            value.type = field.value.endsWith('_date') ? 'date' : (field.value === 'salary' ? 'number' : 'search');
            if (value.type === 'number') value.step = '0.01';
            else value.removeAttribute('step');
        };
        field.addEventListener('change', updateValueType);
        updateValueType();
    });
</script>
@endsection
