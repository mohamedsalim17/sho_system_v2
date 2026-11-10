@extends('layouts.app')
@section('title', 'إدارة المستخدمين')
@section('content')
<main class="form-page">
    <header class="form-page-heading">
        <div><h1>إدارة المستخدمين</h1><p>تعديل أدوار الدخول وإدارة الحسابات دون حذف سجلات الموظفين.</p></div>
        <a class="form-submit" href="{{ route('users.create') }}">إضافة حساب</a>
    </header>
    <section class="form-card">
        <div class="table-responsive">
            <table>
                <thead><tr><th>الاسم</th><th>البريد الإلكتروني</th><th>الموظف المرتبط</th><th>الدور</th><th>الإجراءات</th></tr></thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td dir="ltr">{{ $user->email }}</td>
                            <td>{{ $user->employee->employee_no ?? 'غير مرتبط' }}</td>
                            <td>{{ ['admin' => 'مدير النظام', 'hr' => 'الموارد البشرية', 'viewer' => 'مشاهدة فقط'][$user->role] ?? $user->role }}</td>
                            <td>
                                <a class="form-cancel" href="{{ route('users.edit', $user) }}">تعديل</a>
                                @if(!$user->is(auth()->user()))
                                    <form method="POST" action="{{ route('users.destroy', $user) }}" style="display:inline" onsubmit="return confirm('حذف حساب الدخول فقط؟ لن يُحذف سجل الموظف.')">
                                        @csrf @method('DELETE')
                                        <button class="form-submit" type="submit">حذف الحساب</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="report-empty">لا توجد حسابات مستخدمين.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="report-pager">{{ $users->links() }}</div>
    </section>
</main>
@endsection
