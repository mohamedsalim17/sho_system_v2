@extends('layouts.main')
@section('content')
<div class="grid">
  <div class="card"><h4>الموظفون</h4><small>{{ $employees ?? 0 }} موظف</small></div>
  <div class="card"><h4>العملاء</h4><small>{{ $customers ?? 0 }} عميل</small></div>
  <div class="card"><h4>المخزون</h4><small>{{ $products ?? 0 }} صنف</small></div>
  <div class="card"><h4>الفواتير</h4><small>{{ $invoices ?? 0 }} فاتورة</small></div>
  <div class="card"><h4>المبيعات</h4><small>0 عملية</small></div>
  <div class="card"><h4>التقارير</h4><small>عرض</small></div>
  <div class="card"><h4>الإعدادات</h4><small>النظام</small></div>
</div>

<div class="white">
  <h3>مرحبا بك في نظام الإدارة - sho_system_v2</h3>
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:15px;margin-top:20px">
    <a href="/employees" class="btn-gold">إدارة الموظفين</a>
    <a href="/customers" class="btn-gold">إدارة العملاء</a>
    <a href="/reports" class="btn-gold">التقارير</a>
  </div>
</div>
@endsection
