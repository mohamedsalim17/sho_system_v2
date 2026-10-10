<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>نظام الادارة</title>
<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:Tahoma, sans-serif}
body{background:#f6f7fb; direction:rtl;}
.navbar{background:#151515;height:64px;display:flex;align-items:center;gap:28px;padding:0 28px; position:sticky; top:0; z-index:10}
.navbar a{color:#9d9d9d;text-decoration:none;font-size:15px}
.navbar a.active, .navbar a:hover{color:#fff; font-weight:700}
.container{max-width:1280px;margin:auto;padding:24px 20px}
.grid{display:grid; grid-template-columns:repeat(4,1fr); gap:18px}
.card{background:#fff;border-radius:14px;padding:18px;text-align:center;box-shadow:0 8px 30px rgba(0,0,0,.06);border-bottom:4px solid #111}
.card h4{font-size:19px;color:#66614f;margin-top:8px}
.white{background:#fff;border-radius:20px;padding:22px;margin-top:22px;box-shadow:0 8px 30px rgba(0,0,0,.06)}
table{width:100%;border-collapse:collapse; margin-top:15px;}
th,td{padding:12px 14px;text-align:center;border-bottom:1px solid #eee; font-size:14px}
th{background:#111;color:#fff}
.form-grid{display:grid; grid-template-columns:repeat(3,1fr); gap:15px; margin-top:15px;}
.form-group{display:flex; flex-direction:column; gap:6px;}
.form-control{width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;}
.btn{padding:10px 18px; border:none; border-radius:8px; cursor:pointer; font-weight:bold}
.btn-dark{background:#111; color:#fff}
@media(max-width:900px){ .grid{grid-template-columns:1fr 1fr} .form-grid{grid-template-columns:1fr} }
</style>
</head>
<body>
<div class="navbar">
  <a href="/">🏠 الرئيسية</a>
  <a href="/employees">الموظفين</a>
  <a href="/customers">العملاء</a>
  <a href="/products">المخزون</a>
  <a href="/invoices">الفواتير</a>
  <a href="/reports">التقارير</a>
</div>
<div class="container">
  @yield('content')
</div>
</body>
</html>
