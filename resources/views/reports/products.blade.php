@extends('layouts.app')
@section('content')
<div class="card p-3">
<form method="GET" class="row mb-3"><input type="text" name="search" value="{{ request('search') }}" placeholder="بحث بالاسم او الباركود" class="form-control col-md-4"><button class="btn btn-dark">بحث</button></form>
<table class="table table-bordered text-center">
<thead><tr><th>#</th><th>الاسم</th><th>الباركود</th><th>الفئة</th><th>سعر الشراء</th><th>سعر البيع</th><th>الكمية</th><th>الوحدة</th></tr></thead>
<tbody>@forelse($products as $p)<tr><td>{{ $loop->iteration }}</td><td>{{ $p->name }}</td><td>{{ $p->barcode }}</td><td>{{ $p->category }}</td><td>{{ $p->purchase_price }}</td><td>{{ $p->price }}</td><td>{{ $p->quantity }}</td><td>{{ $p->unit }}</td></tr>@empty<tr><td colspan="8">لا يوجد منتجات</td></tr>@endforelse</tbody>
</table>
</div>
@endsection
