@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-3">صفحة الفواتير</h1>
    <a href="{{ route('invoices.create') }}" class="btn btn-success mb-3">+ انشاء فاتورة جديدة</a>

    <h4>المنتجات المتاحة للبيع</h4>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>اسم المنتج</th>
                <th>السعر</th>
                <th>الكمية في المخزن</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->price }} جنيه</td>
                <td>{{ $product->quantity }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">لا توجد منتجات. اضف منتجات من صفحة المنتجات</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
