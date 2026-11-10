@extends('layouts.main')
@section('title', 'لوحة التحكم')
@section('content')
<main class="report-page">
    <header class="form-page-heading">
        <div><h1>لوحة التحكم</h1><p>مرحبًا {{ auth()->user()->name }} — ملخص بيانات النظام حتى {{ now()->format('Y-m-d') }}.</p></div>
        @if(in_array(auth()->user()->role, ['admin', 'hr'], true))
            <a class="form-submit" href="{{ route('invoices.create') }}">إنشاء فاتورة</a>
        @endif
    </header>

    <section class="report-grid">
        <a class="report-card" href="{{ route('employees.index') }}"><div class="report-card-icon" aria-hidden="true">🧑‍💼</div><h2>{{ number_format($employees) }}</h2><p class="report-muted">الموظفون</p></a>
        <a class="report-card" href="{{ route('customers.index') }}"><div class="report-card-icon" aria-hidden="true">👥</div><h2>{{ number_format($customers) }}</h2><p class="report-muted">العملاء</p></a>
        <a class="report-card" href="{{ route('products.index') }}"><div class="report-card-icon" aria-hidden="true">📦</div><h2>{{ number_format($products) }}</h2><p class="report-muted">المنتجات</p></a>
        <a class="report-card" href="{{ route('invoices.index') }}"><div class="report-card-icon" aria-hidden="true">🧾</div><h2>{{ number_format($invoices) }}</h2><p class="report-muted">الفواتير</p></a>
        <a class="report-card" href="{{ route('reports.sales') }}"><div class="report-card-icon" aria-hidden="true">💰</div><h2>{{ number_format((float) $salesTotal, 2) }}</h2><p class="report-muted">إجمالي المبيعات</p></a>
    </section>

    @if(in_array(auth()->user()->role, ['admin', 'hr'], true))
        <section class="report-actions">
            <a class="report-btn" href="{{ route('customers.create') }}">إضافة عميل</a>
            <a class="report-btn" href="{{ route('employees.create') }}">إضافة موظف</a>
            <a class="report-btn" href="{{ route('products.create') }}">إضافة منتج</a>
            <a class="report-btn report-btn-light" href="{{ route('reports.builder') }}">منشئ التقارير</a>
            @if(auth()->user()->role === 'admin')
                <a class="report-btn report-btn-light" href="{{ route('users.index') }}">إدارة المستخدمين</a>
            @endif
        </section>
    @endif

    <section class="report-panel">
        <div class="form-page-heading"><div><h2 style="font-size:19px">أحدث الفواتير</h2><p>آخر الفواتير المسجلة في النظام.</p></div><a class="form-cancel" href="{{ route('invoices.index') }}">كل الفواتير</a></div>
        <div class="table-responsive">
            <table>
                <thead><tr><th>رقم الفاتورة</th><th>العميل</th><th>التاريخ</th><th>الإجمالي</th><th>التفاصيل</th></tr></thead>
                <tbody>
                    @forelse($latestInvoices as $invoice)
                        <tr>
                            <td>{{ $invoice->id }}</td><td>{{ $invoice->customer->name ?? '-' }}</td>
                            <td>{{ $invoice->invoice_date?->format('Y-m-d') }}</td>
                            <td>{{ number_format((float) $invoice->total_amount, 2) }}</td>
                            <td><a class="form-cancel" href="{{ route('invoices.show', $invoice) }}">عرض</a></td>
                        </tr>
                    @empty
                        <tr><td class="report-empty" colspan="5">لا توجد فواتير بعد.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection
