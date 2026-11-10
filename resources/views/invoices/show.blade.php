@extends('layouts.app')
@section('title', 'الفاتورة رقم '.$invoice->id)
@section('content')
<main class="form-page">
    <header class="form-page-heading">
        <div><h1>الفاتورة رقم {{ $invoice->id }}</h1><p>تفاصيل العميل والبنود والأسعار المسجلة وقت إنشاء الفاتورة.</p></div>
        <div class="form-actions" style="margin:0">
            <a class="form-cancel" href="{{ route('invoices.index') }}">كل الفواتير</a>
            @if(in_array(auth()->user()->role, ['admin', 'hr'], true))
                <a class="form-submit" href="{{ route('invoices.edit', $invoice) }}">تعديل الفاتورة</a>
            @endif
        </div>
    </header>
    <section class="form-card">
        <div class="report-grid">
            <div class="report-stat"><span>العميل</span><strong>{{ $invoice->customer->name ?? 'غير متاح' }}</strong></div>
            <div class="report-stat"><span>التاريخ</span><strong>{{ $invoice->invoice_date?->format('Y-m-d') }}</strong></div>
            <div class="report-stat"><span>الإجمالي</span><strong>{{ number_format((float) $invoice->total_amount, 2) }}</strong></div>
        </div>
        @if($invoice->notes)<p class="form-note" style="margin-top:16px">ملاحظات: {{ $invoice->notes }}</p>@endif
        <div class="table-responsive">
            <table>
                <thead><tr><th>المنتج</th><th>الكمية</th><th>سعر الوحدة</th><th>الإجمالي</th></tr></thead>
                <tbody>
                    @forelse($invoice->items as $item)
                        <tr><td>{{ $item->product->name ?? 'منتج محذوف' }}</td><td>{{ $item->quantity }}</td><td>{{ number_format((float) $item->price, 2) }}</td><td>{{ number_format((float) $item->subtotal, 2) }}</td></tr>
                    @empty
                        <tr><td colspan="4" class="report-empty">لا توجد بنود مسجلة لهذه الفاتورة.</td></tr>
                    @endforelse
                </tbody>
                <tfoot><tr><th colspan="3">الإجمالي الكلي</th><th>{{ number_format((float) $invoice->total_amount, 2) }}</th></tr></tfoot>
            </table>
        </div>
        <button class="form-cancel" type="button" onclick="window.print()" style="margin-top:16px">طباعة الفاتورة</button>
    </section>
</main>
@endsection
