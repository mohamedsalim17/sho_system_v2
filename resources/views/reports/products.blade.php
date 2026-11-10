@extends('layouts.main')
@section('title', 'تقرير المخزون')
@section('content')
<main class="report-page">
    <header class="report-heading">
        <h1>تقرير المخزون</h1>
        <p>مراجعة المنتجات والكميات والأسعار مع تنبيه مبكر للمخزون المنخفض.</p>
    </header>

    <section class="report-grid">
        <div class="report-stat"><span>عدد المنتجات</span><strong>{{ number_format($productCount) }}</strong></div>
        <div class="report-stat"><span>منتجات منخفضة المخزون (5 أو أقل)</span><strong>{{ number_format($lowStockCount) }}</strong></div>
        <div class="report-stat"><span>قيمة المخزون التقديرية</span><strong>{{ number_format($inventoryValue, 2) }}</strong></div>
    </section>

    <section class="report-panel report-print-hidden">
        <form method="GET" action="{{ route('reports.products') }}" class="report-form">
            <div>
                <label for="product-search">بحث</label>
                <input id="product-search" type="search" name="search" value="{{ request('search') }}" placeholder="اسم المنتج، الباركود أو الفئة">
            </div>
            <div class="report-toolbar">
                <button class="report-btn" type="submit">بحث</button>
                <a class="report-btn report-btn-light" href="{{ route('reports.products') }}">مسح التصفية</a>
                <button class="report-btn report-btn-light" type="button" onclick="window.print()">طباعة</button>
            </div>
        </form>
    </section>

    <section class="report-panel">
        <div class="report-muted">عدد النتائج: {{ number_format($products->total()) }}</div>
        <div class="report-table-wrap">
            <table>
                <thead><tr><th>#</th><th>المنتج</th><th>الباركود</th><th>الفئة</th><th>سعر الشراء</th><th>سعر البيع</th><th>الكمية</th><th>الوحدة</th><th>الصلاحية</th></tr></thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $products->firstItem() + $loop->index }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->barcode ?: '-' }}</td>
                            <td>{{ $product->category ?: '-' }}</td>
                            <td>{{ $product->buy_price !== null ? number_format((float) $product->buy_price, 2) : '-' }}</td>
                            <td>{{ $product->price !== null ? number_format((float) $product->price, 2) : '-' }}</td>
                            <td>{{ number_format((float) $product->quantity) }}</td>
                            <td>{{ $product->unit ?: '-' }}</td>
                            <td>{{ $product->expiry_date ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr><td class="report-empty" colspan="9">لا توجد نتائج مطابقة.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="report-pager">{{ $products->links() }}</div>
    </section>
</main>
@endsection
