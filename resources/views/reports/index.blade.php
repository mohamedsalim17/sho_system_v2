@extends('layouts.main')
@section('title', 'مركز التقارير')
@section('content')
<main class="report-page">
    <header class="report-heading">
        <h1>مركز التقارير</h1>
        <p>استعرض بيانات النظام، صفِّ النتائج، واطبع تقاريرك أو احفظها محليًا بصيغة PDF.</p>
    </header>

    <section class="report-grid" aria-label="ملخص النظام">
        <div class="report-stat"><span>إجمالي المبيعات المسجلة</span><strong>{{ number_format($salesTotal, 2) }}</strong></div>
        <div class="report-stat"><span>الفواتير</span><strong>{{ number_format($invoiceCount) }}</strong></div>
        <div class="report-stat"><span>العملاء</span><strong>{{ number_format($customerCount) }}</strong></div>
        <div class="report-stat"><span>الموظفون</span><strong>{{ number_format($employeeCount) }}</strong></div>
        <div class="report-stat"><span>المنتجات</span><strong>{{ number_format($productCount) }}</strong></div>
    </section>

    <section class="report-grid" style="margin-top:20px">
        <a class="report-card" href="{{ route('reports.sales') }}">
            <div class="report-card-icon" aria-hidden="true">💰</div>
            <h2>تقرير المبيعات</h2>
            <p class="report-muted">الفواتير والإجماليات مع التصفية حسب العميل والفترة.</p>
        </a>
        <a class="report-card" href="{{ route('reports.customers') }}">
            <div class="report-card-icon" aria-hidden="true">👥</div>
            <h2>تقرير العملاء</h2>
            <p class="report-muted">بيانات العملاء وعدد الفواتير المسجلة لكل عميل.</p>
        </a>
        <a class="report-card" href="{{ route('reports.employees') }}">
            <div class="report-card-icon" aria-hidden="true">🧑‍💼</div>
            <h2>تقرير الموظفين</h2>
            <p class="report-muted">بيانات الموظفين والبحث في سجلاتهم وأقاربهم.</p>
        </a>
        <a class="report-card" href="{{ route('reports.products') }}">
            <div class="report-card-icon" aria-hidden="true">📦</div>
            <h2>تقرير المخزون</h2>
            <p class="report-muted">الكميات والأسعار والتنبيه على المنتجات منخفضة المخزون.</p>
        </a>
        <a class="report-card" href="{{ route('reports.builder') }}">
            <div class="report-card-icon" aria-hidden="true">🔎</div>
            <h2>منشئ التقارير</h2>
            <p class="report-muted">أنشئ تقارير للموظفين أو العملاء، بما فيها بيانات الوفاة.</p>
        </a>
        <a class="report-card" href="{{ route('reports.general') }}">
            <div class="report-card-icon" aria-hidden="true">📋</div>
            <h2>التقرير العام</h2>
            <p class="report-muted">بحث الموظفين وتحديد فترة التعيين.</p>
        </a>
        <a class="report-card" href="{{ route('reports.filter') }}">
            <div class="report-card-icon" aria-hidden="true">🎯</div>
            <h2>تصفية حسب حقل</h2>
            <p class="report-muted">تصفية سجلات الموظفين حسب أي حقل متاح.</p>
        </a>
        <a class="report-card" href="{{ route('reports.custom') }}">
            <div class="report-card-icon" aria-hidden="true">🧾</div>
            <h2>تقرير مبيعات مخصص</h2>
            <p class="report-muted">تصفية الفواتير حسب العميل والتاريخ.</p>
        </a>
    </section>
</main>
@endsection
