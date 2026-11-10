@extends('layouts.app')
@section('title', 'إنشاء حساب مستخدم')
@section('content')
<main class="form-page">
    <header class="form-page-heading">
        <div><h1>إنشاء حساب مستخدم</h1><p>اربط الحساب بموظف وحدد الدور المناسب من الأدوار المعتمدة.</p></div>
        <a class="form-cancel" href="{{ route('users.index') }}">العودة للحسابات</a>
    </header>
    <section class="form-card">
        @if($errors->any())
            <div class="form-errors" role="alert"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif
        <form method="POST" action="{{ route('users.store') }}" class="data-form">
            @csrf
            <section class="form-section">
                <h2>بيانات الدخول والصلاحية</h2>
                <div class="form-fields">
                    <div class="field"><label for="user-employee">الموظف <span>*</span></label>
                        <select id="user-employee" name="employee_id" required>
                            <option value="">اختر الموظف</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" @selected((string) old('employee_id') === (string) $employee->id)>{{ $employee->name }} — {{ $employee->employee_no }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field"><label for="user-email">البريد الإلكتروني <span>*</span></label><input id="user-email" name="email" type="email" value="{{ old('email') }}" maxlength="255" autocomplete="username" required dir="ltr"></div>
                    <div class="field"><label for="user-role">الدور <span>*</span></label>
                        <select id="user-role" name="role" required>
                            <option value="hr" @selected(old('role', 'hr') === 'hr')>الموارد البشرية</option>
                            <option value="viewer" @selected(old('role') === 'viewer')>مشاهدة فقط</option>
                            <option value="admin" @selected(old('role') === 'admin')>مدير النظام</option>
                        </select>
                    </div>
                    <div class="field"><label for="user-password">كلمة المرور <span>*</span></label><input id="user-password" name="password" type="password" minlength="8" autocomplete="new-password" required></div>
                    <div class="field"><label for="user-password-confirmation">تأكيد كلمة المرور <span>*</span></label><input id="user-password-confirmation" name="password_confirmation" type="password" minlength="8" autocomplete="new-password" required></div>
                </div>
            </section>
            <div class="form-actions"><button class="form-submit" type="submit">إنشاء الحساب</button><a class="form-cancel" href="{{ route('users.index') }}">إلغاء</a></div>
        </form>
    </section>
</main>
@endsection
