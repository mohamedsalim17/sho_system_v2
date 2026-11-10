@extends('layouts.main')
@section('title', 'تقرير المبيعات المخصص')
@section('content')
<main class="report-page">
    @if(isset($errors) && $errors->any())<div class="report-errors" role="alert">{{ $errors->first() }}</div>@endif
    <header class="report-heading"><h1>تقرير المبيعات المخصص</h1><p>صفِّ الفواتير حسب العميل والفترة الزمنية.</p></header>
    <section class="report-grid">
        <div class="report-stat"><span>إجمالي المبيعات المطابقة</span><strong>{{ number_format($total, 2) }}</strong></div>
        <div class="report-stat"><span>عدد الفواتير</span><strong>{{ number_format($results->total()) }}</strong></div>
    </section>
    <section class="report-panel report-print-hidden">
        <form method="GET" action="{{ route('reports.custom') }}" class="report-form">
            <div><label for="custom-customer">العميل</label><select id="custom-customer" name="customer_id"><option value="">كل العملاء</option>@foreach($customers as $customer)<option value="{{ $customer->id }}" @selected((string) request('customer_id') === (string) $customer->id)>{{ $customer->name }}{{ $customer->phone ? ' - '.$customer->phone : '' }}</option>@endforeach</select></div>
            <div><label for="custom-from">من تاريخ</label><input id="custom-from" type="date" name="from" value="{{ request('from') }}"></div>
            <div><label for="custom-to">إلى تاريخ</label><input id="custom-to" type="date" name="to" value="{{ request('to') }}"></div>
            <div class="report-toolbar"><button class="report-btn" type="submit">تطبيق التصفية</button><a class="report-btn report-btn-light" href="{{ route('reports.custom') }}">عرض الكل</a><a class="report-btn report-btn-green" href="{{ route('reports.sales.csv', request()->query()) }}">تصدير CSV</a><button class="report-btn report-btn-light" type="button" onclick="window.print()">طباعة</button></div>
        </form>
    </section>
    <section class="report-panel">
        <div class="report-table-wrap">
            <table><thead><tr><th>#</th><th>رقم الفاتورة</th><th>العميل</th><th>تاريخ الفاتورة</th><th>الإجمالي</th><th>ملاحظات</th></tr></thead>
                <tbody>
                    @forelse($results as $invoice)
                        <tr><td>{{ $results->firstItem() + $loop->index }}</td><td>{{ $invoice->id }}</td><td>{{ $invoice->customer->name ?? 'بدون عميل' }}</td><td>{{ $invoice->invoice_date ?: '-' }}</td><td>{{ number_format((float) $invoice->total_amount, 2) }}</td><td>{{ $invoice->notes ?: '-' }}</td></tr>
                    @empty
                        <tr><td class="report-empty" colspan="6">لا توجد فواتير ضمن التصفية المحددة.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="report-pager">{{ $results->links() }}</div>
    </section>
</main>
@endsection
