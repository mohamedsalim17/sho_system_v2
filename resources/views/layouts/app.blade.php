<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'sho_system_v2') }}</title>
    <style>
        *{box-sizing:border-box} body{margin:0;font-family:Tahoma;background:#f1f5f9}
        .navbar{background:#111827;color:#fff;padding:12px 20px;display:flex;justify-content:space-between;align-items:center}
        .navbar a{color:#fff;text-decoration:none;margin-left:15px;font-size:14px}
        .container{max-width:1100px;margin:20px auto;padding:0 15px}
        .card{background:#fff;padding:20px;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,.05)}
        input,select,textarea{width:100%;padding:10px;border:1px solid #cbd5e1;border-radius:8px;margin-top:5px}
        button,.btn{background:#16a34a;color:#fff;border:0;padding:10px 16px;border-radius:8px;cursor:pointer;display:inline-block;text-decoration:none}
        label{display:block;margin-top:10px;font-size:14px;text-align:right}
        .grid{display:grid;grid-template-columns:repeat(4,1fr);gap:15px}
        @media(max-width:768px){.grid{grid-template-columns:repeat(2,1fr)}}
    </style>
    @stack('styles')
</head>
<body>
    <div class="navbar">
        <div><strong>sho_system_v2</strong></div>
        <div>
            <a href="{{ route('dashboard') }}">الرئيسية</a>
            <a href="{{ route('employees.index') }}">الموظفون</a>
            <a href="{{ route('customers.index') }}">العملاء</a>
            <a href="{{ route('products.index') }}">المنتجات</a>
            <a href="{{ route('invoices.index') }}">الفواتير</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" style="background:#dc2626;margin-right:10px">خروج</button>
            </form>
        </div>
    </div>

    <div class="container">
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
