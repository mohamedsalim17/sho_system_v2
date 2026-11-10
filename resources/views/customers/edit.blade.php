@extends('layouts.main')
@section('title', 'تعديل بيانات العميل')
@section('content')
<main class="form-page">
    <header class="form-page-heading">
        <div><h1>تعديل بيانات العميل</h1><p>حدّث البيانات المطلوبة ثم احفظ التغييرات.</p></div>
        <a class="form-cancel" href="{{ route('customers.index') }}">العودة للعملاء</a>
    </header>
    <section class="form-card">@include('customers._form')</section>
</main>
@endsection
