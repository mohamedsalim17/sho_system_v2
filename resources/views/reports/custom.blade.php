@extends('layouts.main')
@section('content')

<style>
.card2{background:#fff;border-radius:10px;padding:15px;margin-bottom:12px;box-shadow:0 2px 5px #0001}
.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:8px}
.check{border:1px solid #ccc;padding:8px;border-radius:6px;background:#faf7f0;cursor:pointer;display:flex;gap:6px;align-items:center}
.check input{width:18px;height:18px}
.btn{padding:10px 18px;border:none;border-radius:6px;color:#fff;font-weight:bold;cursor:pointer}
.btn-g{background:#4a7c59}.btn-d{background:#222}
.table-wrap{overflow-x:auto;background:#fff;border-radius:10px}
table{width:100%;border-collapse:collapse;min-width:800px}
th,td{border:1px solid #444;padding:6px;font-size:12px;text-align:center;white-space:nowrap}
th{background:#2d4a22;color:#fff}
</style>

<h3>🛠️ التقرير المخصص - اختار اكثر من 4 حقول</h3>

<div class="card2">
<form method="GET">
<p><b>اختار الحقول:</b> (علّم اكتر من 4)</p>
<div class="grid">
@foreach($allColumns as $col)
@if($col!='id' && $col!='updated_at')
<label class="check">
<input type="checkbox" name="fields[]" value="{{ $col }}" {{ in_array($col,$selected) ? 'checked' : '' }}>
{{ $labels[$col] ?? $col }}
</label>
@endif
@endforeach
</div>
<div style="margin-top:12px;display:flex;gap:8px">
<input name="search" value="{{ request('search') }}" placeholder="بحث بالاسم" style="flex:1;padding:8px;border-radius:5px;border:1px solid #ccc">
<button class="btn btn-g">🔍 إنشاء التقرير ({{ count($selected) }} حقل)</button>
</div>
</form>
</div>

@if(count($employees)>0)
<div style="display:flex;gap:8px;margin-bottom:10px">
<button onclick="window.print()" class="btn btn-d">🖨️ طباعة</button>
<span style="margin-right:auto;background:#fff;padding:8px 12px;border-radius:6px">العدد: {{ $employees->count() }} | الحقول: {{ count($selected) }}</span>
</div>

<div class="table-wrap">
<table>
<tr><th>#</th>
@foreach($selected as $col)
<th>{{ $labels[$col] ?? $col }}</th>
@endforeach
</tr>
@foreach($employees as $e)
<tr><td>{{ $loop->iteration }}</td>
@foreach($selected as $col)
<td>{{ $e->$col }}</td>
@endforeach
</tr>
@endforeach
</table>
</div>
@endif

@endsection
