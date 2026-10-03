@extends('layouts.app')
@section('content')
<div class="container py-4" dir="rtl" style="text-align:right">
<div class="card border-0 shadow rounded-4 mx-auto" style="max-width:850px">
<div class="card-header bg-white border-0 p-4 d-flex justify-content-between">
    <h4 class="fw-bold m-0">تعديل عميل</h4>
    <a href="{{ route('employees.index') }}" class="btn btn-light rounded-pill">رجوع</a>
</div>
<div class="card-body p-4">
    <form action="{{ route('employees.update', $employee->id) }}" method="POST">
    @csrf @method('PUT')

    @if($errors->any())
    <div class="alert alert-danger rounded-3 mb-3">
        @foreach($errors->all() as $error)<div>⚠️ {{ $error }}</div>@endforeach
    </div>
    @endif

    <div class="row g-3">
        <div class="col-md-6">
            <label class="fw-bold">الاسم الكامل *</label>
            <input type="text" name="name" value="{{ old('name', $employee->name) }}" class="form-control text-end" required>
        </div>
        <div class="col-md-6">
            <label class="fw-bold">رقم الهاتف</label>
            <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}" class="form-control text-end">
        </div>
        <div class="col-md-4">
            <label class="fw-bold">الجنس</label>
            <select name="gender" class="form-select text-end">
                <option value="ذكر" {{ $employee->gender=='ذكر'?'selected':'' }}>ذكر</option>
                <option value="أنثى" {{ $employee->gender=='أنثى'?'selected':'' }}>أنثى</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="fw-bold">تاريخ الميلاد</label>
            <input type="date" name="birth_date" value="{{ old('birth_date', $employee->birth_date) }}" class="form-control">
        </div>
        <div class="col-md-4">
            <label class="fw-bold">الرقم الوطني</label>
            <input type="text" name="national_id" value="{{ old('national_id', $employee->national_id) }}" class="form-control text-end">
        </div>
        <div class="col-md-4"><label class="fw-bold">الوظيفة</label><input type="text" name="job" value="{{ $employee->job }}" class="form-control text-end"></div>
        <div class="col-md-4"><label class="fw-bold">الولاية</label><input type="text" name="state" value="{{$employee->state }}" class="form-control text-end"></div>
        <div class="col-md-4"><label class="fw-bold">المدينة</label><input type="text" name="city" value="{{$employee->city }}" class="form-control text-end"></div>
        <div class="col-12"><label class="fw-bold">العنوان</label><textarea name="address" rows="2" class="form-control text-end">{{ $employee->address }}</textarea></div>
    </div>
    <button class="btn btn-primary w-100 rounded-pill mt-4 py-2">تحديث العميل</button>
    </form>
</div>
</div>
</div>
@endsection
