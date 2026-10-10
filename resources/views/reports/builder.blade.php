<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Report Builder</title>
<style>
*{box-sizing:border-box;font-family:Tahoma,Arial}
body{margin:0;background:#f2f4f7;padding:14px;direction:rtl}
.card{background:#fff;border-radius:12px;padding:14px;margin-bottom:12px;box-shadow:0 2px 8px rgba(0,0,0,.06)}
h3{margin:0 0 10px 0}
label{font-size:12px;font-weight:bold;display:block;margin-bottom:4px}
input[type=text],input[type=date]{width:100%;padding:9px 10px;border:1px solid #d0d5dd;border-radius:8px;outline:none}
input:focus{border-color:#111}
.row{display:grid;grid-template-columns:repeat(4,1fr);gap:10px}
@media(max-width:800px){.row{grid-template-columns:1fr 1fr}}
.btns{margin-top:12px;display:flex;gap:8px;flex-wrap:wrap}
.btn{padding:9px 16px;border-radius:8px;border:0;cursor:pointer;font-weight:bold}
.btn-black{background:#111;color:#fff}
.btn-gray{background:#eaecf0;color:#111;text-decoration:none;display:inline-block}
.checks{display:grid;grid-template-columns:repeat(4,1fr);gap:6px;margin-top:10px;border-top:1px solid #eee;padding-top:10px}
.checks label{font-weight:normal;display:flex;align-items:center;gap:6px;background:#f9fafb;padding:6px;border-radius:6px}
.table-wrap{overflow:auto;border:1px solid #e5e7eb;border-radius:10px}
table{width:100%;border-collapse:collapse;min-width:1400px}
th,td{border:1px solid #e5e7eb;padding:7px 6px;text-align:center;font-size:12px;white-space:nowrap}
th{background:#111;color:#fff;position:sticky;top:0}
</style>
</head>
<body>

<div class="card">
<h3>🔍 تقرير الموظفين - المستخدم يكتب قيمة الحقل</h3>
<p style="color:#667085;font-size:12px;margin:0 0 10px 0">أكتب القيمة الجوة الحقل (مثلا أكتب الخرطوم في الولاية، المبيعات في القسم)</p>

<form method="GET" action="{{ url('/reports/builder') }}">
<div class="row">
<div><label>قيمة القسم</label><input type="text" name="department" value="{{ request('department') }}" placeholder="مثلا: المبيعات"></div>
<div><label>قيمة الولاية</label><input type="text" name="state" value="{{ request('state') }}" placeholder="مثلا: الخرطوم"></div>
<div><label>قيمة المدينة</label><input type="text" name="city" value="{{ request('city') }}" placeholder="مثلا: أمدرمان"></div>
<div><label>قيمة المسمى الوظيفي</label><input type="text" name="job_title" value="{{ request('job_title') }}" placeholder="مثلا: مندوب"></div>
<div><label>من تاريخ تعيين</label><input type="date" name="from_date" value="{{ request('from_date') }}"></div>
<div><label>إلى تاريخ</label><input type="date" name="to_date" value="{{ request('to_date') }}"></div>
</div>

<div class="btns">
<button type="submit" class="btn btn-black">بحث بالقيم</button>
<a href="{{ url('/reports/builder') }}" class="btn btn-gray">مسح</a>
<span style="margin-right:auto;background:#ecfdf3;padding:8px 12px;border-radius:20px;font-size:12px">العدد: {{ $employees->count() }}</span>
</div>

<div class="checks">
@foreach($allColumns as $k=>$lbl)
<label><input type="checkbox" name="columns[]" value="{{ $k }}" {{ in_array($k,$selectedColumns)?'checked':'' }}> {{ $lbl }}</label>
@endforeach
</div>

</form>
</div>

<div class="card table-wrap">
<table>
<thead><tr>@foreach($selectedColumns as $c)<th>{{ $allColumns[$c] }}</th>@endforeach</tr></thead>
<tbody>
@forelse($employees as $e)
<tr>@foreach($selectedColumns as $c)<td>{{ $e->$c }}</td>@endforeach</tr>
@empty
<tr><td colspan="{{ count($selectedColumns) }}">لا توجد بيانات - افتح /seed-now أولاً</td></tr>
@endforelse
</tbody>
</table>
</div>

</body>
</html>
