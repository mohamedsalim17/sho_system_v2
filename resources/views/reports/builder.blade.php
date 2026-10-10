@extends('layouts.app')
@section('content')
<div style="padding:15px;max-width:100%;overflow:hidden" dir="rtl">

<h3 style="margin-bottom:10px">بناء التقرير حسب قيمة الحقل</h3>

<form method="GET" style="background:#f8f9fa;padding:12px;border:1px solid #ddd;border-radius:6px">
<div style="display:flex;flex-wrap:wrap;gap:8px">
@foreach($allColumns as $col=>$lab)
<div style="flex:1 1 150px;min-width:150px">
<label style="font-size:12px;font-weight:bold">{{ $lab }}</label>
@if(isset($filterData[$col]) && $filterData[$col]->count())
<select name="{{ $col }}" style="width:100%;padding:4px">
<option value="">كل {{ $lab }}</option>
@foreach($filterData[$col] as $v)
<option value="{{ $v }}" {{ request($col)==$v?'selected':'' }}>{{ $v }}</option>
@endforeach
</select>
@else
<input type="{{ str_contains($col,'date')?'date':'text' }}" name="{{ $col }}" value="{{ request($col) }}" style="width:100%;padding:4px" placeholder="{{ $lab }}">
@endif
</div>
@endforeach
</div>
<div style="margin-top:10px">
<button type="submit" style="background:#0d6efd;color:#fff;border:none;padding:6px 18px;border-radius:4px">بحث</button>
<a href="{{ url('reports/builder') }}" style="background:#6c757d;color:#fff;padding:6px 18px;border-radius:4px;text-decoration:none">عرض الكل</a>
</div>
</form>

<form method="GET" style="margin-top:12px;background:#fff;padding:10px;border:1px solid #eee;border-radius:6px">
@foreach(request()->except('columns') as $k=>$v)<input type="hidden" name="{{ $k }}" value="{{ $v }}">@endforeach
<div style="font-weight:bold;margin-bottom:6px">الأعمدة الظاهرة:</div>
<div style="display:flex;flex-wrap:wrap;gap:8px">
@foreach($allColumns as $col=>$lab)
<label style="font-size:12px;width:130px"><input type="checkbox" name="columns[]" value="{{ $col }}" {{ in_array($col,$selectedColumns)?'checked':'' }}> {{ $lab }}</label>
@endforeach
</div>
</form>

<div style="margin-top:15px;overflow-x:auto;border:1px solid #ddd;border-radius:6px">
<table style="width:100%;border-collapse:collapse;white-space:nowrap;font-size:13px">
<thead>
<tr style="background:#212529;color:#fff">
<th style="padding:8px">#</th>
@foreach($selectedColumns as $c)<th style="padding:8px">{{ $allColumns[$c] }}</th>@endforeach
</tr>
</thead>
<tbody>
@forelse($employees as $i=>$e)
<tr style="border-bottom:1px solid #eee">
<td style="padding:6px">{{ $i+1 }}</td>
@foreach($selectedColumns as $c)<td style="padding:6px">{{ $e->$c }}</td>@endforeach
</tr>
@empty
<tr><td colspan="30" style="text-align:center;padding:15px">لا يوجد نتائج</td></tr>
@endforelse
</tbody>
</table>
</div>

<div style="margin-top:15px;padding:10px;background:#f8f9fa;border-top:2px solid #212529;text-align:center;font-size:12px">
تم بناء التقرير بعدد {{ $employees->count() }} سجل - نظام إدارة الموظفين v2 | {{ date('Y-m-d') }}
</div>
<div style="margin-top:10px;display:flex;gap:8px;flex-wrap:wrap">
<button type="submit" style="background:#0d6efd;color:#fff;border:none;padding:6px 18px;border-radius:4px">بحث</button>
<a href="{{ url('reports/builder') }}" style="background:#6c757d;color:#fff;padding:6px 18px;border-radius:4px;text-decoration:none">عرض الكل</a>

<button type="button" onclick="window.print()" style="background:#212529;color:#fff;border:none;padding:6px 18px;border-radius:4px">🖨️ طباعة</button>

<a href="{{ url('reports/excel') }}?{{ http_build_query(request()->all()) }}" style="background:#198754;color:#fff;padding:6px 18px;border-radius:4px;text-decoration:none">📊 Excel</a>

<a href="{{ url('reports/pdf') }}?{{ http_build_query(request()->all()) }}" target="_blank" style="background:#dc3545;color:#fff;padding:6px 18px;border-radius:4px;text-decoration:none">📄 PDF</a>
</div>

</div>
@endsection
