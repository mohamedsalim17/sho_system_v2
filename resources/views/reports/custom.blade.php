<!DOCTYPE html>
<html dir="rtl"><head><meta charset="UTF-8"><style>body{font-family:Tahoma;background:#f4f4f9;padding:15px}.card{background:#fff;padding:15px;border-radius:10px;overflow:auto} table{width:100%;border-collapse:collapse;margin-top:10px} th,td{border:1px solid #ddd;padding:8px;text-align:center;font-size:13px} th{background:#111;color:#fff}</style></head><body>
<div class="card">
<h3>تقرير مخصص - الفواتير والعملاء</h3>
<form method="GET" style="margin-bottom:10px">
<select name="customer_id"><option value="">كل العملاء ({{ $customers->count() }})</option>@foreach($customers as $c)<option value="{{ $c->id }}" {{ request('customer_id')==$c->id?'selected':'' }}>{{ $c->name }} - {{ $c->phone }}</option>@endforeach</select>
<input type="date" name="from" value="{{ request('from') }}"> <input type="date" name="to" value="{{ request('to') }}">
<button style="background:#111;color:#fff;padding:5px 12px">بحث</button>
</form>
<table><tr><th>#</th><th>العميل</th><th>تلفون العميل</th><th>رقم الفاتورة</th><th>المبلغ</th><th>الخصم</th><th>الصافي</th><th>التاريخ</th></tr>
@forelse($results as $r)<tr><td>{{ $r->id }}</td><td>{{ $r->customer->name ?? 'نقدي' }}</td><td>{{ $r->customer->phone ?? '-' }}</td><td>{{ $r->invoice_number ?? $r->id }}</td><td>{{ $r->total_amount }}</td><td>{{ $r->discount ?? 0 }}</td><td>{{ $r->final_amount ?? $r->total_amount }}</td><td>{{ $r->invoice_date }}</td></tr>
@empty<tr><td colspan="8">لا توجد فواتير</td></tr>@endforelse
<tr style="background:#eee;font-weight:bold"><td colspan="4">الإجمالي</td><td colspan="4">{{ $total }}</td></tr>
</table>
</div></body></html>
