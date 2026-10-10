<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>نظام الإدارة</title>
<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:Tahoma}
body{background:#f0f2f5; direction:rtl;}
.navbar{background:#1a237e;color:#fff;height:64px;display:flex;align-items:center;gap:28px;padding:0 20px}
.navbar a{color:#fff;text-decoration:none;font-weight:700}
.container{max-width:1300px;margin:auto;padding:20px}
.row{display:flex; gap:0; min-height:calc(100vh - 64px);}
.sidebar{width:200px;background:#fff; padding:15px; border-left:1px solid #eee;}
.sidebar a{display:block; padding:10px 8px; text-decoration:none; color:#333; border-radius:6px; margin-bottom:5px;}
.sidebar a:hover{background:#e8eaf6}
.main{flex:1; padding:20px;}
.card{background:#fff;border-radius:12px;padding:20px;box-shadow:0 4px 20px rgba(0,0,0,0.06); margin-bottom:20px;}
table{width:100%;border-collapse:collapse}
th,td{padding:12px;text-align:center;border-bottom:1px solid #eee}
th{background:#263238;color:#fff}
.badge{background:#1976d2;color:#fff;padding:4px 10px;border-radius:12px}
.btn{padding:8px 14px;border:none;border-radius:6px;cursor:pointer}
.btn-primary{background:#1a237e;color:#fff}
.form-control{width:100%;padding:8px;border:1px solid #ccc;border-radius:6px}
@media print{.navbar,.sidebar,.btn{display:none} .main{padding:0}}
</style>
</head>
<body>
<div class="navbar">
  <span>⚙️ نظام الإدارة</span>
  <a href="/">الرئيسية</a>
  <a href="/customers">العملاء</a>
  <a href="/employees">الموظفين</a>
  <a href="/products">المخزون</a>
  <a href="/invoices">الفواتير</a>
  <a href="/reports">التقارير</a>
</div>
<div class="row">
  <div class="sidebar">
    <a href="{{ route('dashboard') }}">🏠 لوحة التحكم</a>
    <a href="{{ route('employees.index') }}">👥 الموظفين</a>
    <a href="{{ route('employees.create') }}">➕ إضافة موظف</a>
    <a href="/customers">👤 العملاء</a>
    <a href="/reports">📊 التقارير</a>
  </div>
  <div class="main">
    @yield('content')
  </div>
</div>
</body>
</html>
