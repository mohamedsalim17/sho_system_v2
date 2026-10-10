@extends('layouts.app')
@section('content')
<div class="card p-3">
<form method="GET" class="row mb-3">
<input type="text" name="search" value="{{ request('search') }}" placeholder="بحث بالاسم او الرقم الوظيفي" class="form-control col-md-4">
<button class="btn btn-dark">بحث</button>
<a href="{{ url('/reports/employees') }}" class="btn btn-secondary">اعادة</a>
<button onclick="window.print()" type="button" class="btn btn-primary" style="margin-right:auto">طباعة</button>
</form>
<table class="table table-bordered text-center">
<thead><tr><th>#</th><th>الرقم الوظيفي</th><th>الاسم</th><th>الرقم الوطني</th><th>الهاتف</th><th>الوظيفة</th><th>القسم</th><th>الولاية</th><th>الراتب</th><th>الأقارب</th></tr></thead>
<tbody>
@forelse($employees as $e)
<tr><td>{{ $loop->iteration }}</td><td>{{ $e->employee_no }}</td><td>{{ $e->name }}</td><td>{{ $e->national_id }}</td><td>{{ $e->phone }}</td><td>{{ $e->job_title }}</td><td>{{ $e->department }}</td><td>{{ $e->state }} - {{ $e->city }}</td><td>{{ $e->salary }}</td><td>{{ $e->relatives_count }}</td></tr>
@empty<tr><td colspan="10">لا يوجد موظفين - /seed-now</td></tr>@endforelse
</tbody>
</table>
</div>
@endsection
