<!DOCTYPE html><html dir="rtl" lang="ar"><head><meta charset="UTF-8"><title>تقرير مفلتر</title>
<style>body{font-family:Tahoma;direction:rtl;background:#f4f6f9;padding:12px} .card{background:#fff;padding:12px;border-radius:10px;margin-bottom:10px} .grid{display:grid;grid-template-columns:repeat(4,1fr);gap:8px} input,select{width:100%;padding:7px;border:1px solid #ccc;border-radius:6px} th,td{border:1px solid #444;padding:5px;font-size:11px;text-align:center} th{background:#2d4a22;color:#fff} table{width:100%;border-collapse:collapse} .btn{padding:8px 14px;border-radius:6px;border:none;font-weight:bold;cursor:pointer} @media print{.no-print{display:none}}</style>
</head><body>
<div class="card no-print"><a href="/" class="btn" style="background:#eee">رجوع</a> <b>🔍 تقرير مفلتر + فترة</b></div>

<div class="card no-print">
<form method="GET" action="{{ url('/reports/builder') }}">
<div class="grid">
@foreach($allColumns as $col)
<div><label style="font-size:11px;font-weight:bold">{{$col}}</label><input type="text" name="{{$col}}" value="{{ request($col) }}" placeholder="فلتر {{$col}}"></div>
@endforeach
<div><label style="font-size:11px;font-weight:bold">من تاريخ</label><input type="date" name="from_date" value="{{ request('from_date') }}"></div>
<div><label style="font-size:11px;font-weight:bold">إلى تاريخ</label><input type="date" name="to_date" value="{{ request('to_date') }}"></div>
</div>
<div style="margin-top:10px;display:flex;gap:8px;flex-wrap:wrap">
<button type="submit" class="btn" style="background:#2d4a22;color:#fff">🔍 بحث وفلترة</button>
<a href="{{ url('/reports/builder') }}" class="btn" style="background:#eee">مسح الفلتر</a>
<button type="button" onclick="window.print()" class="btn" style="background:#222;color:#fff">🖨️ طباعة A4</button>
<span style="margin-right:auto;background:#e8f5e9;padding:6px 12px;border-radius:20px">العدد: {{ $employees->count() }}</span>
</div>
<div style="margin-top:10px"><b>اختر الأعمدة:</b><br>
@foreach($allColumns as $col)<label style="margin-left:10px;font-size:12px"><input type="checkbox" name="columns[]" value="{{$col}}" {{ in_array($col,$selectedColumns)?'checked':'' }}> {{$col}}</label>@endforeach
</div>
</form>
</div>

<div class="card"><table><thead><tr>@foreach($selectedColumns as $c)<th>{{$c}}</th>@endforeach</tr></thead>
<tbody>@foreach($employees as $e)<tr>@foreach($selectedColumns as $c)<td>{{ $e->$c }}</td>@endforeach</tr>@endforeach</tbody></table></div>
</body></html>
