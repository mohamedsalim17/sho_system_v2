@extends('layouts.app')
@section('content')
<div style="max-width:600px;margin:auto">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:15px">
    <h2>إنشاء حساب دخول للسيستم</h2>
    <a href="{{ route('employees.index') }}" style="background:#64748b;color:#fff;padding:8px 14px;border-radius:8px;text-decoration:none">رجوع للموظفين</a>
  </div>

  <div class="card">
    <form method="POST" action="{{ route('users.store') }}">
      @csrf
      <label>اختار الموظف *</label>
      <select name="employee_id" required>
        <option value="">-- اختر موظف من القائمة --</option>
        @foreach($employees as $emp)
          <option value="{{ $emp->id }}">{{ $emp->name }} - {{ $emp->phone }}</option>
        @endforeach
      </select>

      <label>البريد الإلكتروني *</label>
      <input id="email" type="text" name="email" required placeholder="ahmed@sho.com" style="direction:ltr;text-align:left">

      <label>كلمة المرور *</label>
      <input type="password" name="password" required>

      <label>الصلاحية *</label>
      <select name="role" required>
        <option value="employee">موظف عادي</option>
        <option value="admin">مدير</option>
      </select>

      <button type="submit" style="width:100%;margin-top:20px">إنشاء الحساب</button>
    </form>
    <p style="font-size:12px;color:#64748b;margin-top:10px">ملاحظة: الحساب بتعمل للموظفين الشغالين بس. العمال وسجل الناس الاتوفت ما بتعمل ليهم حساب.</p>
  </div>
</div>
@endsection
