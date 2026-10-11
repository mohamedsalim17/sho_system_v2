@extends('layouts.app')
@section('content')
<div class="container" dir="rtl" style="text-align:right">
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <h4 class="mb-4">⚙️ إعدادات النظام</h4>

    <div class="row">
        {{-- الشعار --}}
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">شعار الشركة</div>
                <div class="card-body text-center">
                    @if(($company->logo ?? false))
                        <img src="{{ asset('storage/'.$company->logo) }}" style="max-width:150px" class="mb-3 rounded">
                    @else
                        <p>لا يوجد شعار</p>
                    @endif
                    <form action="{{ route('system.settings.logo.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="logo" class="form-control mb-2" required>
                        <button class="btn btn-dark w-100">رفع الشعار</button>
                    </form>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">الإحصائيات</div>
                <div class="card-body">
                    <p>عدد المستخدمين: <b>{{ $users->count() }}</b></p>
                    <p>عدد مرات الدخول: <b>{{ $users->sum('login_count') ?? $users->count() }}</b></p>
                    <hr>
                    <a href="{{ route('system.settings.backup') }}" class="btn btn-outline-primary w-100 mb-2">تحميل نسخة احتياطية</a>
                    <form action="{{ route('system.settings.clean') }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-danger w-100">تنظيف النظام</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- باقي الإعدادات --}}
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">معلومات الشركة</div>
                <div class="card-body">
                    <form action="{{ route('system.settings.company.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-2"><label>اسم الشركة</label><input name="company_name" value="{{ $company->name ?? '' }}" class="form-control" required></div>
                            <div class="col-md-6 mb-2"><label>الهاتف</label><input name="company_phone" value="{{ $company->phone ?? '' }}" class="form-control"></div>
                            <div class="col-md-6 mb-2"><label>الإيميل</label><input name="company_email" value="{{ $company->email ?? '' }}" class="form-control"></div>
                            <div class="col-md-6 mb-2"><label>الموقع</label><input name="company_website" value="{{ $company->website ?? '' }}" class="form-control"></div>
                            <div class="col-md-12 mb-2"><label>العنوان</label><input name="company_address" value="{{ $company->address ?? '' }}" class="form-control"></div>
                        </div>
                        <button class="btn btn-primary">💾 حفظ الشركة</button>
                    </form>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">إضافة مستخدم جديد</div>
                <div class="card-body">
                    <form action="{{ route('system.settings.users.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-3 mb-2"><input name="name" placeholder="الاسم" class="form-control" required></div>
                            <div class="col-md-3 mb-2"><input name="email" type="email" placeholder="الإيميل" class="form-control" required></div>
                            <div class="col-md-3 mb-2"><input name="password" type="password" placeholder="كلمة السر" class="form-control" required></div>
                            <div class="col-md-3 mb-2">
                                <select name="role" class="form-control" required>
                                    <option value="">الصلاحية</option>
                                    <option value="admin">مدير عام</option>
                                    <option value="manager">مشرف</option>
                                    <option value="cashier">كاشير</option>
                                    <option value="hr">موارد بشرية</option>
                                    <option value="user">مستخدم</option>
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-success">+ إضافة</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">عرض المستخدمين ({{ $users->count() }})</div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-striped mb-0 text-center">
                        <thead class="table-dark"><tr><th>#</th><th>الاسم</th><th>الإيميل</th><th>الصلاحية</th><th>حذف</th></tr></thead>
                        <tbody>
                            @foreach($users as $u)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $u->name }}</td>
                                <td>{{ $u->email }}</td>
                                <td>
                                    @if($u->role=='admin') مدير عام
                                    @elseif($u->role=='manager') مشرف
                                    @elseif($u->role=='cashier') كاشير
                                    @elseif($u->role=='hr') موارد بشرية
                                    @else {{ $u->role }}
                                    @endif
                                </td>
                                <td><a href="{{ route('system.settings.users.delete',$u->id) }}" onclick="return confirm('حذف؟')" class="btn btn-danger btn-sm">x</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
