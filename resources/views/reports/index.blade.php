@extends('layouts.main')
@section('title', 'إدارة التقارير')
@section('content')

<div class="container mt-4" style="max-width: 1100px;">
  <h4 class="fw-bold mb-4">إدارة التقارير</h4>
  
  <div class="row g-3">
    <div class="col-12 col-sm-6 col-lg-4">
      <div class="card border-0 shadow-sm h-100 text-center p-3" style="border-radius:16px;">
        <div class="mb-2" style="font-size:28px;">📋</div>
        <h6 class="fw-bold mb-3">تقرير العملاء</h6>
        <a href="/reports/customers" class="btn btn-dark w-100" style="border-radius:10px; font-weight:bold;">فتح</a>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-4">
      <div class="card border-0 shadow-sm h-100 text-center p-3" style="border-radius:16px;">
        <div class="mb-2" style="font-size:28px;">👨‍💼</div>
        <h6 class="fw-bold mb-3">تقرير الموظفون</h6>
        <a href="/reports/employees" class="btn btn-dark w-100" style="border-radius:10px; font-weight:bold;">فتح</a>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-4">
      <div class="card border-0 shadow-sm h-100 text-center p-3" style="border-radius:16px;">
        <div class="mb-2" style="font-size:28px;">📦</div>
        <h6 class="fw-bold mb-3">تقرير المخزون</h6>
        <a href="/reports/products" class="btn btn-dark w-100" style="border-radius:10px; font-weight:bold;">فتح</a>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-4">
      <div class="card border-0 shadow-sm h-100 text-center p-3" style="border-radius:16px;">
        <div class="mb-2" style="font-size:28px;">💰</div>
        <h6 class="fw-bold mb-3">تقرير المبيعات</h6>
        <a href="/reports/sales" class="btn btn-dark w-100" style="border-radius:10px; font-weight:bold;">فتح</a>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-4">
      <div class="card border-0 shadow-sm h-100 text-center p-3" style="border-radius:16px;">
        <div class="mb-2" style="font-size:28px;">📊</div>
        <h6 class="fw-bold mb-3">التقرير المتخصص</h6>
        <a href="/reports/custom" class="btn btn-dark w-100" style="border-radius:10px; font-weight:bold;">فتح</a>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-4">
      <div class="card border-0 shadow-sm h-100 text-center p-3" style="border-radius:16px;">
        <div class="mb-2" style="font-size:28px;">🔍</div>
        <h6 class="fw-bold mb-3">تقرير حسب الحقول</h6>
        <a href="/reports/filter" class="btn btn-dark w-100" style="border-radius:10px; font-weight:bold;">فتح</a>
      </div>
    </div>
  </div>
</div>

@endsection
