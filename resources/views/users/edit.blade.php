@extends('layouts.app')
@section('title', 'تعديل حساب مستخدم')
@section('content')
<main class="form-page">
    <header class="form-page-heading">
        <div><h1>تعديل حساب المستخدم</h1><p>اترك كلمة المرور فارغة للإبقاء على كلمة المرور الحالية.</p></div>
        <a class="form-cancel" href="{{ route('users.index') }}">العودة للحسابات</a>
    </header>
    <section class="form-card">
        @if($errors->any())
            <div class="form-errors" role="alert"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif
        <form method="POST" action="{{ route('users.update', $user) }}" class="data-form">
            @csrf @method('PUT')
            <section class="form-section">
                <h2>{{ $user->name }}</h2>
                <div class="form-fields">
                    <div class="field"><label for="user-email">البريد الإلكتروني</label><input id="user-email" name="email" type="email" value="{{ old('email', $user->email) }}" maxlength="255" required dir="ltr"></div>
                    <div class="field"><label for="user-role">الدور</label>
                        <select id="user-role" name="role" required>
                            <option value="hr" @selected(old('role', $user->role) === 'hr')>الموارد البشرية</option>
                            <option value="viewer" @selected(old('role', $user->role) === 'viewer')>مشاهدة فقط</option>
                            <option value="admin" @selected(old('role', $user->role) === 'admin')>مدير النظام</option>
                        </select>
                    </div>
                    <div class="field"><label for="user-password">كلمة مرور جديدة</label><input id="user-password" name="password" type="password" minlength="8" autocomplete="new-password"></div>
                    <div class="field"><label for="user-password-confirmation">تأكيد كلمة المرور</label><input id="user-password-confirmation" name="password_confirmation" type="password" minlength="8" autocomplete="new-password"></div>
                </div>
            </section>
            <div class="form-actions"><button class="form-submit" type="submit">حفظ التعديلات</button><a class="form-cancel" href="{{ route('users.index') }}">إلغاء</a></div>
        </form>
    </section>
</main>
@endsection
