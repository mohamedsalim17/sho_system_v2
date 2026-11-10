<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تقرير {{ $source === 'customers' ? 'العملاء' : 'الموظفين' }}</title>
    <style>
        *{box-sizing:border-box}
        body{margin:0;padding:24px;font-family:Tahoma,Arial,sans-serif;color:#172033;background:#f1f5f9}
        .sheet{max-width:1200px;margin:auto;background:#fff;padding:28px;border-radius:14px}
        h1{font-size:22px;margin:0 0 8px}
        p{color:#64748b;margin:0 0 18px;font-size:13px}
        .actions{display:flex;gap:8px;margin-bottom:16px}
        button,a{border:0;border-radius:8px;padding:10px 15px;background:#172554;color:#fff;text-decoration:none;font:inherit;cursor:pointer}
        a{background:#475569}
        .table-wrap{overflow-x:auto}
        table{width:100%;border-collapse:collapse;font-size:12px}
        th,td{border:1px solid #dbe2ea;padding:8px;text-align:right}
        th{background:#172554;color:#fff}
        tr:nth-child(even) td{background:#f8fafc}
        .empty{text-align:center;padding:20px;color:#64748b}
        @media print{body{padding:0;background:#fff}.sheet{max-width:none;padding:0;border-radius:0}.actions{display:none}table{font-size:10px}th,td{padding:5px}}
    </style>
</head>
<body>
    <main class="sheet">
        <h1>تقرير {{ $source === 'customers' ? 'العملاء' : 'الموظفين' }}</h1>
        <p>تاريخ إعداد التقرير: {{ now()->format('Y-m-d H:i') }} — عدد السجلات: {{ $employees->count() }}</p>
        <div class="actions">
            <button type="button" onclick="window.print()">طباعة / حفظ PDF</button>
            <a href="{{ route('reports.builder', request()->query()) }}">العودة إلى منشئ التقارير</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr>@foreach($selectedColumns as $column)<th>{{ $allColumns[$column] }}</th>@endforeach</tr></thead>
                <tbody>
                    @forelse($employees as $employee)
                        <tr>@foreach($selectedColumns as $column)<td>{{ $employee->{$column} ?? '-' }}</td>@endforeach</tr>
                    @empty
                        <tr><td class="empty" colspan="{{ max(1, count($selectedColumns)) }}">لا توجد نتائج مطابقة.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
