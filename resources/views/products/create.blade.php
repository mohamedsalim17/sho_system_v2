@extends('layouts.app')
@section('title', 'إضافة منتج')
@section('content')
<main class="form-page">
    <header class="form-page-heading">
        <div><h1>إضافة منتج</h1><p>أدخل بيانات المنتج وأسعاره والكمية المتاحة.</p></div>
        <a class="form-cancel" href="{{ route('products.index') }}">العودة للمخزون</a>
    </header>
    <section class="form-card">@include('products._form')</section>
</main>
@endsection
