@extends('layouts.app')
@section('title', 'تعديل منتج')
@section('content')
<main class="form-page">
    <header class="form-page-heading">
        <div><h1>تعديل المنتج</h1><p>حدّث البيانات أو كمية المخزون ثم احفظ التغييرات.</p></div>
        <a class="form-cancel" href="{{ route('products.index') }}">العودة للمخزون</a>
    </header>
    <section class="form-card">@include('products._form')</section>
</main>
@endsection
