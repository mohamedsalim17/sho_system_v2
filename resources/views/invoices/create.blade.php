@extends('layouts.app')
@section('title', 'إنشاء فاتورة')
@section('content')
<main class="form-page">
    <header class="form-page-heading">
        <div><h1>إنشاء فاتورة</h1><p>اختر العميل والمنتجات. يعتمد الإجمالي النهائي على السعر المخزن والمخزون الفعلي.</p></div>
        <a class="form-cancel" href="{{ route('invoices.index') }}">العودة للفواتير</a>
    </header>
    @if($customers->isEmpty())<div class="form-flash form-flash-error" role="alert">أضف عميلًا واحدًا على الأقل قبل إنشاء فاتورة.</div>@endif
    @if($products->isEmpty())<div class="form-flash form-flash-error" role="alert">لا توجد منتجات متاحة للبيع. أضف منتجًا أو حدّث المخزون أولًا.</div>@endif
    <section class="form-card">@include('invoices._form')</section>
</main>
@endsection
