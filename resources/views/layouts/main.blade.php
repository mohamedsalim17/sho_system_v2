<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', $companyInfo->name ?? 'نظام الادارة')</title>
<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:Tahoma, sans-serif}
body{background:#f6f7fb; direction:rtl;}
.navbar{background:#151515;height:64px;display:flex;align-items:center;gap:28px;padding:0 28px; position:sticky; top:0; z-index:10}
.navbar a{color:#9d9d9d;text-decoration:none;font-size:15px}
.navbar a.active, .navbar a:hover{color:#fff; font-weight:700}
.navbar-links{display:flex;align-items:center;gap:14px;flex-wrap:wrap}
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
.report-page{color:#1e293b}
.report-heading{margin-bottom:20px}
.report-heading h1{font-size:26px;margin-bottom:8px}
.report-heading p,.report-muted{color:#64748b;line-height:1.8}
.report-actions,.report-toolbar{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
.report-actions{margin:18px 0}
.report-btn{display:inline-flex;align-items:center;justify-content:center;gap:7px;border:0;border-radius:10px;padding:10px 16px;background:#172554;color:#fff;text-decoration:none;font-weight:700;cursor:pointer}
.report-btn:hover{filter:brightness(1.12)}
.report-btn-light{background:#e2e8f0;color:#1e293b}
.report-btn-green{background:#047857}
.report-btn-red{background:#b91c1c}
.report-panel{background:#fff;border:1px solid #e2e8f0;border-radius:16px;padding:20px;margin:18px 0;box-shadow:0 8px 26px rgba(15,23,42,.05)}
.report-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:16px}
.report-featured-fields{display:flex;flex-wrap:wrap;gap:12px;margin-bottom:16px}
.report-featured-field{display:flex;align-items:center;gap:8px;margin:0;padding:12px 16px;border:1px solid #bfdbfe;border-radius:10px;background:#eff6ff;color:#1e3a8a;font-weight:700}
.report-featured-field input{width:18px;height:18px;accent-color:#1d4ed8}
.report-card{display:block;color:inherit;text-decoration:none;text-align:right;background:#fff;border:1px solid #e2e8f0;border-radius:18px;padding:22px;box-shadow:0 8px 26px rgba(15,23,42,.05);transition:transform .18s ease,box-shadow .18s ease}
.report-card:hover{transform:translateY(-3px);box-shadow:0 14px 32px rgba(15,23,42,.1)}
.report-card-icon{font-size:28px;margin-bottom:12px}
.report-card h2{font-size:18px;margin-bottom:8px}
.report-stat{background:linear-gradient(135deg,#fff,#f8fafc);border:1px solid #e2e8f0;border-radius:14px;padding:18px}
.report-stat span{display:block;color:#64748b;font-size:13px;margin-bottom:8px}
.report-stat strong{font-size:24px;color:#0f172a}
.report-form{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:12px;align-items:end}
.report-form label{display:block;font-weight:700;font-size:13px;margin-bottom:6px}
.report-form input,.report-form select{width:100%;border:1px solid #cbd5e1;border-radius:9px;padding:10px;background:#fff;font:inherit}
.report-table-wrap{overflow-x:auto;border:1px solid #e2e8f0;border-radius:12px}
.report-table-wrap table{margin:0;min-width:720px}
.report-table-wrap th{background:#172554;white-space:nowrap}
.report-table-wrap td{background:#fff}
.report-table-wrap tbody tr:nth-child(even) td{background:#f8fafc}
.report-empty{text-align:center;padding:28px;color:#64748b}
.report-errors,.form-errors{margin:0 0 16px;padding:12px 16px;border:1px solid #fecaca;border-radius:10px;background:#fef2f2;color:#991b1b;line-height:1.8}
.form-errors ul{margin:8px 20px 0}
.form-page{max-width:980px;margin:0 auto;color:#1e293b}
.form-page-heading{display:flex;justify-content:space-between;align-items:center;gap:16px;margin-bottom:20px}
.form-page-heading h1{font-size:26px;margin:0 0 8px}
.form-page-heading p,.form-note{color:#64748b;line-height:1.8;margin:0}
.form-card{background:#fff;border:1px solid #e2e8f0;border-radius:18px;padding:24px;box-shadow:0 8px 26px rgba(15,23,42,.05)}
.form-note{margin-bottom:18px}
.form-identity{display:flex;align-items:center;gap:10px;padding:12px 16px;margin-bottom:18px;border-radius:10px;background:#f1f5f9;color:#475569}
.form-identity strong{color:#0f172a}
.form-section{padding:18px 0;border-bottom:1px solid #e2e8f0}
.form-section:first-of-type{padding-top:0}
.form-section:last-of-type{border-bottom:0}
.form-section h2{font-size:17px;margin:0 0 16px;color:#0f172a}
.relative-heading{font-size:17px;margin:0 0 16px;color:#0f172a}
.form-section h2 small{font-size:12px;font-weight:400;color:#64748b}
.form-fields{display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:16px}
.field{min-width:0}
.field-wide{grid-column:1/-1}
.field label{display:block;font-size:13px;font-weight:700;color:#334155;margin-bottom:6px}
.field label span{color:#dc2626}
.field input,.field select,.field textarea{width:100%;padding:11px 12px;border:1px solid #cbd5e1;border-radius:9px;background:#fff;color:#0f172a;font:inherit;transition:border-color .15s,box-shadow .15s}
.field input:focus,.field select:focus,.field textarea:focus{outline:none;border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.12)}
.field textarea{resize:vertical;min-height:84px}
.checkbox-field{display:flex!important;align-items:center;gap:8px;margin-top:24px!important}
.checkbox-field input[type=checkbox]{width:18px;height:18px;margin:0;accent-color:#172554}
.form-actions{display:flex;gap:10px;margin-top:20px}
.form-submit,.form-cancel{display:inline-flex;align-items:center;justify-content:center;min-height:42px;padding:10px 18px;border:0;border-radius:9px;font:inherit;font-weight:700;text-decoration:none;cursor:pointer}
.form-submit{background:#172554;color:#fff}
.form-submit:hover{background:#1e3a8a}
.form-cancel{background:#e2e8f0;color:#334155}
.form-flash{padding:12px 16px;border-radius:10px;margin-bottom:16px}
.form-flash-success{background:#ecfdf5;border:1px solid #a7f3d0;color:#065f46}
.form-flash-error{background:#fef2f2;border:1px solid #fecaca;color:#991b1b}
.table-responsive{width:100%;overflow-x:auto}
.table-responsive table{min-width:620px}
.settings-section{padding:18px 0;border-bottom:1px solid #e2e8f0}
.settings-section:last-child{border-bottom:0}
.settings-section>summary{cursor:pointer;font-size:17px;font-weight:700;color:#0f172a;list-style-position:inside}
.settings-section[open]>summary{margin-bottom:18px}
.report-pager{margin-top:16px;overflow-x:auto}
.report-pager nav{display:flex;justify-content:center}
.report-pager svg{width:18px;height:18px}
.report-pager a,.report-pager span{display:inline-block;padding:7px 11px;background:#fff;border:1px solid #e2e8f0;color:#334155;text-decoration:none}
.report-pager [aria-current=page] span{background:#172554;color:#fff}
@media print{.navbar,.report-print-hidden,.report-pager{display:none!important}.container{max-width:none;padding:0}.report-panel{box-shadow:none;border:0;padding:0}.report-table-wrap{overflow:visible}.report-table-wrap table{min-width:0;font-size:10px}.report-table-wrap th,.report-table-wrap td{padding:6px}}
@media(max-width:900px){ .grid{grid-template-columns:1fr 1fr} .form-grid{grid-template-columns:1fr} .navbar{height:auto;min-height:64px;flex-wrap:wrap;gap:14px;padding:12px 16px} }
</style>
</head>
<body>
<div class="navbar">
  <img src="{{ asset('images/logo.png') }}" alt="logo" style="height:38px; width:38px; object-fit:cover; border-radius:50%; background:#fff; padding:2px;">
<div class="navbar-links">
<a href="{{ route('dashboard') }}" style="font-weight:bold; color:#fff;">{{ $companyInfo->name ?? 'الرئيسية' }}</a>
  <a href="/employees">الموظفين</a>
  <a href="/customers">العملاء</a>
  <a href="/products">المخزون</a>
  <a href="/invoices">الفواتير</a>
  <a href="/reports">التقارير</a>
  @if(auth()->check() && auth()->user()->role === 'admin')
    <a href="{{ route('system.settings') }}">إعدادات النظام</a>
    <a href="{{ route('users.index') }}">المستخدمون</a>
  @endif
</div>
</div>
<div class="container">
  @if(session('success'))<div class="form-flash form-flash-success" role="status">{{ session('success') }}</div>@endif
  @if(session('error'))<div class="form-flash form-flash-error" role="alert">{{ session('error') }}</div>@endif
  @yield('content')
</div>
</body>
</html>
