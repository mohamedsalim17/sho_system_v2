@extends('layouts.main')
@section('content')
<h2 style="font-size:26px;margin-bottom:18px">إضافة موظف جديد</h2>
<div style="background:#fff;border-radius:18px;padding:24px;max-width:750px">
<form method="POST" action="/employees">
@csrf
<div style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
<div><label>الاسم الكامل *</label><input name="name" required style="width:100%;padding:11px;border-radius:10px;border:1px solid #ddd;margin-top:6px"></div>
<div><label>رقم الهوية / الرقم الوطني</label><input name="national_id" style="width:100%;padding:11px;border-radius:10px;border:1px solid #ddd;margin-top:6px"></div>
<div><label>رقم الهاتف</label><input name="phone" style="width:100%;padding:11px;border-radius:10px;border:1px solid #ddd;margin-top:6px"></div>
<div><label>الوظيفة / المسمى الوظيفي</label><input name="job" style="width:100%;padding:11px;border-radius:10px;border:1px solid #ddd;margin-top:6px"></div>
<div><label>القسم</label><input name="department" style="width:100%;padding:11px;border-radius:10px;border:1px solid #ddd;margin-top:6px"></div>
<div><label>الراتب</label><input name="salary" type="number" style="width:100%;padding:11px;border-radius:10px;border:1px solid #ddd;margin-top:6px"></div>
<div><label>تاريخ التعيين</label><input name="hire_date" type="date" style="width:100%;padding:11px;border-radius:10px;border:1px solid #ddd;margin-top:6px"></div>
<div><label>الحالة</label><select name="status" style="width:100%;padding:11px;border-radius:10px;border:1px solid #ddd;margin-top:6px"><option value="active">نشط</option><option value="inactive">غير نشط</option></select></div>
</div>
<div style="margin-top:14px"><label>العنوان</label><input name="address" style="width:100%;padding:11px;border-radius:10px;border:1px solid #ddd;margin-top:6px"></div>

<div style="display:flex;gap:10px;margin-top:20px">
<button style="background:#111;color:#e9d7b0;padding:12px 22px;border-radius:12px;border:none;font-weight:700;cursor:pointer">حفظ الموظف</button>
<a href="/employees" style="background:#f6f0e2;color:#111;padding:12px 20px;border-radius:12px;text-decoration:none">رجوع</a>
</div>
</form>
</div>
@endsection
