<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
<meta charset="UTF-8">
<title>التقرير الشامل</title>
<style>
*{font-family:Tahoma;box-sizing:border-box}
body{background:#f5f1e8;margin:0;padding:15px}
.card{background:#fff;border-radius:10px;padding:12px;margin-bottom:12px}
.row{display:flex;gap:8px;flex-wrap:wrap}
.col{flex:1;min-width:140px}
input{width:100%;padding:8px;border:1px solid #ccc;border-radius:5px}
.btn{padding:8px 16px;border:none;border-radius:5px;color:#fff;font-weight:bold;cursor:pointer}
.btn-g{background:#4a7c59}.btn-d{background:#222}.btn-e{background:#1d6f42}
.table-wrap{overflow-x:auto;background:#fff;border-radius:10px}
table{width:100%;border-collapse:collapse;min-width:1100px}
th,td{border:1px solid #444;padding:6px;font-size:12px;white-space:nowrap;text-align:center}
th{background:#2d4a22;color:#fff}
tr:nth-child(even){background:#f9f6ef}

/* طباعة A4 بالعرض */
@page { size: A4 landscape; margin: 10mm; }
@media print{
.no-print{display:none}
body{background:#fff;padding:0}
.table-wrap{overflow:visible}
table{min-width:100%;font-size:10px}
th{background:#000 !important;color:#fff !important;-webkit-print-color-adjust:exact}
}
</style>
</head>
<body>

@php
$labels = [
'id'=>'م','employee_no'=>'الرقم الوظيفي','national_id'=>'الرقم الوطني','name'=>'الاسم',
'phone'=>'الهاتف','birth_date'=>'تاريخ الميلاد','death_date'=>'تاريخ الوفاة','death_place'=>'مكان الوفاة',
'marital_status'=>'الحالة الاجتماعية','job_title'=>'الوظيفة','department'=>'القسم','salary'=>'المرتب',
'hire_date'=>'تاريخ التعيين','state'=>'الولاية','city'=>'المدينة','neighborhood'=>'الحي','street'=>'الشارع',
'created_at'=>'تاريخ الاضافة','updated_at'=>'اخر تحديث','address'=>'السكن','gender'=>'النوع'
];
$marital = ['single'=>'أعزب','married'=>'متزوج','divorced'=>'مطلق','widowed'=>'أرمل'];
@endphp

<h3 style="text-align:center">📊 التقرير الشامل - sho_system_v2 | ورق A4 - عرضي</h3>

<div class="card no-print">
<form method="GET" class="row">
<div class="col"><input name="search" value="{{ request('search') }}" placeholder="بحث بالاسم"></div>
<div class="col"><input name="address" value="{{ request('address') }}" placeholder="السكن"></div>
<div class="col"><input name="job_title" value="{{ request('job_title') }}" placeholder="الوظيفة"></div>
<div class="col" style="flex:0.4"><button class="btn btn-g" style="width:100%">عرض</button></div>
</form>
</div>

<div class="no-print" style="margin-bottom:10px;display:flex;gap:8px">
<button onclick="window.print()" class="btn btn-d">🖨️ طباعة A4 عرضي</button>
<a href="{{ route('reports.excel', request()->all()) }}" class="btn btn-e" style="text-decoration:none">📊 Excel</a>
<span style="margin-right:auto;background:#fff;padding:6px 10px;border-radius:5px">العدد: {{ $employees->count() }}</span>
</div>

<div class="table-wrap">
<table>
<tr><th>#</th>
@foreach($columns as $col)
@if(!in_array($col,['id'])) {{-- نتخطى الـ id المكرر --}}
<th>{{ $labels[$col] ?? $col }}</th>
@endif
@endforeach
</tr>
@foreach($employees as $e)
<tr><td>{{ $loop->iteration }}</td>
@foreach($columns as $col)
@if(!in_array($col,['id']))
<td>
@php $val = $e->$col; @endphp
@if($col=='marital_status') {{ $marital[$val] ?? $val }}
@elseif(str_contains($col,'date') && $val) {{ \Carbon\Carbon::parse($val)->format('Y-m-d') }}
@else {{ $val }} @endif
</td>
@endif
@endforeach
</tr>
@endforeach
</table>
</div>

<p class="no-print" style="text-align:center;margin-top:10px;font-size:12px">💡 عند الطباعة اختار Orientation: Landscape عشان يطلع بعرض الورقة كامل</p>

</body>
</html>
