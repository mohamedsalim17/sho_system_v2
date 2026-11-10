@extends('layouts.main')
@section('title', 'أقارب الموظف')
@section('content')
<main class="form-page">
    <header class="form-page-heading">
        <div><h1>أقارب الموظف</h1><p>{{ $employee->name }} — الرقم الوظيفي: {{ $employee->employee_no }}</p></div>
        <a class="form-cancel" href="{{ route('employees.show', $employee) }}">العودة لبيانات الموظف</a>
    </header>

    @if(in_array(auth()->user()->role, ['admin', 'hr'], true))
        <section class="form-card">
            <h2 class="relative-heading">إضافة قريب</h2>
            <form method="POST" action="{{ route('employees.relatives.store', $employee) }}">
                @csrf
                @include('employees._relative-form', ['relative' => $relative])
                <div class="form-actions"><button class="form-submit" type="submit">حفظ بيانات القريب</button></div>
            </form>
        </section>
    @endif

    <section class="form-card" style="margin-top:20px">
        <h2 class="relative-heading">السجلات المسجلة</h2>
        <div class="table-responsive">
            <table>
                <thead><tr><th>الاسم</th><th>صلة القرابة</th><th>الرقم الوطني</th><th>تاريخ الميلاد</th><th>تاريخ الوفاة</th><th>مكان الوفاة</th><th>الهاتف</th><th>معال</th><th>بيانات البنك</th><th>الإجراءات</th></tr></thead>
                <tbody>
                    @forelse($relatives as $item)
                        <tr>
                            <td>{{ $item->name }}</td><td>{{ $item->relation }}</td><td>{{ $item->national_id ?: '-' }}</td>
                            <td>{{ $item->birth_date?->format('Y-m-d') ?: '-' }}</td>
                            <td>{{ $item->death_date?->format('Y-m-d') ?: '-' }}</td><td>{{ $item->death_place ?: '-' }}</td>
                            <td>{{ $item->phone ?: '-' }}</td><td>{{ $item->is_dependent ? 'نعم' : 'لا' }}</td>
                            <td>{{ collect([$item->bank_name, $item->bank_account_name, $item->bank_account_no])->filter()->implode(' - ') ?: '-' }}</td>
                            <td>
                                @if(in_array(auth()->user()->role, ['admin', 'hr'], true))
                                    <a class="form-cancel" href="{{ route('employees.relatives.edit', [$employee, $item]) }}">تعديل</a>
                                    <form action="{{ route('employees.relatives.destroy', [$employee, $item]) }}" method="POST" style="display:inline" onsubmit="return confirm('حذف سجل القريب؟')">
                                        @csrf @method('DELETE')
                                        <button class="form-submit" type="submit">حذف</button>
                                    </form>
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td class="report-empty" colspan="10">لا توجد سجلات أقارب لهذا الموظف.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="report-pager">{{ $relatives->links() }}</div>
    </section>
</main>
@endsection
