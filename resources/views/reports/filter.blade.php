<!DOCTYPE html>
<html dir="rtl"><head><meta charset="UTF-8"><style>body{font-family:Tahoma;background:#f4f4f9;padding:15px}.card{background:#fff;padding:15px;border-radius:10px;overflow:auto} table{width:100%;border-collapse:collapse;margin-top:10px} th,td{border:1px solid #ddd;padding:8px;text-align:center;font-size:13px} th{background:#111;color:#fff}</style></head><body>
<div class="card">
<h3>تقرير حسب الحقل - ({{ $employees->count() }})</h3>
<form method="GET" style="margin-bottom:10px">
<select name="field">
@foreach(['name'=>'الاسم','employee_no'=>'رقم الموظف','national_id'=>'الرقم الوطني','department'=>'القسم','city'=>'المدينة','state'=>'الولاية','phone'=>'الهاتف'] as $k=>$v)
<option value="{{ $k }}" {{ request('field')==$k?'selected':'' }}>{{ $v }}</option>
@endforeach
</select>
<input type="text" name="value" value="{{ request('value') }}" placeholder="ابحث...">
<button style="background:#111;color:#fff;padding:5px 12px">فلتر</button>
<a href="{{ url('reports/filter') }}" style="background:#888;color:#fff;padding:5px 12px;text-decoration:none">عرض الكل</a>
</form>

@if($employees->count())
<table>
<tr>
<th>م</th><th>الاسم</th><th>رقم الموظف</th><th>الرقم الوطني</th><th>القسم</th><th>المدينة</th><th>الولاية</th><th>الهاتف</th><th>الراتب</th>
</tr>
@foreach($employees as $i=>$e)
<tr>
<td>{{ $i+1 }}</td>
<td>{{ $e->name }}</td>
<td>{{ $e->employee_no ?? '-' }}</td>
<td>{{ $e->national_id ?? '-' }}</td>
<td>{{ $e->department ?? '-' }}</td>
<td>{{ $e->city ?? '-' }}</td>
<td>{{ $e->state ?? '-' }}</td>
<td>{{ $e->phone ?? '-' }}</td>
<td>{{ $e->salary ?? $e->basic_salary ?? '-' }}</td>
</tr>
@endforeach
</table>
@else
<p>لا يوجد موظفون - أضف موظف أولاً من /employees/create</p>
@endif
</div></body></html>
