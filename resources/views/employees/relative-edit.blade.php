@extends('layouts.main')
@section('title', 'تعديل بيانات القريب')
@section('content')
<main class="form-page">
    <header class="form-page-heading">
        <div><h1>تعديل بيانات القريب</h1><p>{{ $relative->name }} — الموظف: {{ $employee->name }}</p></div>
        <a class="form-cancel" href="{{ route('employees.relatives.index', $employee) }}">العودة للأقارب</a>
    </header>
    <section class="form-card">
        <form method="POST" action="{{ route('employees.relatives.update', [$employee, $relative]) }}">
            @csrf @method('PUT')
            @include('employees._relative-form')
            <div class="form-actions"><button class="form-submit" type="submit">حفظ التعديلات</button><a class="form-cancel" href="{{ route('employees.relatives.index', $employee) }}">إلغاء</a></div>
        </form>
    </section>
</main>
@endsection
