<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<title>الشعبية</title>
<style>
body{margin:0;font-family:Tahoma;background:#f1f5f9;display:flex;justify-content:center;align-items:center;min-height:100vh}
.card{width:400px;background:#fff;padding:30px;border-radius:15px;box-shadow:0 5px 20px rgba(0,0,0,0.1)}
h1{text-align:center;margin:0}
.sub{text-align:center;color:#777;font-size:13px;margin-bottom:20px}
label{display:block;text-align:right;font-size:13px;margin-top:10px}
input{width:100%;padding:11px;border:1px solid #ccc;border-radius:7px;margin-top:5px;outline:none}
input:focus{border-color:#16a34a}
button{width:100%;background:#16a34a;color:#fff;border:0;padding:12px;border-radius:8px;margin-top:20px;font-weight:bold;cursor:pointer}
.row{display:flex;justify-content:space-between;margin-top:10px;font-size:12px}
.row a{color:#16a34a;text-decoration:none}
</style>
</head>
<body>
<main class="card">
    <div style="text-align:center;margin-bottom:20px"><img src="{{ asset('images/logo.png') }}" alt="شعار النظام" style="height:72px;width:72px;object-fit:contain"></div>
    <h1>الشعبية</h1>
    <div class="sub">نظام الإدارة والمبيعات</div>
    @if($errors->any())
        <div role="alert" style="background:#fef2f2;color:#991b1b;border:1px solid #fecaca;padding:10px;border-radius:8px;margin-bottom:14px">{{ $errors->first() }}</div>
    @endif
    @if(session('status'))
        <div role="status" style="background:#eff6ff;color:#1e40af;padding:10px;border-radius:8px;margin-bottom:14px">{{ session('status') }}</div>
    @endif
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label for="email">البريد الإلكتروني</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="example@email.com" autocomplete="username" required autofocus dir="ltr">
        <label for="password">كلمة المرور</label>
        <input id="password" type="password" name="password" autocomplete="current-password" required dir="ltr">
        <div class="row">
            <label style="display:flex;align-items:center;gap:6px;margin:0"><input type="checkbox" name="remember" value="1" style="width:auto;margin:0"> تذكرني</label>
            <a href="{{ route('password.request') }}">نسيت كلمة المرور؟</a>
        </div>
        <button type="submit">تسجيل الدخول</button>
    </form>
</main>
</body>
</html>
