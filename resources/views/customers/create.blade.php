@extends('layouts.app')
@section('content')
<div class="container py-4" dir="rtl" style="text-align:right">
<div class="card border-0 shadow rounded-4 mx-auto" style="max-width:850px">
<div class="card-header bg-white border-0 p-4"><h4 class="fw-bold m-0">إضافة عميل</h4></div>
<div class="card-body p-4">
<form  id='customersForm'action="{{ route('customers.store') }}" method="POST">
@csrf
@if($errors->any())
<div style="background:#f8d7da;color:#842029;padding:12px;border-radius:8px;margin-bottom:15px;border:1px solid #f5c2c7">
    @foreach($errors->all() as $error)
        <div>⚠️ {{ $error }}</div>
    @endforeach
</div>
@endif

@if(session('success'))
<div style="background:#d1e7dd;color:#0f5132;padding:12px;border-radius:8px;margin-bottom:15px">
    {{ session('success') }}
</div>
@endif
<div class="row g-3">

<div class="col-md-6">
<label class="fw-bold">الاسم الكامل *</label>
<input type="text" name="name" value="{{ old('name') }}"  class="form-control " required>
</div>

<div class="col-md-6">
<label class="fw-bold">رقم الهاتف</label>
<input type="text" name="phone" value="{{ old('phone') }}" class="form-control text-end">
</div>

<div class="col-md-4">
<label class="fw-bold">الجنس</label>
<select name="gender" class="form-select text-end">
<option value="">-- اختر --</option>
<option value="ذكر" {{ old('gender')=='ذكر'?'selected':'' }}>ذكر</option>
<option value="انثى" {{ old('gender')=='انثى'?'selected':'' }}>انثى</option>
</select>
</div>

<div class="col-md-4">
<label class="fw-bold">تاريخ الميلاد</label>
<input type="date" name="birth_date" value="{{ old('birth_date') }}" class="form-control text-end">
</div>

<div class="col-md-4">
<label class="fw-bold">الرقم الوطني</label>
<input type="text" name="national_id" value="{{ old('national_id') }}" class="form-control text-end">
</div>

<div class="col-md-4">
<label class="fw-bold">الوظيفة</label>
<input type="text" name="job" value="{{ old('job') }}" class="form-control text-end">
</div>

<div class="col-md-4">
<label class="fw-bold">المستوى التعليمي</label>
<select name="education_level" class="form-select text-end">
<option value="">-- اختر --</option>
<option value="ابتدائي" {{ old('education_level')=='ابتدائي'?'selected':'' }}>ابتدائي</option>
<option value="ثانوي" {{ old('education_level')=='ثانوي'?'selected':'' }}>ثانوي</option>
<option value="جامعي" {{ old('education_level')=='جامعي'?'selected':'' }}>جامعي</option>
<option value="دراسات عليا" {{ old('education_level')=='دراسات عليا'?'selected':'' }}>دراسات عليا</option>
</select>
</div>

<div class="col-md-4">
<label class="fw-bold">الولاية</label>
<input type="text" name="state" value="{{ old('state') }}" class="form-control text-end">
</div>

<div class="col-md-4">
<label class="fw-bold">المدينة</label>
<input type="text" name="city" value="{{ old('city') }}" class="form-control text-end">
</div>

<div class="col-md-4">
<label class="fw-bold">تاريخ الوفاة</label>
<input type="date" name="date_of_death" value="{{ old('date_of_death') }}" class="form-control text-end">
</div>

<div class="col-md-4">
<label class="fw-bold">مكان الوفاة</label>
<input type="text" name="place_of_death" value="{{ old('place_of_death') }}" class="form-control text-end">
</div>

<div class="col-12">
<label class="fw-bold">العنوان بالتفصيل</label>
<textarea name="address" rows="2" class="form-control text-end">{{ old('address') }}</textarea>
</div>

</div>
<button class="btn btn-dark w-100 rounded-pill mt-4 py-2">حفظ العميل</button>
</form>
</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if($errors->any())
<script>
Swal.fire({
  icon: 'warning',
  title: 'تنبيه',
  text: '{{ $errors->first() }}',
  confirmButtonText: 'موافق'
}).then(()=>{ document.getElementById('customerForm').reset(); });
</script>
@endif
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if($errors->any())
<script>
Swal.fire({
  icon: 'warning',
  title: 'تنبيه',
  text: '{{ $errors->first() }}',
  confirmButtonText: 'موافق'
}).then(()=>{ document.getElementById('customerForm').reset(); });
</script>
@endif

@endsection
