@extends('layouts.main')
@section('content')
<div class="p-4">
<div class="flex justify-between mb-4 print:hidden">
<div class="flex gap-2">
<a href="{{route('reports.index')}}" class="bg-gray-600 text-white px-3 py-1 rounded">رجوع للتقارير</a>
<a href="{{route('dashboard')}}" class="bg-black text-white px-3 py-1 rounded">الدشبورد</a>
</div>
<div class="flex gap-2">
<button onclick="window.print()" class="bg-blue-600 text-white px-4 py-1 rounded">طباعة</button>
<a href="{{route('reports.excel', request()->all())}}" class="bg-green-600 text-white px-4 py-1 rounded">Excel</a>
<a href="{{route('reports.export', request()->all())}}" target="_blank" class="bg-red-600 text-white px-4 py-1 rounded">PDF</a>
</div>
</div>

<form class="flex gap-2 mb-4 print:hidden">
<input name="search" value="{{request('search')}}" placeholder="بحث" class="border p-1 rounded">
<input type="date" name="from_date" value="{{request('from_date')}}" class="border p-1 rounded">
<input type="date" name="to_date" value="{{request('to_date')}}" class="border p-1 rounded">
<button class="bg-blue-500 text-white px-3 rounded">بحث</button>
</form>

<table class="w-full border text-sm">
<thead><tr class="bg-gray-100">
<th class="border p-2">الرقم</th><th class="border p-2">الاسم</th><th class="border p-2">الادارة</th><th class="border p-2">الحالة</th><th class="border p-2">تاريخ الوفاة</th><th class="border p-2">مكان الوفاة</th>
</tr></thead>
<tbody>
@foreach($employees as $e)
<tr><td class="border p-2">{{$e->employee_no}}</td><td class="border p-2">{{$e->name}}</td><td class="border p-2">{{$e->department}}</td><td class="border p-2">{{$e->status}}</td><td class="border p-2">{{$e->death_date}}</td><td class="border p-2">{{$e->death_place}}</td></tr>
@endforeach
</tbody>
</table>
</div>
<style>@media print{.print\:hidden{display:none}}</style>
@endsection
