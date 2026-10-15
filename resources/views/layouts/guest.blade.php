<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="utf-8">
    <title>sho_system_v2 - تسجيل الدخول</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body{font-family:'Tajawal',sans-serif;background:#f5f1e8}
        .login-card{border-radius:15px;border:none;box-shadow:0 5px 20px #0001}
        .btn-hakeem{background:#2d4a22;color:#fff}
        .btn-hakeem:hover{background:#4a7c59;color:#fff}
    </style>
</head>
<body class="d-flex align-items-center justify-content-center" style="min-height:100vh">
    <div class="col-md-4">
        <div class="text-center mb-4">
            <h3 class="fw-bold" style="color:#2d4a22">🌿 sho_system_v2</h3>
            <p>نظام المبيعات المتكامل</p>
        </div>
        <div class="card login-card p-4">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
