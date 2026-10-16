@extends('layouts.main')

@section('content')
<style>
    .card-box{background:#fff;border-radius:18px;padding:20px;margin-bottom:20px;box-shadow:0 2px 10px rgba(0,0,0,0.05);border:1px solid #eee;}
    .black-header{background:#111;color:#fff;border-radius:25px;padding:10px;text-align:center;margin-bottom:15px;}
    .btn-save{background:#111;color:#fff;border-radius:25px;padding:10px 0;width:100%;border:none;}
    .form-control{border-radius:10px;margin-bottom:10px;}
</style>

<div class="container-fluid" dir="rtl" style="padding:20px;background:#f7f7f7;">

    <h4 style="font-weight:800;margin-bottom:20px;">⚙️ ضبط النظام - كل الإعدادات في صفحة واحدة</h4>

    @if(session('success'))
        <div class="alert alert-success" style="border-radius:15px;">{{ session('success') }}</div>
    @endif

    {{-- 1 - إضافة مستخدم --}}
    <div class="card-box">
        <div class="black-header">➕ إضافة مستخدم جديد</div>
        <form method="POST" action="{{ route('settings.users.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-3"><input name="name" placeholder="الاسم" class="form-control" required></div>
                <div class="col-md-3"><input name="email" type="email" placeholder="الإيميل" class="form-control" required></div>
                <div class="col-md-3"><input name="password" type="password" placeholder="كلمة المرور" class="form-control" required></div>
                <div class="col-md-3">
                    <select name="role" class="form-control"><option value="admin">مدير</option><option value="hr">HR</option><option value="cashier">كاشير</option></select>
                </div>
            </div>
            <button type="submit" class="btn-save mt-3">حفظ المستخدم</button>
        </form>
    </div>

    {{-- 2 - جدول المستخدمين --}}
    <div class="card-box">
        <h5>👥 {{ $users->count() }} المستخدمون</h5>
        <div class="black-header">قائمة المستخدمين</div>
        <table class="table text-center">
            <thead><tr><th>#</th><th>الاسم</th><th>الإيميل</th><th>الصلاحية</th><th>حذف</th></tr></thead>
            <tbody>
                @foreach($users as $u)
                <tr><td>{{$u->id}}</td><td style="font-weight:bold;">{{$u->name}}</td><td>{{$u->email}}</td><td>{{$u->role ?? 'admin'}}</td>
                <td>
                    <form method="POST" action="{{ route('settings.users.delete',$u->id) }}">@csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-light">🗑️</button>
                    </form>
                </td></tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- 3 - معلومات الشركة --}}
    <div class="card-box">
        <h5>🏢 البيانات الأساسية</h5>
        <div class="black-header">معلومات الشركة</div>
        <form method="POST" action="{{ route('settings.users.store') }}">
            @csrf
            <input name="company_name" value="{{ $company->name ?? '' }}" placeholder="اسم الشركة" class="form-control">
            <input name="company_phone" placeholder="رقم الهاتف" class="form-control">
            <input name="company_address" placeholder="العنوان" class="form-control">
            {{-- ملاحظة: الحفظ هسه بحفظ كـ user لو ما عندك جدول شركة، بس عشان يشتغل الزر --}}
            <button type="submit" class="btn-save mt-2">حفظ معلومات الشركة</button>
        </form>
    </div>

    {{-- 4 - الشعار + نسخ + تقارير + صيانة --}}
    <div class="row">
        <div class="col-md-3"><div class="card-box text-center"><h6>🖼️ شعار الشركة - Logo</h6><div class="black-header">رفع الشعار</div><p style="border:2px dashed #ddd;padding:20px;border-radius:15px;">اسحب الشعار هنا</p></div></div>
        <div class="col-md-3"><div class="card-box text-center"><h6>💾 قاعدة البيانات</h6><div class="black-header">تحميل نسخة الآن</div><p>تحميل نسخة احتياطية من النظام</p></div></div>
        <div class="col-md-3"><div class="card-box text-center"><h6>📊 6 التقارير</h6><div class="black-header">عرض التقارير</div><p>عرض كل التقارير</p></div></div>
        <div class="col-md-3"><div class="card-box text-center"><h6>🧹 تنظيف السجلات</h6><div class="black-header">تنظيف</div><p>مسح السجلات القديمة</p></div></div>
    </div>

    <div class="card-box text-center"><h6>🔒 سجل الدخول</h6><div class="black-header">المستخدمين</div><p class="text-muted">سجل الدخول حيظهر هنا</p></div>

</div>
@endsection
