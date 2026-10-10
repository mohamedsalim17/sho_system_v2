@extends('layouts.main')
@section('content')
<div class="container">
<h3>تقرير المبيعات - الإجمالي: {{ $invoices->sum('total') }}</h3>
<table class="table table-bordered">
<tr><th>#</th><th>العميل</th><th>الإجمالي</th><th>التاريخ</th></tr>
@foreach($invoices as $inv)
<tr>
<td>{{ $inv->id }}</td>
<td>{{ $inv->customer->name ?? 'عميل نقدي' }}</td>
<td>{{ $inv->total }}</td>
<td>{{ $inv->created_at->format('Y-m-d') }}</td>
</tr>
@endforeach
</table>
</div>
@endsection
