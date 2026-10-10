@extends('layouts.main')
@section('content')
<div class="container">
<h3>تقرير العملاء - {{ $customers->count() }} عميل</h3>
<table class="table table-bordered">
<tr><th>#</th><th>الاسم</th><th>عدد الفواتير</th><th>الهاتف</th></tr>
@foreach($customers as $c)
<tr>
<td>{{ $loop->iteration }}</td>
<td>{{ $c->name }}</td>
<td>{{ $c->invoices_count }}</td>
<td>{{ $c->phone ?? '-' }}</td>
</tr>
@endforeach
</table>
</div>
@endsection
