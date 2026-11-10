@extends('layouts.app')
@section('title', 'بيانات المنتج')
@section('content')
<main class="form-page">
    <header class="form-page-heading">
        <div><h1>{{ $product->name }}</h1><p>تفاصيل المنتج والمخزون الحالي.</p></div>
        <div class="form-actions" style="margin:0"><a class="form-cancel" href="{{ route('products.index') }}">العودة للمخزون</a>@if(in_array(auth()->user()->role, ['admin', 'hr'], true))<a class="form-submit" href="{{ route('products.edit', $product) }}">تعديل</a>@endif</div>
    </header>
    <section class="form-card">
        <div class="report-grid">
            @foreach(['الفئة' => $product->category, 'الباركود' => $product->barcode, 'المورد' => $product->supplier, 'الوحدة' => $product->unit, 'سعر الشراء' => $product->buy_price, 'سعر البيع' => $product->price, 'الكمية' => $product->quantity, 'تاريخ الصلاحية' => $product->expiry_date] as $label => $value)
                <div class="report-stat"><span>{{ $label }}</span><strong>{{ $value ?: '-' }}</strong></div>
            @endforeach
        </div>
    </section>
</main>
@endsection
