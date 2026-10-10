@extends('layouts.app')
@section('content')
<div class="card p-3">
<form method="GET" class="row mb-3"><input type="text" name="search" value="{{ request('search') }}" placeholder="بحث بالاسم او الهاتف او الرقم الوطني" class="form-control col-md-4"><button class="btn btn-dark">بحث</button></form>
<table class="table table-bordered text-center">
<thead><tr><th>#</th><th>الاسم</th><th>الهاتف</th><th>الرقم الوطني</th><th>النوع</th><th>المدينة</th><th>الولاية</th><th>الوظيفة</th><th>عدد الفواتير</th></tr></thead>
<tbody>@forelse($customers as $c)<tr><td>{{ $loop->iteration }}</td><td>{{ $c->name }}</td><td>{{ $c->phone }}</td><td>{{ $c->national_id }}</td><td>{{ $c->gender }}</td><td>{{ $c->city }}</td><td>{{ $c->state }}</td><td>{{ $c->job }}</td><td>{{ $c->invoices_count }}</td></tr>@empty<tr><td colspan="9">لا يوجد عملاء</td></tr>@endforelse</tbody>
</table>
</div>
@endsection
