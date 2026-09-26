<!DOCTYPE html><html dir="rtl" lang="ar"><head>
<meta charset="UTF-8"><title>نظام إدارة الموظفين</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head><body class="bg-light">
<nav class="navbar navbar-dark bg-dark"><div class="container">
<span class="navbar-brand fw-bold">📊 نظام إدارة الموظفين والعملاء</span>
<a href="{{route('dashboard')}}" class="btn btn-sm btn-outline-light">الرئيسية</a>
</div></nav>
<div class="container-fluid"><div class="row">
<div class="col-md-2 bg-white p-3 vh-100 shadow-sm">
<a href="{{route('dashboard')}}" class="d-block p-2 text-decoration-none">🏠 الدش بورد</a>
<a href="{{route('employees.index')}}" class="d-block p-2 text-decoration-none">👥 الموظفين</a>
<a href="{{route('employees.create')}}" class="d-block p-2 text-decoration-none">➕ إدخال موظف</a>
</div>
<div class="col-md-10 p-4">@yield('content')</div>
</div></div></body></html>
