@extends('layouts.app')
@section('content')

<div dir="rtl" style="max-width:1100px; margin:auto">

  <div style="background:#FFFBF5; border-radius:18px; padding:25px 30px; box-shadow:0 4px 20px rgba(0,0,0,0.06); margin-bottom:25px; border:1px solid #E8DFD0">
    <h3 style="margin:0 0 20px 0; color:#2C3E3A; border-right:5px solid #A8C3B5; padding-right:12px">إضافة موظف جديد</h3>
    
    <form action="{{ route('employees.store') }}" method="POST">
      @csrf
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px 20px">
        <div><label style="display:block; margin-bottom:6px; font-size:13px">الرقم الوظيفي</label><input name="employee_number" style="width:100%; padding:11px; border:1px solid #D9CFC0; border-radius:10px"></div>
        <div><label style="display:block; margin-bottom:6px; font-size:13px">الرقم الوطني</label><input name="national_id" style="width:100%; padding:11px; border:1px solid #D9CFC0; border-radius:10px"></div>
        <div><label style="display:block; margin-bottom:6px; font-size:13px">الاسم</label><input name="name" style="width:100%; padding:11px; border:1px solid #D9CFC0; border-radius:10px"></div>
        <div><label style="display:block; margin-bottom:6px; font-size:13px">رقم الهاتف</label><input name="phone" style="width:100%; padding:11px; border:1px solid #D9CFC0; border-radius:10px"></div>
        <div><label style="display:block; margin-bottom:6px; font-size:13px">تاريخ الميلاد</label><input type="date" name="birth_date" style="width:100%; padding:11px; border:1px solid #D9CFC0; border-radius:10px"></div>
        <div><label style="display:block; margin-bottom:6px; font-size:13px">تاريخ التعيين</label><input type="date" name="hire_date" style="width:100%; padding:11px; border:1px solid #D9CFC0; border-radius:10px"></div>
        <div><label style="display:block; margin-bottom:6px; font-size:13px">الحالة الاجتماعية</label><select name="marital_status" style="width:100%; padding:11px; border-radius:10px; border:1px solid #D9CFC0"><option>أعزب</option><option>متزوج</option></select></div>
        <div><label style="display:block; margin-bottom:6px; font-size:13px">المسمى الوظيفي</label><input name="job_title" style="width:100%; padding:11px; border-radius:10px; border:1px solid #D9CFC0"></div>
        <div><label style="display:block; margin-bottom:6px; font-size:13px">القسم</label><input name="department" style="width:100%; padding:11px; border-radius:10px; border:1px solid #D9CFC0"></div>
        <div><label style="display:block; margin-bottom:6px; font-size:13px">الراتب</label><input name="salary" type="number" style="width:100%; padding:11px; border-radius:10px; border:1px solid #D9CFC0"></div>
        <div><label style="display:block; margin-bottom:6px; font-size:13px">الولاية</label><input name="state" style="width:100%; padding:11px; border-radius:10px; border:1px solid #D9CFC0"></div>
        <div><label style="display:block; margin-bottom:6px; font-size:13px">المدينة</label><input name="city" style="width:100%; padding:11px; border-radius:10px; border:1px solid #D9CFC0"></div>
      </div>
      <button type="submit" style="margin-top:20px; background:#A8C3B5; color:#2C3E3A; border:none; padding:12px 35px; border-radius:10px; font-weight:bold; cursor:pointer">حفظ البيانات</button>
    </form>
  </div>

  <div style="background:#FFFBF5; border-radius:18px; padding:20px; box-shadow:0 4px 20px rgba(0,0,0,0.06); border:1px solid #E8DFD0; overflow:auto">
    <table style="width:100%; border-collapse:collapse; text-align:right; font-size:14px">
      
      <tbody>
      <thead>
<tr style="background:#ABC3B5; color:#2C3E5A">
  <th style="padding:12px">الرقم</th>
  <th style="padding:12px">الاسم</th>
  <th style="padding:12px">القسم</th>
  <th style="padding:12px">الولاية</th>
  <th style="padding:12px">العمليات</th>
</tr>
</thead>
<tbody>
@foreach($employees as $emp)
<tr style="border-bottom:1px solid #FBE9DB">
  <td style="padding:10px">{{ $emp->employee_number }}</td>
  <td style="padding:10px">{{ $emp->name }}</td>
  <td style="padding:10px">{{ $emp->department }}</td>
  <td style="padding:10px">{{ $emp->city }}</td>
  <td style="padding:10px">
    <a href="{{ route('employees.edit', $emp->id) }}" style="background:#3b82f6; color:white; padding:4px 8px; border-radius:4px; text-decoration:none;">تعديل</a>
    <form action="{{ route('employees.destroy', $emp->id) }}" method="POST" style="display:inline;">
      @csrf
      @method('DELETE')
      <button type="submit" onclick="return confirm('متأكد؟')" style="background:#ef4444; color:white; padding:4px 8px; border:none; border-radius:4px;">حذف</button>
    </form>
  </td>
</tr>
@endforeach
</tbody>

      </tbody>
    </table>
  </div>

</div>
@endsection
