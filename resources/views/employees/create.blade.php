@extends('layouts.app') {{-- لو عندك لاي اوت --}}

@section('content')
<div class="container mt-4" dir="rtl">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>اضافة موظف جديد</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('employees.store') }}">
            @csrf

            <h5 class="text-primary border-bottom pb-2 mb-3">البيانات الاساسية</h5>
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">الرقم الوظيفي *</label>
                    <input type="text" name="employee_no" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">الرقم الوطني</label>
                    <input type="text" name="national_id" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">الاسم الكامل *</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">تاريخ الميلاد</label>
                    <input type="date" name="birth_date" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">تاريخ التعيين</label>
                    <input type="date" name="hire_date" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">تاريخ الوفاة</label>
                    <input type="date" name="death_date" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">الحالة الاجتماعية</label>
                    <select name="marital_status" class="form-select">
                        <option value="">اختر</option>
                        <option value="اعزب">اعزب</option>
                        <option value="متزوج">متزوج</option>
                        <option value="مطلق">مطلق</option>
                        <option value="ارمل">ارمل</option>
                    </select>
                </div>
            </div>

            <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">بيانات العمل</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">الوظيفة</label>
                    <input type="text" name="job_title" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">القسم</label>
                    <input type="text" name="department" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">الراتب</label>
                    <input type="number" name="salary" class="form-control">
                </div>
                <div class="col-md-12">
                    <label class="form-label">الهاتف</label>
                    <input type="text" name="phone" class="form-control">
                </div>
            </div>

            <h5 class="text
<div class="card-footer bg-dark text-white d-flex justify-content-between align-items-center mt-4">
    
    <!-- الازرار اليسار -->
    <div>
        <button type="button" class="btn btn-outline-light btn-sm">المنتجات</button>
        <button type="button" class="btn btn-outline-light btn-sm">الاتصال</button>
        <button type="button" class="btn btn-outline-light btn-sm">الفواتير</button>
    </div>

    <!-- زر الحفظ اليمين -->
    <div>
        <button type="submit" class="btn btn-primary">
            💾 حفظ الموظف
        </button>
        <a href="{{ route('employees.index') }}" class="btn btn-secondary">الغاء</a>
    </div>

</div>
