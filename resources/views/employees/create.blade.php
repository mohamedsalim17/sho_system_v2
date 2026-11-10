@extends('layouts.main')
@section('title', 'إضافة موظف')
@section('content')
<main class="form-page">
    <header class="form-page-heading">
        <div><h1>إضافة موظف</h1><p>أدخل بيانات الموظف في الحقول المطابقة لسجل الموظفين.</p></div>
        <a class="form-cancel" href="{{ route('employees.index') }}">العودة للموظفين</a>
    </header>
    <section class="form-card">@include('employees._form')</section>
</main>
@endsection
