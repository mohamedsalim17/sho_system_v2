<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>نظام الشهيد</title>
<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:Tahoma}
body{background:#f6f0e2}
.navbar{background:#151515;height:64px;display:flex;align-items:center;gap:28px;padding:0 28px}
.navbar a{color:#e9d7b0;text-decoration:none;font-size:17px;font-weight:700}
.container{max-width:1300px;margin:auto;padding:30px 20px}
.grid4{display:grid;grid-template-columns:repeat(4,1fr);gap:20px}
.card{background:#fff;border-radius:20px;padding:32px;text-align:center;box-shadow:0 10px 30px rgba(0,0,0,.06);border-bottom:5px solid #d5c39f}
.card h1{font-size:48px}
.card p{font-size:19px;color:#6d614f;margin-top:8px}
.white{background:#fff;border-radius:20px;padding:25px;margin-top:25px;box-shadow:0 10px 30px rgba(0,0,0,.06)}
table{width:100%;border-collapse:collapse}th,td{padding:14px;text-align:center;border-bottom:1px solid #eee}th{background:#fbf7ec}
</style>
</head>
<body>
<div class="navbar">
<a href="/">الداش بورد الرئيسي</a>
<a href="/employees">الموظفون</a>
<a href="/customers">العملاء</a>
<a href="/products">الأصناف</a>
<a href="/invoices">الفواتير</a>
</div>
<div class="container">@yield('content')</div>
</body>
</html>
