<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>نظام الموظفين</title>
<style>
*{box-sizing:border-box}
body{margin:0;background:#FDF6EC;font-family:Tahoma; text-align:right}
.nav{background:#A8C3B5;color:#fff;padding:14px 28px;display:flex;justify-content:space-between;align-items:center}
.nav a{color:#2C3E3A;text-decoration:none;margin-left:20px;font-weight:bold}
.container{padding:25px}
</style>
</head>
<body>
<div class="nav">
  <div>نظام الموظفين</div>
  <div>
    <a href="/employees">الموظفون</a>
    <a href="/dashboard">الرئيسية</a>
  </div>
</div>

<div class="container">
  @yield('content')
</div>

</body>
</html>
