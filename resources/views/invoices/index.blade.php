@extends('layouts.app')
@section('title', 'الفواتير')
@section('content')
<main class="form-page">
    <header class="form-page-heading">
        <div><h1>الفواتير</h1><p>سجل الفواتير المسجلة وإدارة تفاصيلها.</p></div>
        @if(in_array(auth()->user()->role, ['admin', 'hr'], true))
            <a class="form-submit" href="{{ route('invoices.create') }}">إنشاء فاتورة</a>
        @endif
    </header>
    <section class="form-card">
        <div class="table-responsive">
            <table>
                <thead><tr><th>رقم الفاتورة</th><th>العميل</th><th>التاريخ</th><th>الإجمالي</th><th>الإجراءات</th></tr></thead>
                <tbody>
                    @forelse($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->id }}</td>
                            <td>{{ $invoice->customer->name ?? 'غير متاح' }}</td>
                            <td>{{ $invoice->invoice_date?->format('Y-m-d') }}</td>
                            <td>{{ number_format((float) $invoice->total_amount, 2) }}</td>
                            <td>
                                <a class="form-cancel" href="{{ route('invoices.show', $invoice) }}">عرض</a>
                                @if(in_array(auth()->user()->role, ['admin', 'hr'], true))
                                    <a class="form-cancel" href="{{ route('invoices.edit', $invoice) }}">تعديل</a>
                                    <form method="POST" action="{{ route('invoices.destroy', $invoice) }}" style="display:inline" onsubmit="return confirm('حذف الفاتورة وإرجاع كمياتها إلى المخزون؟')">
                                        @csrf @method('DELETE')
                                        <button class="form-submit" type="submit">حذف</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="report-empty">لا توجد فواتير بعد.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="report-pager">{{ $invoices->links() }}</div>
    </section>
</main>
@endsection
