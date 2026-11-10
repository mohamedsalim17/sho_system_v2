@extends('layouts.main')
@section('title', 'الموظفون')
@section('content')
<main class="form-page">
    <header class="form-page-heading">
        <div><h1>الموظفون</h1><p>إدارة بيانات الموظفين والبحث في السجلات.</p></div>
        @if(in_array(auth()->user()->role, ['admin', 'hr'], true))
            <div class="form-actions">
                <a class="form-cancel" href="{{ route('employees.import.create') }}">استيراد ملف</a>
                <a class="form-submit" href="{{ route('employees.create') }}">إضافة موظف</a>
            </div>
        @endif
    </header>
    <section class="form-card">
        <form method="GET" action="{{ route('employees.index') }}" class="report-form report-print-hidden">
            <div class="field"><label for="employee-search">بحث</label><input id="employee-search" type="search" name="search" value="{{ request('search') }}" placeholder="الاسم أو الرقم الوظيفي أو القسم"></div>
            <div class="form-actions"><button class="form-submit" type="submit">بحث</button><a class="form-cancel" href="{{ route('employees.index') }}">مسح</a></div>
        </form>
        <p class="form-note" style="margin-top:16px">عدد النتائج: {{ number_format($employees->total()) }}</p>
        <div class="table-responsive">
            <table>
                <thead><tr><th>الرقم الوظيفي</th><th>الاسم</th><th>الهاتف</th><th>المسمى الوظيفي</th><th>القسم</th><th>الولاية والمدينة</th><th>الإجراءات</th></tr></thead>
                <tbody>
                    @forelse($employees as $employee)
                        <tr>
                            <td>{{ $employee->employee_no }}</td><td>{{ $employee->name }}</td><td>{{ $employee->phone ?: '-' }}</td>
                            <td>{{ $employee->job_title ?: '-' }}</td><td>{{ $employee->department ?: '-' }}</td>
                            <td>{{ trim(($employee->state ?: '').' - '.($employee->city ?: ''), ' -') ?: '-' }}</td>
                            <td>
                                <a class="form-cancel" href="{{ route('employees.show', $employee) }}">عرض</a>
                                @if(in_array(auth()->user()->role, ['admin', 'hr'], true))
                                    <a class="form-cancel" href="{{ route('employees.edit', $employee) }}">تعديل</a>
                                    <form action="{{ route('employees.destroy', $employee) }}" method="POST" style="display:inline" onsubmit="return confirm('حذف سجل الموظف؟')">
                                        @csrf @method('DELETE')
                                        <button class="form-submit" type="submit">حذف</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="report-empty">لا توجد سجلات موظفين مطابقة.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="report-pager">{{ $employees->links() }}</div>
    </section>
</main>
@endsection
