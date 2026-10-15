<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <title>sho_system_v2 - نظام المبيعات</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body{font-family:'Tajawal',sans-serif;background:#f5f1e8}
        .hero{background:#2d4a22;color:#fff;padding:80px 0}
        .card{border-radius:15px;border:none;box-shadow:0 2px 15px #0001}
        .btn-hakeem{background:#2d4a22;color:#fff;padding:10px 30px}
        .btn-hakeem:hover{background:#4a7c59;color:#fff}
    </style>
</head>
<body>
<nav class="navbar navbar-dark px-4 py-3" style="background:#2d4a22">
    <span class="navbar-brand fw-bold">🌿 sho_system_v2</span>
    <div>
        <a href="/login" class="btn btn-light btn-sm me-2">دخول</a>
        <a href="/register" class="btn btn-outline-light btn-sm">تسجيل</a>
    </div>
</nav>

<div class="hero text-center">
    <h1 class="fw-bold">نظام المبيعات المتكامل</h1>
    <p class="mt-3">الدش بورد الرئيسي - الموظفين - العملاء - الأصناف - الفواتير</p>
    <a href="/dashboard" class="btn btn-light mt-3 px-4">📊 الدخول للدش بورد</a>
</div>

<div class="container mt-5">
    <div class="row g-4 text-center">
        <div class="col-md-3"><div class="card p-4"><h3>👥</h3><p>الموظفون</p></div></div>
        <div class="col-md-3"><div class="card p-4"><h3>👤</h3><p>العملاء</p></div></div>
        <div class="col-md-3"><div class="card p-4"><h3>📦</h3><p>الأصناف</p></div></div>
        <div class="col-md-3"><div class="card p-4"><h3>🧾</h3><p>الفواتير</p></div></div>
    </div>
</div>
</body>
</html>
