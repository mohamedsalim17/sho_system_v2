<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>نظام الفواتير</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="/">نظام الفواتير</a>
    <div>
      <a href="{{ route('products.index') }}" class="btn btn-outline-light btn-sm">المنتجات</a>
      <a href="{{ route('customers.index') }}" class="btn btn-outline-light btn-sm">العملاء</a>
      <a href="{{ route('invoices.index') }}" class="btn btn-outline-light btn-sm">الفواتير</a>
    </div>
  </div>
</nav>
<main>
@yield('content')
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
