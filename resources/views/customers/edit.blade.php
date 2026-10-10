@extends('layouts.main')
@section('content')
<div class="container py-4" dir="rtl" style="text-align:right; font-family: 'Tajawal', sans-serif;">
    <div class="card border-0 shadow-sm rounded-4 mx-auto" style="max-width:900px; background:#fff;">
        <div class="card-header bg-white border-0 p-4 pb-0 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold m-0" style="color:#1a1a1a;">{{ isset($customer) ? 'تعديل بيانات العميل' : 'إضافة عميل جديد' }}</h4>
                <small class="text-muted">جميع الحقول التي عليها * مطلوبة</small>
            </div>
            <a href="{{ route('customers.index') }}" class="btn btn-light rounded-pill px-4">رجوع</a>
        </div>

        <div class="card-body p-4">
            @if($errors->any())
            <div class="alert border-0 rounded-3 mb-4" style="background:#fdecea; color:#611a15;">
                @foreach($errors->all() as $error)
                    <div class="mb-1">⚠️ {{ $error }}</div>
                @endforeach
            </div>
            @endif

            <form action="{{ isset($customer) ? route('customers.update', $customer->id) : route('customers.store') }}" method="POST">
                @csrf
                @if(isset($customer)) @method('PUT') @endif

                <h6 class="fw-bold mb-3 mt-2" style="color:#555;">البيانات الأساسية</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">الاسم الكامل *</label>
                        <input type="text" name="name" value="{{ old('name', $customer->name ?? '') }}" class="form-control rounded-3 py-2 text-end" placeholder="مثال: محمد أحمد" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold small">رقم الهاتف</label>
                        <input type="text" name="phone" value="{{ old('phone', $customer->phone ?? '') }}" class="form-control rounded-3 py-2 text-end" placeholder="09xxxxxxxx">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold small">الجنس</label>
                        <select name="gender" class="form-select rounded-3 py-2 text-end">
                            <option value="">اختر</option>
                            <option value="ذكر" {{ (old('gender', $customer->gender ?? '')=='ذكر')?'selected':'' }}>ذكر</option>
                            <option value="أنثى" {{ (old('gender', $customer->gender ?? '')=='أنثى')?'selected':'' }}>أنثى</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold small">الرقم الوطني</label>
                        <input type="text" name="national_id" value="{{ old('national_id', $customer->national_id ?? '') }}" class="form-control rounded-3 py-2 text-end">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">تاريخ الميلاد</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date', $customer->birth_date ?? '') }}" class="form-control rounded-3 py-2">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">الوظيفة</label>
                        <input type="text" name="job" value="{{ old('job', $customer->job ?? '') }}" class="form-control rounded-3 py-2 text-end">
                    </div>

                    <h6 class="fw-bold mb-2 mt-4" style="color:#555;">بيانات السكن</h6>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">المستوى التعليمي</label>
                        <select name="education_level" class="form-select rounded-3 py-2 text-end">
                            <option value="">اختر</option>
                            <option value="ابتدائي">ابتدائي</option>
                            <option value="ثانوي">ثانوي</option>
                            <option value="جامعي">جامعي</option>
                            <option value="دراسات عليا">دراسات عليا</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">الولاية</label>
                        <input type="text" name="state" value="{{ old('state', $customer->state ?? '') }}" class="form-control rounded-3 py-2 text-end">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">المدينة</label>
                        <input type="text" name="city" value="{{ old('city', $customer->city ?? '') }}" class="form-control rounded-3 py-2 text-end">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold small">العنوان بالتفصيل</label>
                        <textarea name="address" rows="2" class="form-control rounded-3 text-end">{{ old('address', $customer->address ?? '') }}</textarea>
                    </div>

                    <h6 class="fw-bold mb-2 mt-4" style="color:#888;">في حالة الوفاة (اختياري)</h6>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">تاريخ الوفاة</label>
                        <input type="date" name="date_of_death" value="{{ old('date_of_death', $customer->date_of_death ?? '') }}" class="form-control rounded-3 py-2">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">مكان الوفاة</label>
                        <input type="text" name="place_of_death" value="{{ old('place_of_death', $customer->place_of_death ?? '') }}" class="form-control rounded-3 py-2 text-end">
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-dark rounded-pill py-2 fw-bold" style="background:#111;">
                        {{ isset($customer) ? 'حفظ التعديلات' : 'حفظ العميل' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
