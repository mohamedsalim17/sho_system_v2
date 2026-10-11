<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>sho_system_v2</title>
<style>
*{box-sizing:border-box}body{margin:0;font-family:Tahoma;background:#f1f5f9;min-height:100vh;display:flex;justify-content:center;align-items:center}
.card{width:420px;background:#fff;padding:35px;border-radius:16px;box-shadow:0 10px 30px rgba(0,0,0,.08);border:1px solid #e2e8f0}
.header{text-align:center;margin-bottom:30px}.header h1{margin:0;font-size:22px;font-weight:800;display:flex;justify-content:center;gap:8px}
.header p{color:#64748b;font-size:13px;margin-top:6px}
input{width:100%;padding:12px;border:1px solid #cbd5e1;border-radius:8px;margin:6px 0 16px;font-size:14px}
button{background:#16a34a;color:#fff;border:0;padding:12px;border-radius:8px;cursor:pointer;width:100%;font-weight:bold;font-size:15px;margin-top:10px}
button:hover{background:#15803d}
.row{display:flex;justify-content:space-between;align-items:center;font-size:13px;margin-top:10px}
a{color:#16a34a;text-decoration:none}
label{font-size:13px;color:#334155}
</style>
</head>
<body>
<div class="card">
<div class="header"><h1><span>🌿</span> sho_system_v2</h1><p>نظام المبيعات المتكامل</p></div>
{{ $slot }}
</div>
</body>
</html>
