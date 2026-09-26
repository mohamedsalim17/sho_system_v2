@extends('layouts.app')
@section('content')
@if(session('success'))
<div style="position:fixed; top:15px; left:0; right:0; display:flex; justify-content:center; z-index:99999; pointer-events:none;">
  <div style="pointer-events:auto; background:#10b981; color:white; padding:12px 24px; border-radius:30px; font-weight:bold;">
    ✓ {{ session('success') }}
  </div>
</div>
@endif

<div dir="rtl" style="background:#FDF6EC; min-height:100vh; font-family:Cairo, sans-serif">
  
  <div style="background:#A8C3B5; padding:20px 30px; display:flex; justify-content:space-between; align-items:center; color:#2C3E3A">
    <h2 style="margin:0">تعبئة المعلومات الأساسية</h2>
    <div>
      <button style="background:#5B9BD5; color:white; border:none; padding:8px 18px; border-radius:8px; margin-left:10px">🔵 تعديل</button>
      <button style="background:#E74C3C; color:white; border:none; padding:8px 18px; border-radius:8px">🔴 حذف</button>
    </div>
  </div>

  <div style="display:flex">
    {{-- القائمة يمين --}}
    <div style="width:220px; background:#FDF6EC; padding:20px; border-left:1px solid #E0D5C0">
      <p style="font-weight:bold">القائمة الرئيسية</p>
      <ul style="list-style:none; padding:0; line-height:2.2">
        <li>🏠 الرئيسية</li>
        <li>👥 الموظفون</li>
        <li>📄 العقود</li>
        <li>💰 الرواتب</li>
      </ul>
    </div>

       <form action="{{ route('employees.store') }}" method="POST" style="background:#FFFBF5; padding:30px; border-radius:16px; box-shadow:0 4px 15px rgba(0,0,0,0.05)">
        @csrf
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px">
          <div><label>الرقم الوطني</label><input type="text" name="national_id" style="width:100%; padding:10px; border-radius:8px; border:1px solid #D9CFC0"></div>
          <div><label>رقم الموظف</label><input type="text" name="employee_number" style="width:100%; padding:10px; border-radius:8px; border:1px solid #D9CFC0"></div>
          <div><label>الاسم كامل</label><input type="text" name="name" style="width:100%; padding:10px; border-radius:8px; border:1px solid #D9CFC0"></div>
          <div><label>رقم الجوال</label><input type="text" name="phone" style="width:100%; padding:10px; border-radius:8px; border:1px solid #D9CFC0"></div>
          <div><label>تاريخ الميلاد</label><input type="date" name="birth_date" style="width:100%; padding:10px; border-radius:8px; border:1px solid #D9CFC0"></div>
          <div><label>تاريخ الوفاة</label><input type="date" name="death_date" style="width:100%; padding:10px; border-radius:8px; border:1px solid #D9CFC0"></div>
          <div><label>الحالة الاجتماعية</label><select name="marital_status" style="width:100%; padding:10px; border-radius:8px; border:1px solid #D9CFC0"><option>أعزب</option><option>متزوج</option></select></div>
          <div><label>المسمى الوظيفي</label><input type="text" name="job_title" style="width:100%; padding:10px; border-radius:8px; border:1px solid #D9CFC0"></div>
          <div><label>القسم</label><input type="text" name="department" style="width:100%; padding:10px; border-radius:8px; border:1px solid #D9CFC0"></div>
          <div><label>الراتب</label><input type="number" name="salary" style="width:100%; padding:10px; border-radius:8px; border:1px solid #D9CFC0"></div>
          <div><label>تاريخ التعيين</label><input type="date" name="hire_date" style="width:100%; padding:10px; border-radius:8px; border:1px solid #D9CFC0"></div>
          <div><label>الولاية</label><input type="text" name="state" style="width:100%; padding:10px; border-radius:8px; border:1px solid #D9CFC0"></div>
          <div><label>المدينة</label><input type="text" name="city" style="width:100%; padding:10px; border-radius:8px; border:1px solid #D9CFC0"></div>
          <div><label>الحي</label><input type="text" name="district" style="width:100%; padding:10px; border-radius:8px; border:1px solid #D9CFC0"></div>
          <div><label>الشارع</label><input type="text" name="street" style="width:100%; padding:10px; border-radius:8px; border:1px solid #D9CFC0"></div>
        </div>
        <div style="margin-top:30px; display:flex; gap:15px">
          <button type="submit" style="background:#A8C3B5; color:#2C3E3A; border:none; padding:12px 30px; border-radius:10px; font-weight:bold">حفظ البيانات</button>
          <a href="/employees" style="background:#E0D5C0; padding:12px 30px; border-radius:10px; text-decoration:none; color:#333">إلغاء</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
