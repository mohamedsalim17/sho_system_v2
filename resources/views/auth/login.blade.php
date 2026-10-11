<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<title>sho_system_v2</title>
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
<div class="card">
<h1>sho_system_v2 🌿</h1>
<div class="sub">نظام المبيعات المتكامل</div>

<form method="POST" action="{{ route('login') }}">
@csrf
<label>البريد الالكتروني</label>
<input id="email" type="text" name="email" placeholder="example@email.com">

<label>كلمة المرور</label>
<input id="password" type="password" name="password">

<div class="row">
<span><input type="checkbox"> تذكرني</span>
<a href="{{ route('password.request') }}">نسيت كلمة المرور؟</a>
</div>

<button type="submit">تسجيل الدخول</button>
</form>
</div>

<script>
let e = document.getElementById('email');
let p = document.getElementById('password');
e.style.direction = 'ltr';
e.style.textAlign = 'left';
p.style.direction = 'ltr';
p.style.textAlign = 'left';

function check(el){
  if(/[\u0600-\u06FF]/.test(el.value)){
    el.style.direction = 'rtl';
    el.style.textAlign = 'right';
  } else {
    el.style.direction = 'ltr';
    el.style.textAlign = 'left';
  }
}
e.addEventListener('input', function(){ check(this); });
p.addEventListener('input', function(){ check(this); });
</script>

</body>
</html>
