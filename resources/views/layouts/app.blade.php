<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'النظام المتكامل'))</title>
    <style>
        *{box-sizing:border-box} body{margin:0;font-family:Tahoma;background:#f1f5f9}
        .navbar{background:#111827;color:#fff;padding:12px 20px;display:flex;justify-content:space-between;align-items:center}
        .navbar a{color:#fff;text-decoration:none;margin-left:15px;font-size:14px}
        .navbar-links{display:flex;align-items:center;gap:14px;flex-wrap:wrap}
        .container{max-width:1100px;margin:20px auto;padding:0 15px}
        .card{background:#fff;padding:20px;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,.05)}
        .table-responsive{width:100%;overflow-x:auto;margin-top:16px}
        table{width:100%;border-collapse:collapse;min-width:620px}
        th,td{padding:11px 12px;border-bottom:1px solid #e2e8f0;text-align:right;vertical-align:middle}
        th{background:#172554;color:#fff;white-space:nowrap}
        tbody tr:nth-child(even){background:#f8fafc}
        input,select,textarea{width:100%;padding:10px;border:1px solid #cbd5e1;border-radius:8px;margin-top:5px}
        button,.btn{background:#16a34a;color:#fff;border:0;padding:10px 16px;border-radius:8px;cursor:pointer;display:inline-block;text-decoration:none}
        label{display:block;margin-top:10px;font-size:14px;text-align:right}
        .grid{display:grid;grid-template-columns:repeat(4,1fr);gap:15px}
        .form-page{max-width:980px;margin:0 auto;color:#1e293b}
        .form-page-heading{display:flex;justify-content:space-between;align-items:center;gap:16px;margin-bottom:20px}
        .form-page-heading h1{font-size:26px;margin:0 0 8px}
        .form-page-heading p,.form-note{color:#64748b;line-height:1.8;margin:0}
        .form-card{background:#fff;border:1px solid #e2e8f0;border-radius:18px;padding:24px;box-shadow:0 8px 26px rgba(15,23,42,.05)}
        .form-errors{margin:0 0 16px;padding:12px 16px;border:1px solid #fecaca;border-radius:10px;background:#fef2f2;color:#991b1b;line-height:1.8}
        .form-errors ul{margin:8px 20px 0}
        .form-note{margin-bottom:18px}
        .form-identity{display:flex;align-items:center;gap:10px;padding:12px 16px;margin-bottom:18px;border-radius:10px;background:#f1f5f9;color:#475569}
        .form-identity strong{color:#0f172a}
        .form-section{padding:18px 0;border-bottom:1px solid #e2e8f0}
        .form-section:first-of-type{padding-top:0}
        .form-section:last-of-type{border-bottom:0}
        .form-section h2{font-size:17px;margin:0 0 16px;color:#0f172a}
        .form-section h2 small{font-size:12px;font-weight:400;color:#64748b}
        .form-fields{display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:16px}
        .field{min-width:0}
        .field-wide{grid-column:1/-1}
        .field label{display:block;font-size:13px;font-weight:700;color:#334155;margin-bottom:6px}
        .field label span{color:#dc2626}
        .field input,.field select,.field textarea{width:100%;padding:11px 12px;border:1px solid #cbd5e1;border-radius:9px;background:#fff;color:#0f172a;font:inherit;transition:border-color .15s,box-shadow .15s}
        .field input:focus,.field select:focus,.field textarea:focus{outline:none;border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.12)}
        .field textarea{resize:vertical;min-height:84px}
        .form-actions{display:flex;gap:10px;margin-top:20px}
        .form-submit,.form-cancel{display:inline-flex;align-items:center;justify-content:center;min-height:42px;padding:10px 18px;border:0;border-radius:9px;font:inherit;font-weight:700;text-decoration:none;cursor:pointer}
        .form-submit{background:#172554;color:#fff}
        .form-cancel{background:#e2e8f0;color:#334155}
        .form-flash{padding:12px 16px;border-radius:10px;margin-bottom:16px}
        .form-flash-success{background:#ecfdf5;border:1px solid #a7f3d0;color:#065f46}
        .form-flash-error{background:#fef2f2;border:1px solid #fecaca;color:#991b1b}
        .settings-section{padding:18px 0;border-bottom:1px solid #e2e8f0}
        .settings-section:last-child{border-bottom:0}
        .settings-section>summary{cursor:pointer;font-size:17px;font-weight:700;color:#0f172a;list-style-position:inside}
        .settings-section[open]>summary{margin-bottom:18px}
        .invoice-lines{display:grid;gap:12px}
        .invoice-line{display:grid;grid-template-columns:minmax(220px,2fr) minmax(100px,.7fr) minmax(90px,.5fr) auto;align-items:end;gap:12px;padding:14px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px}
        .invoice-line-total{padding:11px 8px;text-align:center;font-weight:700;color:#172554}
        .invoice-remove{padding:10px 12px;border:0;border-radius:8px;background:#fee2e2;color:#991b1b;cursor:pointer}
        .invoice-total{margin-top:16px;padding:14px;border-radius:10px;background:#eff6ff;color:#1e3a8a;font-size:17px}
        .invoice-total strong{font-size:21px}
        @media(max-width:768px){.grid{grid-template-columns:repeat(2,1fr)}}
        @media(max-width:640px){.navbar{align-items:flex-start;gap:12px;flex-direction:column}.navbar-links{gap:10px}.form-card{padding:16px}.form-page-heading{align-items:flex-start;flex-direction:column}.invoice-line{grid-template-columns:1fr 1fr}.invoice-line .field:first-child{grid-column:1/-1}.invoice-remove{grid-column:1/-1}}
    </style>
    @stack('styles')
</head>
<body>
    <div class="navbar">
      <div style="display:flex; align-items:center; gap:10px;">
    <img src="{{ asset('images/logo.png') }}" alt="logo" style="height:38px; width:38px; object-fit:cover; border-radius:50%; background:#fff; padding:2px;">
    <strong>{{ $companyInfo->name ?? 'sho_system_v2' }}</strong>
</div>
        <div class="navbar-links">
            <a href="{{ route('dashboard') }}">الرئيسية</a>
            <a href="{{ route('employees.index') }}">الموظفون</a>
            <a href="{{ route('customers.index') }}">العملاء</a>
            <a href="{{ route('products.index') }}">المنتجات</a>
            <a href="{{ route('invoices.index') }}">الفواتير</a>
            <a href="{{ route('reports.index') }}">التقارير</a>
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('users.index') }}">المستخدمون</a>
                <a href="{{ route('system.settings') }}">الإعدادات</a>
            @endif
            <a href="{{ route('profile.edit') }}">حسابي</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" style="background:#dc2626;margin-right:10px">خروج</button>
            </form>
        </div>
    </div>

    <div class="container">
        @if(session('success'))<div class="form-flash form-flash-success" role="status">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="form-flash form-flash-error" role="alert">{{ session('error') }}</div>@endif
        {{-- ده الحل للـ $slot --}}
        @if(isset($slot))
            <div class="card">{{ $slot }}</div>
        @else
            @yield('content')
        @endif

        {{-- لو الصفحة استخدمت <x-app-layout> --}}
        @isset($slot)
        @else
            @hasSection('content')
            @else
                {{-- للصفحات البتستخدم @section --}}
            @endif
        @endisset
    </div>

    @stack('scripts')
</body>
</html>
