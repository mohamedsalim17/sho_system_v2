<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>sho_system_v2</title>
<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:Tahoma,sans-serif}
body{background:#f9e7a0;direction:rtl;} /* الخلفية ذهبية */
.navbar{background:#111;height:64px;display:flex;align-items:center;gap:28px;padding:0 24px}
.navbar a{color:#d4af37;text-decoration:none;font-size:16px;font-weight:700} /* الكتابة ذهبي */
.navbar a:hover{color:#fff}
.container{max-width:1280px;margin:auto;padding:24px 20px}
.grid{display:grid;grid-template-columns:repeat(4,1fr);gap:18px}
.card{background:linear-gradient(135deg,#f9e7a0,#d4af37);border:2px solid #111;border-radius:14px;padding:20px;text-align:center;box-shadow:0 4px 10px #0002}
.card h4{color:#111;font-weight:900;font-size:18px;margin-top:8px} /* الخط أسود داخل الكرت */
.card small{color:#111;font-weight:bold}
.white{background:#111;border-radius:14px;padding:22px;margin-top:22px;border:2px solid #d4af37}
.white h3{color:#d4af37} /* عنوان أبيض بخلفية سوداء وكتابة ذهبية */
.btn-gold{background:#111;color:#d4af37;border:2px solid #d4af37;padding:12px;border-radius:8px;text-decoration:none;text-align:center;font-weight:900;display:block}
.btn-gold:hover{background:#d4af37;color:#111}
@media(max-width:900px){ .grid{grid-template-columns:1fr 1fr} }
</style>
</head>
<body>
<div class="navbar">
  <a href="/">الرئيسية</a>
  <a href="/employees">الموظفون</a>
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
