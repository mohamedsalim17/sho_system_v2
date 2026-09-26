@extends('layouts.main')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
<h2 style="font-size:28px">إدارة الموظفون</h2>
<a href="/employees/create" style="background:#111;color:#e9d7b0;padding:11px 18px;border-radius:12px;text-decoration:none;font-weight:700">+ إضافة موظف</a>
</div>

<div style="background:#fff;border-radius:18px;padding:20px">
<table style="width:100%;border-collapse:collapse">
<tr style="background:#fbf7ec"><th>#</th><th>الاسم</th><th>الهاتف</th><th>الوظيفة</th><th>الإجراء</th></tr>
@forelse($employees as $emp)
<tr style="border-bottom:1px solid #eee;text-align:center">
<td style="padding:12px">{{$emp->id}}</td>
<td>{{$emp->name}}</td>
<td>{{$emp->phone ?? '-'}}</td>
<td>{{$emp->job ?? '-'}}</td>
<td style="padding:10px;display:flex;gap:8px;justify-content:center">
<a href="/employees/{{$emp->id}}/edit" style="background:#f6f0e2;color:#111;padding:7px 12px;border-radius:8px;text-decoration:none;font-size:13px">تعديل</a>
<a href="/employees/{{$emp->id}}/relatives" style="background:#fff;border:1px solid #ddd;padding:7px 12px;border-radius:8px;text-decoration:none;color:#111;font-size:13px">الأقارب</a>
</td>
</tr>
@empty
<tr><td colspan="5" style="padding:30px;text-align:center;color:#999">لا يوجد موظفون</td></tr>
@endforelse
</table>
</div>
@endsection
