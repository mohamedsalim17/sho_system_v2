@extends('layouts.app')
@section('title', 'تعديل فاتورة')
@section('content')
<main class="form-page">
    <header class="form-page-heading">
        <div><h1>تعديل الفاتورة رقم {{ $invoice->id }}</h1><p>ستُعاد كميات البنود القديمة إلى المخزون ثم تُخصم البنود الجديدة عند الحفظ.</p></div>
        <a class="form-cancel" href="{{ route('invoices.show', $invoice) }}">العودة للفاتورة</a>
    </header>
    <section class="form-card">@include('invoices._form')</section>
</main>
@endsection
