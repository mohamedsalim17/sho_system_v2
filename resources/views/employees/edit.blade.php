@extends('layouts.main')
@section('title', 'تعديل بيانات الموظف')
@section('content')
<main class="form-page">
    <header class="form-page-heading">
        <div><h1>تعديل بيانات الموظف</h1><p>حدّث بيانات الموظف أو عنوانه أو معلوماته الوظيفية.</p></div>
        <a class="form-cancel" href="{{ route('employees.index') }}">العودة للموظفين</a>
    </header>
    <section class="form-card">@include('employees._form')</section>
</main>
@endsection
