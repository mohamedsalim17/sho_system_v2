@extends('layouts.app')
@section('content')
<div class="card p-3">
<form method="GET" class="row mb-3">
<select name="customer_id" class="form-control col-md-3"><option value="">كل العملاء ({{ $customers->count() }})</option>@foreach($customers as $c)<option value="{{ $c->id }}" {{ request('customer_id')==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach</select>
<input type="date" name="from" value="{{ request('from') }}" class="form-control col-md-2"><input type="date" name="to" value="{{ request('to') }}" class="form-control col-md-2">
<button class="btn btn-dark">فلتر</button>
</form>
<table class="table table-bordered text-center">
<thead><tr><th>#</th><th>رقم الفاتورة</th><th>العميل</th><th>تاريخ الفاتورة</th><th>الإجمالي</th><th>المدفوع</th><th>الحالة</th></tr></thead>
<tbody>@forelse($invoices as $inv)<tr><td>{{ $loop->iteration }}</td><td>{{ $inv->id }}</td><td>{{ $inv->customer->name ?? 'بدون عميل' }}</td><td>{{ $inv->invoice_date }}</td><td>{{ $inv->total }}</td><td>{{ $inv->paid }}</td><td>{{ $inv->status }}</td></tr>@empty<tr><td colspan="7">لا توجد فواتير</td></tr>@endforelse</tbody>
</table>
</div>
@endsection
