<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام الفواتير</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">نظام الفواتير</a>
            <div>
                <a href="{{ route('products.index') }}" class="btn btn-outline-light">المنتجات</a>
                <a href="{{ route('customers.index') }}" class="btn btn-outline-light">العملاء</a>
                <a href="{{ route('invoices.index') }}" class="btn btn-outline-light">الفواتير</a>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>
</body>
</html>
