@extends('layouts.app')
@section('content')
<div class="container py-4" dir="rtl">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4 p-3">
            <h4 class="mb-0">➕ إضافة عميل جديد</h4>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('customers.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">الاسم الكامل *</label>
                        <input type="text" name="name" class="form-control rounded-3" value="{{ old('name') }}" required placeholder="مثال: محمد أحمد">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">رقم الهاتف</label>
                        <input type="text" name="phone" class="form-control rounded-3" value="{{ old('phone') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">الرقم الوطني</label>
                        <input type="text" name="national_id" class="form-control rounded-3" value="{{ old('national_id') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">النوع</label>
                        <select name="gender" class="form-select rounded-3">
                            <option value="">اختر</option>
                            <option value="ذكر">ذكر</option>
                            <option value="انثى">أنثى</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">تاريخ الميلاد</label>
                        <input type="date" name="birth_date" class="form-control rounded-3" value="{{ old('birth_date') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">الولاية</label>
                        <input type="text" name="state" class="form-control rounded-3" value="{{ old('state') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">المدينة</label>
                        <input type="text" name="city" class="form-control rounded-3" value="{{ old('city') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">المستوى التعليمي</label>
                        <input type="text" name="education_level" class="form-control rounded-3" value="{{ old('education_level') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">المهنة</label>
                        <input type="text" name="job" class="form-control rounded-3" value="{{ old('job') }}">
                    </div>
                </div>

                <hr class="my-4">
                <h5 class="text-danger">بيانات الوفاة - إن وجدت</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">تاريخ الوفاة</label>
                        <input type="date" name="date_of_death"  max="{{date'Y-m-d')}}"(class="form-control rounded-3">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">مكان الوفاة</label>
                        <input type="text" name="place_of_death" class="form-control rounded-3">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">العنوان بالتفصيل</label>
                    <input type="text" name="address" class="form-control rounded-3" value="{{ old('address') }}" placeholder="الحي، المربع، رقم المنزل">
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary px-5 rounded-3">💾 حفظ العميل</button>
                    <a href="{{ route('customers.index') }}" class="btn btn-light border px-4 rounded-3">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
