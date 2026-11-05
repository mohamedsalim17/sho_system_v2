@extends('layouts.app')
@section('content')
<div class="container">
  <h4>إعدادات النظام - نسخة نهائية</h4>
  <ul class="nav nav-tabs mt-3">
    <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#company">الشركة</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#logo">الشعار</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#users">المستخدمين</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#track">التتبع</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#backup">النسخ</button></li>
  </ul>

  <div class="tab-content p-3 border">
    <div class="tab-pane fade show active" id="company">
      <form method="POST" action="{{route('system.settings.company.store')}}">@csrf
        <input name="name" value="{{$company->name ?? ''}}" class="form-control mb-2" placeholder="اسم الشركة">
        <input name="email" value="{{$company->email ?? ''}}" class="form-control mb-2" placeholder="الايميل">
        <input name="phone" value="{{$company->phone ?? ''}}" class="form-control mb-2" placeholder="الهاتف">
        <button class="btn btn-primary">حفظ الشركة</button>
      </form>
    </div>
    <div class="tab-pane fade" id="logo">
      <form method="POST" action="{{route('system.settings.logo.store')}}" enctype="multipart/form-data">@csrf
        <input type="file" name="logo" class="form-control mb-2">
        <button class="btn btn-primary">رفع الشعار</button>
      </form>
    </div>
    <div class="tab-pane fade" id="users">
      <form method="POST" action="{{route('system.settings.user.store')}}" class="row g-2 mb-3">@csrf
        <div class="col"><input name="name" class="form-control" placeholder="الاسم" required></div>
        <div class="col"><input name="email" class="form-control" placeholder="الايميل" required></div>
        <div class="col"><input name="password" class="form-control" placeholder="كلمة السر" required></div>
        <div class="col"><select name="role" class="form-control"><option value="admin">admin</option><option value="user">user</option></select></div>
        <div class="col"><button class="btn btn-success">إضافة</button></div>
      </form>
      <table class="table table-sm"><tr><th>الاسم</th><th>الايميل</th><th>حذف</th></tr>
        @foreach($users as $u)<tr><td>{{$u->name}}</td><td>{{$u->email}}</td><td><a href="{{route('system.settings.user.delete',$u->id)}}" class="btn btn-sm btn-danger">حذف</a></td></tr>@endforeach
      </table>
    </div>
    <div class="tab-pane fade" id="track">
      <table class="table table-sm"><tr><th>المستخدم</th><th>الوقت</th><th>IP</th></tr>
        @foreach($logs as $l)<tr><td>{{$l->name}}</td><td>{{$l->login_at}}</td><td>{{$l->ip_address}}</td></tr>@endforeach
      </table>
    </div>
    <div class="tab-pane fade" id="backup">
      <a href="{{route('system.settings.backup')}}" class="btn btn-dark">تحميل نسخة</a>
      <form method="POST" action="{{route('system.settings.clean')}}" class="d-inline">@csrf<button class="btn btn-warning">تنظيف الكاش</button></form>
    </div>
  </div>
</div>
@endsection
