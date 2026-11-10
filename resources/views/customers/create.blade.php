@extends('layouts.main')
@section('title', 'إضافة عميل')
@section('content')
<main class="form-page">
    <header class="form-page-heading">
        <div><h1>إضافة عميل جديد</h1><p>أدخل بيانات العميل، وستبقى الحقول الاختيارية فارغة عند عدم توفرها.</p></div>
        <a class="form-cancel" href="{{ route('customers.index') }}">العودة للعملاء</a>
    </header>
    <section class="form-card">@include('customers._form')</section>
</main>
@endsection
