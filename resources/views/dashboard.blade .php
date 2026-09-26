@extends('layouts.app')
@section('content')

{{-- ملخص فوق --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:15px">
<div class="card" style="border-right:5px solid #2563eb"><small>إجمالي المبيعات</small><h2>{{ $stats['sales_all'] }} ج</h2><small>اليوم: {{ $stats['sales_today'] }} ج</small></div>
<div class="card" style="border-right:5px solid #16a34a"><small>الخزنة</small><h2>{{ $stats['treasury'] }} ج</h2><small>رصيد حالي</small></div>
<div class="card" style="border-right:5px solid #f59e0b"><small>قيمة المخزن</small><h2>{{ $stats['stock_value'] }} ج</h2><small>{{ $stats['products'] }} صنف</small></div>
<div class="card" style="border-right:5px solid #4a1a22"><small>العملاء / الموظفين</small><h2>{{ $stats['customers'] }} / {{ $stats['employees'] }}</h2><small>{{ $stats['invoices'] }} فاتورة</small></div>
</div>

{{-- أزرار سريعة --}}
<div style="display:grid;grid-template-columns:repeat(5,1fr);gap:10px;margin:20px 0">
<a href="{{ route('products.index') }}" class="card" style="text-align:center;text-decoration:none;color:#000;padding:15px">📦<br><b>الأصناف</b><br><small>{{ $stats['products'] }}</small></a>
<a href="{{ route('customers.index') }}" class="card" style="text-align:center;text-decoration:none;color:#000;padding:15px">👥<br><b>العملاء</b><br><small>{{ $stats['customers'] }}</small></a>
<a href="{{ route('invoices.index') }}" class="card" style="text-align:center;text-decoration:none;color:#000;padding:15px">🧾<br><b>الفواتير</b><br><small>{{ $stats['invoices'] }}</small></a>
<div class="card" style="text-align:center;padding:15px">👷<br><b>الموظفين</b><br><small>{{ $stats['employees'] }}</small></div>
<div class="card" style="text-align:center;padding:15px">💰<br><b>الخزنة</b><br><small>{{ $stats['treasury'] }} ج</small></div>
</div>

{{-- صفين تحت --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:15px">
<div class="card">
<h3>⚠️ موقف الأصناف - ناقصة</h3>
<table><tr><th>الصنف</th><th>الكمية</th><th>الحالة</th></tr>
@forelse($lowStock as $p)<tr><td>{{ $p->name }}</td><td>{{ $p->quantity }}</td><td style="color:red">ناقص</td></tr>
@empty<tr><td colspan="3" style="text-align:center">المخزن تمام ✅</td></tr>@endforelse
</table>
</div>

<div class="card">
<h3>📦 جرد المخزن - آخر 5 أصناف</h3>
<table><tr><th>الصنف</th><th>الكمية</th><th>السعر</th></tr>
@forelse($latestProducts as $p)<tr><td>{{ $p->name }}</td><td>{{ $p->quantity }}</td><td>{{ $p->price }}</td></tr>
@empty<tr><td colspan="3" style="text-align:center">لا يوجد</td></tr>@endforelse
</table>
</div>
</div>

<div class="card" style="margin-top:15px">
<h3>🧾 آخر عمليات البيع</h3>
<table><tr><th>#</th><th>العميل</th><th>الإجمالي</th><th>التاريخ</th></tr>
@forelse($latestInvoices as $inv)<tr><td>{{ $inv->id }}</td><td>{{ $inv->customer_id }}</td><td>{{ $inv->total }}</td><td>{{ $inv->created_at->format('Y-m-d') }}</td></tr>
@empty<tr><td colspan="4" style="text-align:center">لا يوجد فواتير بعد</td></tr>@endforelse
</table>
</div>

@endsection
