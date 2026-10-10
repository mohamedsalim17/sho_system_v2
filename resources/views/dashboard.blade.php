@extends('layouts.main')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
<div>
<h2 style="font-size:32px;color:#111">لوحة التحكم</h2>
<p style="color:#6d614f;margin-top:4px">مرحبا بك - النظام شغال | 26-09-2026</p>
</div>
<a href="/invoices/create" style="background:#111;color:#e9d7b0;padding:13px 22px;border-radius:14px;text-decoration:none;font-weight:800">+ إنشاء فاتورة</a>
</div>

{{-- 4 كروت نظيفة --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px">
<div style="background:#fff;border-radius:18px;padding:24px;text-align:center;box-shadow:0 8px 24px rgba(0,0,0,.06)">
<h1 style="font-size:42px">{{$employees}}</h1><p style="color:#8a7d65;margin-top:4px">الموظفون</p>
<a href="/employees" style="display:block;margin-top:14px;background:#f6f0e2;padding:9px;border-radius:10px;text-decoration:none;color:#111;font-weight:700;font-size:14px">إدارة الموظفون</a>
</div>
<div style="background:#fff;border-radius:18px;padding:24px;text-align:center;box-shadow:0 8px 24px rgba(0,0,0,.06)">
<h1 style="font-size:42px">{{$customers}}</h1><p style="color:#8a7d65;margin-top:4px">العملاء</p>
<a href="/customers" style="display:block;margin-top:14px;background:#f6f0e2;padding:9px;border-radius:10px;text-decoration:none;color:#111;font-weight:700;font-size:14px">إدارة العملاء</a>
</div>
<div style="background:#fff;border-radius:18px;padding:24px;text-align:center;box-shadow:0 8px 24px rgba(0,0,0,.06)">
<h1 style="font-size:42px">{{$products}}</h1><p style="color:#8a7d65;margin-top:4px">الأصناف</p>
<a href="/products" style="display:block;margin-top:14px;background:#f6f0e2;padding:9px;border-radius:10px;text-decoration:none;color:#111;font-weight:700;font-size:14px">إدارة الأصناف</a>
</div>
<div style="background:#fff;border-radius:18px;padding:24px;text-align:center;box-shadow:0 8px 24px rgba(0,0,0,.06)">
<h1 style="font-size:42px">{{$invoices}}</h1><p style="color:#8a7d65;margin-top:4px">الفواتير</p>
<a href="/invoices" style="display:block;margin-top:14px;background:#111;color:#e9d7b0;padding:9px;border-radius:10px;text-decoration:none;font-weight:700;font-size:14px">عرض الفواتير</a>
</div>
<!-- كرت التقارير - نفس استايل الفواتير بالضبط -->
<div class="col-md-3">
  <div class="card text-center p-3" style="border-radius: 20px; border: none; background: white;">
    <h1 style="font-weight: bold; font-size: 48px;">6</h1>
    <p class="text-muted" style="margin-top: -10px;">التقارير</p>
    <div style="background: black; border-radius: 12px; padding: 10px; margin-top: 10px;">
      <a href="/reports" style="text-decoration: none; color: white; font-weight: bold;">إدارة التقارير</a>
    </div>
  </div>
</div>
</div>

{{-- شريط اجراءات واحد مرتب بلون واحد --}}
<div style="background:#fff;border-radius:18px;padding:18px 20px;margin-top:22px;display:flex;gap:10px;align-items:center">
<span style="font-weight:800;color:#111;margin-left:10px">إجراءات سريعة:</span>
<a href="/employees/create" style="background:#f6f0e2;color:#111;padding:10px 16px;border-radius:10px;text-decoration:none;font-size:14px">إضافة موظف</a>
<a href="/customers/create" style="background:#f6f0e2;color:#111;padding:10px 16px;border-radius:10px;text-decoration:none;font-size:14px">إضافة عميل</a>
<a href="/products/create" style="background:#f6f0e2;color:#111;padding:10px 16px;border-radius:10px;text-decoration:none;font-size:14px">إضافة صنف</a>
<div style="flex:1"></div>
<button onclick="openR()" style="background:#4a7c59;color:#fff;padding:8px 14px;border:none;border-radius:8px;cursor:pointer">التقارير</button>
<a href="/users" style="background:#fff;border:1px solid #ddd;color:#111;padding:10px 16px;border-radius:10px;text-decoration:none;font-size:14px">اليوزر</a>
</div>
<style>#rSlide{position:fixed;top:0;right:-360px;width:330px;height:100%;background:#fff;z-index:99999;transition:0.3s;direction:rtl;padding:18px;box-shadow:-5px 0 20px #0002;overflow:auto}#rSlide.on{right:0}#rOver{position:fixed;inset:0;background:#0005;z-index:99998;display:none}#rOver.on{display:block}.rBtn{display:block;width:100%;padding:13px;margin:9px 0;border-radius:10px;text-decoration:none;font-weight:bold;border:none;cursor:pointer;text-align:right}</style>
<div id="rOver" onclick="closeR()"></div>
<div id="rSlide">
<div style="display:flex;justify-content:space-between;align-items:center"><h3>📑 التقارير</h3><button onclick="closeR()" style="border:none;background:#eee;width:30px;height:30px;border-radius:50%;cursor:pointer">X</button></div>
<a href="/reports/general" class="rBtn" style="background:#e8f5e9;color:#2e7d32">📄 تقرير عام<br><small>كل الموظفين - طباعة A4 صفحتين</small></a>
<a href="/reports/custom" class="rBtn" style="background:#e3f2fd;color:#1565c0">🧩 تقرير مخصص<br><small>تختار الحقول</small></a>
<a href="/reports/builder" class="rBtn" style="background:#fff3e0;color:#e65100">🔍 تقرير مفلتر + فترة<br><small>فلتر لكل عمود + من/إلى</small></a>
</div>
<script>function openR(){document.getElementById('rSlide').classList.add('on');document.getElementById('rOver').classList.add('on')}function closeR(){document.getElementById('rSlide').classList.remove('on');document.getElementById('rOver').classList.remove('on')}</script>

{{-- جدول --}}
<div style="background:#fff;border-radius:18px;padding:22px;margin-top:20px">
<h3 style="margin-bottom:12px">آخر الفواتير</h3>
<table style="width:100%;border-collapse:collapse">
<tr style="background:#fbf7ec"><th>#</th><th>العميل</th><th>المبلغ</th><th>الاجراء</th></tr>
@forelse($latestInvoices as $inv)
<tr style="border-bottom:1px solid #eee"><td>{{$inv->id}}</td><td>{{$inv->customer->name ?? '-'}}</td><td>{{$inv->total ?? 0}}</td><td><a href="/invoices/{{$inv->id}}/edit" style="color:#111;text-decoration:none;font-weight:700">تعديل</a></td></tr>
@empty<tr><td colspan="4" style="padding:20px;color:#999">لا يوجد فواتير</td></tr>@endforelse
</table>
</div>
@endsection
