@extends('layouts.main')
@section('title', 'التقرير العام للموظفين')
@section('content')
<main class="report-page">
    @if(isset($errors) && $errors->any())<div class="report-errors" role="alert">{{ $errors->first() }}</div>@endif
    <header class="report-heading"><h1>التقرير العام للموظفين</h1><p>ابحث في سجلات الموظفين وحدد فترة التعيين المطلوبة.</p></header>
    <section class="report-panel report-print-hidden">
        <form method="GET" action="{{ route('reports.general') }}" class="report-form">
            <div><label for="general-search">بحث عام</label><input id="general-search" type="search" name="search" value="{{ request('search') }}" placeholder="الاسم أو الرقم الوظيفي أو الهاتف"></div>
            <div><label for="general-from">تاريخ التعيين من</label><input id="general-from" type="date" name="from_date" value="{{ request('from_date') }}"></div>
            <div><label for="general-to">تاريخ التعيين إلى</label><input id="general-to" type="date" name="to_date" value="{{ request('to_date') }}"></div>
            <div class="report-toolbar"><button class="report-btn" type="submit">تطبيق التصفية</button><a class="report-btn report-btn-light" href="{{ route('reports.general') }}">عرض الكل</a><button class="report-btn report-btn-light" type="button" onclick="window.print()">طباعة</button></div>
        </form>
    </section>
    <section class="report-panel">
        <div class="report-muted">عدد النتائج: {{ number_format($employees->total()) }}</div>
        <div class="report-table-wrap">
            <table><thead><tr><th>#</th><th>رقم الموظف</th><th>الاسم</th><th>القسم</th><th>المسمى الوظيفي</th><th>تاريخ التعيين</th><th>تاريخ الوفاة</th><th>مكان الوفاة</th></tr></thead>
                <tbody>
                    @forelse($employees as $employee)
                        <tr><td>{{ $employees->firstItem() + $loop->index }}</td><td>{{ $employee->employee_no ?: '-' }}</td><td>{{ $employee->name }}</td><td>{{ $employee->department ?: '-' }}</td><td>{{ $employee->job_title ?: '-' }}</td><td>{{ $employee->hire_date ?: '-' }}</td><td>{{ $employee->death_date ?: '-' }}</td><td>{{ $employee->death_place ?: '-' }}</td></tr>
                    @empty
                        <tr><td class="report-empty" colspan="8">لا توجد نتائج مطابقة.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="report-pager">{{ $employees->links() }}</div>
    </section>
</main>
@endsection
