@extends('layouts.app')
@section('title', 'المخزون')
@section('content')
<main class="form-page">
    <header class="form-page-heading">
        <div><h1>المخزون والمنتجات</h1><p>تابع الأسعار والكميات، وابحث بالاسم أو الفئة أو الباركود.</p></div>
        @if(in_array(auth()->user()->role, ['admin', 'hr'], true))
            <a class="form-submit" href="{{ route('products.create') }}">إضافة منتج</a>
        @endif
    </header>
    <section class="form-card">
        <form method="GET" action="{{ route('products.index') }}" class="report-form report-print-hidden">
            <div class="field"><label for="product-search">بحث</label><input id="product-search" name="search" type="search" value="{{ request('search') }}" placeholder="اسم المنتج، الفئة أو الباركود"></div>
            <div class="form-actions"><button class="form-submit" type="submit">بحث</button><a class="form-cancel" href="{{ route('products.index') }}">مسح</a></div>
        </form>
        <p class="form-note" style="margin-top:16px">عدد النتائج: {{ number_format($products->total()) }}</p>
        <div class="table-responsive">
            <table>
                <thead><tr><th>المنتج</th><th>الباركود</th><th>الفئة</th><th>سعر البيع</th><th>الكمية</th><th>الصلاحية</th><th>الإجراءات</th></tr></thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td><td>{{ $product->barcode ?: '-' }}</td>
                            <td>{{ $product->category ?: '-' }}</td><td>{{ number_format((float) $product->price, 2) }}</td>
                            <td>{{ $product->quantity }} {{ $product->unit }}</td><td>{{ $product->expiry_date ?: '-' }}</td>
                            <td>
                                <a class="form-cancel" href="{{ route('products.show', $product) }}">عرض</a>
                                @if(in_array(auth()->user()->role, ['admin', 'hr'], true))
                                    <a class="form-cancel" href="{{ route('products.edit', $product) }}">تعديل</a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline" onsubmit="return confirm('حذف المنتج؟')">
                                        @csrf @method('DELETE')
                                        <button class="form-submit" type="submit">حذف</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="report-empty">لا توجد منتجات مطابقة.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="report-pager">{{ $products->links() }}</div>
    </section>
</main>
@endsection
