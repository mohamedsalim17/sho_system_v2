@extends('layouts.app')
@section('content')
<div class="container py-4" dir="rtl" style="text-align:right">
<div class="card border-0 shadow rounded-4 mx-auto" style="max-width:850px">
<div class="card-header bg-white border-0 p-4"><h4 class="fw-bold m-0">تعديل العميل</h4></div>
<div class="card-body p-4">
<form action="{{ route('customers.update', $customer->id) }}" method="POST">
@csrf
@method('PUT')
<div class="row g-3">

<div class="col-md-6">
<label class="fw-bold">الاسم الكامل *</label>
<input type="text" name="name" value="{{ old('name', $customer->name) }}" required class="form-control text-end">
</div>

<div class="col-md-6">
<label class="fw-bold">رقم الهاتف</label>
<input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" class="form-control text-end">
</div>

<div class="col-md-4">
<label class="fw-bold">الجنس</label>
<select name="gender" class="form-select text-end">
<option value="">-- اختر --</option>
<option value="ذكر" {{ old('gender', $customer->gender)=='ذكر'?'selected':'' }}>ذكر</option>
<option value="انثى" {{ old('gender', $customer->gender)=='انثى'?'selected':'' }}>انثى</option>
</select>
</div>

<div class="col-md-4">
<label class="fw-bold">تاريخ الميلاد</label>
<input type="date" name="birth_date" value="{{ old('birth_date', $customer->birth_date) }}" class="form-control text-end">
</div>

<div class="col-md-4">
<label class="fw-bold">الرقم الوطني</label>
<input type="text" name="national_id" value="{{ old('national_id', $customer->national_id) }}" class="form-control text-end">
</div>

<div class="col-md-4">
<label class="fw-bold">الوظيفة</label>
<input type="text" name="job" value="{{ old('job', $customer->job) }}" class="form-control text-end">
</div>

<div class="col-md-4">
<label class="fw-bold">المستوى التعليمي</label>
<select name="education_level" class="form-select text-end">
<option value="">-- اختر --</option>
<option value="ابتدائي" {{ old('education_level', $customer->education_level)=='ابتدائي'?'selected':'' }}>ابتدائي</option>
<option value="ثانوي" {{ old('education_level', $customer->education_level)=='ثانوي'?'selected':'' }}>ثانوي</option>
<option value="جامعي" {{ old('education_level', $customer->education_level)=='جامعي'?'selected':'' }}>جامعي</option>
<option value="دراسات عليا" {{ old('education_level', $customer->education_level)=='دراسات عليا'?'selected':'' }}>دراسات عليا</option>
</select>
</div>

<div class="col-md-4">
<label class="fw-bold">الولاية</label>
<input type="text" name="state" value="{{ old('state', $customer->state) }}" class="form-control text-end">
</div>

<div class="col-md-4">
<label class="fw-bold">المدينة</label>
<input type="text" name="city" value="{{ old('city', $customer->city) }}" class="form-control text-end">
</div>

<div class="col-md-4">
<label class="fw-bold">تاريخ الوفاة</label>
<input type="date" name="date_of_death" value="{{ old('date_of_death', $customer->date_of_death) }}" class="form-control text-end">
</div>

<div class="col-md-4">
<label class="fw-bold">مكان الوفاة</label>
<input type="text" name="place_of_death" value="{{ old('place_of_death', $customer->place_of_death) }}" class="form-control text-end">
</div>

<div class="col-12">
<label class="fw-bold">العنوان بالتفصيل</label>
<textarea name="address" rows="2" class="form-control text-end">{{ old('address', $customer->address) }}</textarea>
</div>

</div>
<button class="btn btn-dark w-100 rounded-pill mt-4 py-2">حفظ التعديل</button>
</form>
</div>
</div>
</div>
@endsection
