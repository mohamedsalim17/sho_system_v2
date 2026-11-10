@extends('layouts.main')
@section('title', 'تقرير الموظفين')
@section('content')
<main class="report-page">
    <header class="report-heading">
        <h1>تقرير الموظفين</h1>
        <p>استعرض بيانات الموظفين وابحث حسب الاسم أو الرقم الوظيفي أو القسم.</p>
    </header>

    <section class="report-panel report-print-hidden">
        <form method="GET" action="{{ route('reports.employees') }}" class="report-form">
            <div>
                <label for="employee-search">بحث</label>
                <input id="employee-search" type="search" name="search" value="{{ request('search') }}" placeholder="الاسم، رقم الموظف، الهاتف أو القسم">
            </div>
            <div class="report-toolbar">
                <button class="report-btn" type="submit">بحث</button>
                <a class="report-btn report-btn-light" href="{{ route('reports.employees') }}">مسح التصفية</a>
                <button class="report-btn report-btn-light" type="button" onclick="window.print()">طباعة</button>
            </div>
        </form>
    </section>

    <section class="report-panel">
        <div class="report-muted">عدد النتائج: {{ number_format($employees->total()) }}</div>
        <div class="report-table-wrap">
            <table>
                <thead><tr><th>#</th><th>الرقم الوظيفي</th><th>الاسم</th><th>الرقم الوطني</th><th>الهاتف</th><th>الوظيفة</th><th>القسم</th><th>المدينة والولاية</th><th>الراتب</th><th>الأقارب</th></tr></thead>
                <tbody>
                    @forelse($employees as $employee)
                        <tr>
                            <td>{{ $employees->firstItem() + $loop->index }}</td>
                            <td>{{ $employee->employee_no ?: '-' }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->national_id ?: '-' }}</td>
                            <td>{{ $employee->phone ?: '-' }}</td>
                            <td>{{ $employee->job_title ?: '-' }}</td>
                            <td>{{ $employee->department ?: '-' }}</td>
                            <td>{{ trim(($employee->city ?: '').' - '.($employee->state ?: ''), ' -') ?: '-' }}</td>
                            <td>{{ $employee->salary !== null ? number_format((float) $employee->salary, 2) : '-' }}</td>
                            <td>{{ number_format($employee->relatives_count) }}</td>
                        </tr>
                    @empty
                        <tr><td class="report-empty" colspan="10">لا توجد نتائج مطابقة.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="report-pager">{{ $employees->links() }}</div>
    </section>
</main>
@endsection
