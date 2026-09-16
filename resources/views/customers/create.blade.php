<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>اضافة عميل جديد</title>
    <style> 
        body{font-family:Tahoma; padding:20px; background:#f4f4f4;} 
        .container{background:white; padding:20px; border-radius:8px; width:400px;}
        input,button{padding:10px; margin:5px 0; width:100%; box-sizing:border-box;} 
        button{background:blue; color:white; border:none; cursor:pointer;}
    </style>
</head>
<body>
    <div class="container">
        <h1>اضافة عميل جديد</h1>

        <form action="{{ route('customers.store') }}" method="POST">
            @csrf
            <label>الاسم:</label>
            <input type="text" name="name" required>

            <label>الهاتف:</label>
            <input type="text" name="phone">
             <div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">الرقم الوطني</label>
        <input type="text" name="national_id" class="form-control" value="{{ old('national_id') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">النوع</label>
        <select name="gender" class="form-select">
            <option value="">اختر</option>
            <option value="ذكر">ذكر</option>
            <option value="انثى">انثى</option>
        </select>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">تاريخ الميلاد</label>
        <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date') }}">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">الولاية</label>
        <input type="text" name="state" class="form-control" value="{{ old('state') }}">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">المدينة</label>
        <input type="text" name="city" class="form-control" value="{{ old('city') }}">
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">المستوى التعليمي</label>
        <input type="text" name="education_level" class="form-control" value="{{ old('education_level') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">المهنة</label>
        <input type="text" name="job" class="form-control" value="{{ old('job') }}">
    </div>
</div>

<hr>
<h5 class="text-danger">بيانات الوفاة - اختياري</h5>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">تاريخ الوفاة</label>
        <input type="date" name="date_of_death" class="form-control" value="{{ old('date_of_death') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">مكان الوفاة</label>
        <input type="text" name="place_of_death" class="form-control" value="{{ old('place_of_death') }}">
    </div>
</div>

            <label>العنوان:</label>
            <input type="text" name="address">

            <button type="submit">حفظ العميل</button>
        </form>

        <br>
        <a href="{{ route('customers.index') }}">الرجوع للقائمة</a>
    </div>
</body>
</html>
