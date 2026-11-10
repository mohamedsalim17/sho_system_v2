<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>sho_system_v2 - نظام المبيعات المتكامل</title>
    <style>
        *{box-sizing:border-box}
        body{margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px;background:linear-gradient(135deg,#eff6ff,#f8fafc 55%,#e0e7ff);font-family:Tahoma,Arial,sans-serif;color:#0f172a}
        .guest-shell{width:100%;max-width:440px}
        .guest-heading{text-align:center;margin-bottom:20px}
        .guest-heading h1{font-size:25px;margin:0 0 8px}
        .guest-heading p{color:#64748b;margin:0}
        .guest-card{padding:28px;background:#fff;border:1px solid #e2e8f0;border-radius:18px;box-shadow:0 18px 50px rgba(15,23,42,.1)}
        .guest-card label{display:block;margin:14px 0 6px;font-size:14px;font-weight:700}
        .guest-card input{width:100%;padding:11px 12px;border:1px solid #cbd5e1;border-radius:9px;font:inherit}
        .guest-card input:focus{outline:none;border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.12)}
        .guest-card button{padding:10px 16px;border:0;border-radius:9px;background:#172554;color:#fff;font:inherit;font-weight:700;cursor:pointer}
        .guest-card a{color:#1d4ed8}
        .guest-card .guest-error{margin-top:5px;color:#b91c1c;font-size:13px}
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="guest-shell">
        <div class="guest-heading">
            <h1>sho_system_v2</h1>
            <p>نظام الإدارة والمبيعات</p>
        </div>
        <div class="guest-card">
            {{ $slot ?? '' }}
            @yield('content')
        </div>
    </div>
</body>
</html>
