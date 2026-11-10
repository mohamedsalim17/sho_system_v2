@extends('layouts.main')
@section('title', 'بيانات الموظف')
@section('content')
<main class="form-page">
    <header class="form-page-heading">
        <div><h1>{{ $employee->name }}</h1><p>الرقم الوظيفي: {{ $employee->employee_no }}</p></div>
        <div class="form-actions" style="margin:0">
            <a class="form-cancel" href="{{ route('employees.index') }}">العودة للموظفين</a>
            <a class="form-cancel" href="{{ route('employees.relatives.index', $employee) }}">أقارب الموظف</a>
            @if(in_array(auth()->user()->role, ['admin', 'hr'], true))
                <a class="form-submit" href="{{ route('employees.edit', $employee) }}">تعديل</a>
            @endif
        </div>
    </header>
    <section class="form-card">
        <div class="report-grid">
            @foreach(['الرقم الوطني' => $employee->national_id, 'الهاتف' => $employee->phone, 'تاريخ الميلاد' => $employee->birth_date?->format('Y-m-d'), 'الحالة الاجتماعية' => $employee->marital_status, 'المسمى الوظيفي' => $employee->job_title, 'القسم' => $employee->department, 'الراتب' => $employee->salary, 'تاريخ التعيين' => $employee->hire_date?->format('Y-m-d'), 'الولاية' => $employee->state, 'المدينة' => $employee->city, 'الحي' => $employee->neighborhood, 'الشارع' => $employee->street, 'تاريخ الوفاة' => $employee->death_date?->format('Y-m-d'), 'مكان الوفاة' => $employee->death_place] as $label => $value)
                <div class="report-stat"><span>{{ $label }}</span><strong>{{ $value ?: '-' }}</strong></div>
            @endforeach
        </div>
    </section>
</main>
@endsection
