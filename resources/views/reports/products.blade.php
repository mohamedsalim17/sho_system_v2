@extends('layouts.main')
@section('content')
<div class="container">
<h3>تقرير المخزون</h3>
<table class="table table-bordered">
<tr><th>#</th><th>الصنف</th><th>الكمية</th><th>السعر</th></tr>
@foreach($products as $p)
<tr>
<td>{{ $loop->iteration }}</td>
<td>{{ $p->name }}</td>
<td>{{ $p->quantity ?? $p->stock ?? 0 }}</td>
<td>{{ $p->price }}</td>
</tr>
@endforeach
</table>
</div>
@endsection
