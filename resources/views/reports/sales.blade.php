@extends('layouts.main')
@section('title', 'تقرير المبيعات')
@section('content')
<main class="report-page">
    @if(isset($errors) && $errors->any())
        <div class="report-errors" role="alert">{{ $errors->first() }}</div>
    @endif
    <header class="report-heading">
        <h1>تقرير المبيعات</h1>
        <p>تابع الفواتير المسجلة وصفِّ النتائج حسب العميل وتاريخ الفاتورة.</p>
    </header>

    <section class="report-grid">
        <div class="report-stat"><span>إجمالي المبيعات للنتائج الحالية</span><strong>{{ number_format($totalSales, 2) }}</strong></div>
        <div class="report-stat"><span>عدد الفواتير للنتائج الحالية</span><strong>{{ number_format($invoiceCount) }}</strong></div>
    </section>

    <section class="report-panel report-print-hidden">
        <form method="GET" action="{{ route('reports.sales') }}" class="report-form">
            <div>
                <label for="sales-customer">العميل</label>
                <select id="sales-customer" name="customer_id">
                    <option value="">كل العملاء</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" @selected((string) request('customer_id') === (string) $customer->id)>{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>
            <div><label for="sales-from">من تاريخ</label><input id="sales-from" type="date" name="from" value="{{ request('from') }}"></div>
            <div><label for="sales-to">إلى تاريخ</label><input id="sales-to" type="date" name="to" value="{{ request('to') }}"></div>
            <div class="report-toolbar">
                <button class="report-btn" type="submit">تطبيق التصفية</button>
                <a class="report-btn report-btn-light" href="{{ route('reports.sales') }}">مسح التصفية</a>
                <a class="report-btn report-btn-green" href="{{ route('reports.sales.csv', request()->query()) }}">تصدير CSV</a>
                <button class="report-btn report-btn-light" type="button" onclick="window.print()">طباعة</button>
            </div>
        </form>
    </section>

    <section class="report-panel">
        <div class="report-muted">عدد النتائج: {{ number_format($invoices->total()) }}</div>
        <div class="report-table-wrap">
            <table>
                <thead><tr><th>#</th><th>رقم الفاتورة</th><th>العميل</th><th>تاريخ الفاتورة</th><th>الإجمالي</th></tr></thead>
                <tbody>
                    @forelse($invoices as $invoice)
                        <tr>
                            <td>{{ $invoices->firstItem() + $loop->index }}</td>
                            <td>{{ $invoice->id }}</td>
                            <td>{{ $invoice->customer->name ?? 'بدون عميل' }}</td>
                            <td>{{ $invoice->invoice_date ?: '-' }}</td>
                            <td>{{ number_format((float) $invoice->total_amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td class="report-empty" colspan="5">لا توجد فواتير ضمن التصفية المحددة.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="report-pager">{{ $invoices->links() }}</div>
    </section>
</main>
@endsection
