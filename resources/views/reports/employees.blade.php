@extends('layouts.main')
@section('content')
<div class="container">
<h3>تقرير الموظفين</h3>
<table class="table table-bordered">
<tr><th>#</th><th>الاسم</th><th>الوظيفة</th></tr>
@foreach($employees as $e)
<tr><td>{{ $loop->iteration }}</td><td>{{ $e->name }}</td><td>{{ $e->position ?? $e->job ?? '-' }}</td></tr>
@endforeach
</table>
</div>
@endsection
