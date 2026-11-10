@extends('layouts.app')
@section('title', 'إعدادات النظام')
@section('content')
<main class="form-page">
    <header class="form-page-heading">
        <div><h1>إعدادات النظام</h1><p>هذه الصفحة متاحة لمديري النظام فقط.</p></div>
        <a class="form-cancel" href="{{ route('dashboard') }}">العودة للرئيسية</a>
    </header>
    @if($errors->any())
        <div class="form-errors" role="alert"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <section class="form-card">
        <details class="settings-section" open>
            <summary>بيانات الشركة</summary>
            <form method="POST" action="{{ route('system.settings.company.store') }}" class="data-form">
                @csrf
                <div class="form-fields">
                    <div class="field"><label for="company-name">اسم الشركة <span>*</span></label><input id="company-name" name="name" value="{{ old('name', $company->name ?? '') }}" maxlength="255" required></div>
                    <div class="field"><label for="company-email">البريد الإلكتروني</label><input id="company-email" name="email" type="email" value="{{ old('email', $company->email ?? '') }}" maxlength="255" dir="ltr"></div>
                    <div class="field"><label for="company-phone">الهاتف</label><input id="company-phone" name="phone" type="tel" value="{{ old('phone', $company->phone ?? '') }}" maxlength="50"></div>
                    <div class="field"><label for="company-website">الموقع الإلكتروني</label><input id="company-website" name="website" type="url" value="{{ old('website', $company->website ?? '') }}" maxlength="255" dir="ltr"></div>
                    <div class="field"><label for="company-tax-number">الرقم الضريبي</label><input id="company-tax-number" name="tax_number" value="{{ old('tax_number', $company->tax_number ?? '') }}" maxlength="255"></div>
                    <div class="field"><label for="company-address">العنوان</label><input id="company-address" name="address" value="{{ old('address', $company->address ?? '') }}" maxlength="255"></div>
                </div>
                <div class="form-actions"><button class="form-submit" type="submit">حفظ بيانات الشركة</button></div>
            </form>
        </details>

        <details class="settings-section">
            <summary>شعار الشركة</summary>
            @if($company?->logo)<img src="{{ asset('storage/'.$company->logo) }}" alt="شعار الشركة الحالي" style="display:block;max-width:180px;max-height:100px;object-fit:contain;margin:16px 0">@endif
            <form method="POST" action="{{ route('system.settings.logo.store') }}" enctype="multipart/form-data" class="data-form">
                @csrf
                <div class="field"><label for="company-logo">اختر صورة PNG أو JPG أو WEBP (حتى 2 ميجابايت)</label><input id="company-logo" type="file" name="logo" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" required></div>
                <div class="form-actions"><button class="form-submit" type="submit">رفع الشعار</button></div>
            </form>
        </details>

        <details class="settings-section">
            <summary>حسابات المستخدمين ({{ $users->count() }})</summary>
            <form method="POST" action="{{ route('system.settings.user.store') }}" class="data-form">
                @csrf
                <div class="form-fields">
                    <div class="field"><label for="new-user-name">الاسم</label><input id="new-user-name" name="name" value="{{ old('name') }}" maxlength="255" required></div>
                    <div class="field"><label for="new-user-email">البريد الإلكتروني</label><input id="new-user-email" type="email" name="email" value="{{ old('email') }}" maxlength="255" required dir="ltr"></div>
                    <div class="field"><label for="new-user-role">الدور</label>
                        <select id="new-user-role" name="role" required>
                            <option value="hr" @selected(old('role', 'hr') === 'hr')>الموارد البشرية</option>
                            <option value="viewer" @selected(old('role') === 'viewer')>مشاهدة فقط</option>
                            <option value="admin" @selected(old('role') === 'admin')>مدير النظام</option>
                        </select>
                    </div>
                    <div class="field"><label for="new-user-password">كلمة المرور</label><input id="new-user-password" type="password" name="password" minlength="8" autocomplete="new-password" required></div>
                    <div class="field"><label for="new-user-password-confirmation">تأكيد كلمة المرور</label><input id="new-user-password-confirmation" type="password" name="password_confirmation" minlength="8" autocomplete="new-password" required></div>
                </div>
                <div class="form-actions"><button class="form-submit" type="submit">إضافة مستخدم</button><a class="form-cancel" href="{{ route('users.index') }}">إدارة الحسابات المرتبطة بالموظفين</a></div>
            </form>
            <div class="table-responsive">
                <table>
                    <thead><tr><th>الاسم</th><th>البريد</th><th>الدور</th><th>إجراء</th></tr></thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td><td dir="ltr">{{ $user->email }}</td>
                                <td>{{ ['admin' => 'مدير النظام', 'hr' => 'الموارد البشرية', 'viewer' => 'مشاهدة فقط'][$user->role] ?? $user->role }}</td>
                                <td>
                                    @if(!$user->is(auth()->user()))
                                        <form method="POST" action="{{ route('system.settings.user.delete', $user->id) }}" onsubmit="return confirm('حذف حساب الدخول فقط؟')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="form-cancel">حذف الحساب</button>
                                        </form>
                                    @else
                                        الحساب الحالي
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </details>

        <details class="settings-section">
            <summary>سجل الدخول (آخر {{ $logs->count() }} عملية)</summary>
            <div class="table-responsive">
                <table>
                    <thead><tr><th>المستخدم</th><th>وقت الدخول</th><th>عنوان الاتصال</th></tr></thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr><td>{{ $log->name }}</td><td>{{ $log->login_at ?? '-' }}</td><td dir="ltr">{{ $log->ip_address ?? '-' }}</td></tr>
                        @empty
                            <tr><td colspan="3" class="report-empty">لا توجد سجلات دخول.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </details>

        <details class="settings-section">
            <summary>الصيانة المحلية</summary>
            <p class="form-note">تنظيف ملفات التخزين المؤقت لا يحذف سجلات قاعدة البيانات أو ملفات المستخدمين.</p>
            <div class="form-actions">
                <a class="form-cancel" href="{{ route('system.settings.backup') }}">تنزيل نسخة قاعدة البيانات</a>
                <form method="POST" action="{{ route('system.settings.clean') }}" onsubmit="return confirm('تنظيف التخزين المؤقت المحلي؟')">
                    @csrf
                    <button class="form-submit" type="submit">تنظيف التخزين المؤقت</button>
                </form>
            </div>
        </details>
    </section>
</main>
@endsection
