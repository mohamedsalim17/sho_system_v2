@extends('layouts.main')
@section('title', 'تقرير العملاء')
@section('content')
<main class="report-page">
    <header class="report-heading">
        <h1>تقرير العملاء</h1>
        <p>بحث سريع في العملاء ومراجعة بيانات التواصل والفواتير المرتبطة.</p>
    </header>

    <section class="report-panel report-print-hidden">
        <form method="GET" action="{{ route('reports.customers') }}" class="report-form">
            <div>
                <label for="customer-search">بحث</label>
                <input id="customer-search" type="search" name="search" value="{{ request('search') }}" placeholder="الاسم أو الهاتف أو المدينة أو مكان الوفاة">
            </div>
            <div class="report-toolbar">
                <button class="report-btn" type="submit">بحث</button>
                <a class="report-btn report-btn-light" href="{{ route('reports.customers') }}">مسح التصفية</a>
                <button class="report-btn report-btn-light" type="button" onclick="window.print()">طباعة</button>
            </div>
        </form>
    </section>

    <section class="report-panel">
        <div class="report-muted">عدد النتائج: {{ number_format($customers->total()) }}</div>
        <div class="report-table-wrap">
            <table>
                <thead><tr><th>#</th><th>الاسم</th><th>الهاتف</th><th>الرقم الوطني</th><th>النوع</th><th>المدينة</th><th>الولاية</th><th>الوظيفة</th><th>تاريخ الوفاة</th><th>مكان الوفاة</th><th>الفواتير</th></tr></thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr>
                            <td>{{ $customers->firstItem() + $loop->index }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->phone ?: '-' }}</td>
                            <td>{{ $customer->national_id ?: '-' }}</td>
                            <td>{{ $customer->gender ?: '-' }}</td>
                            <td>{{ $customer->city ?: '-' }}</td>
                            <td>{{ $customer->state ?: '-' }}</td>
                            <td>{{ $customer->job ?: '-' }}</td>
                            <td>{{ $customer->date_of_death ?: '-' }}</td>
                            <td>{{ $customer->place_of_death ?: '-' }}</td>
                            <td>{{ number_format($customer->invoices_count) }}</td>
                        </tr>
                    @empty
                        <tr><td class="report-empty" colspan="11">لا توجد نتائج مطابقة.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="report-pager">{{ $customers->links() }}</div>
    </section>
</main>
@endsection
