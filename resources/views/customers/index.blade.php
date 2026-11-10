@extends('layouts.main')
@section('title', 'العملاء')
@section('content')
<main class="form-page">
    <header class="form-page-heading">
        <div><h1>العملاء</h1><p>عرض سجلات العملاء والبحث بالاسم أو الهاتف أو الرقم الوطني.</p></div>
        @if(in_array(auth()->user()->role, ['admin', 'hr'], true))
            <a class="form-submit" href="{{ route('customers.create') }}">إضافة عميل</a>
        @endif
    </header>
    <section class="form-card">
        <form method="GET" action="{{ route('customers.index') }}" class="report-form report-print-hidden">
            <div class="field"><label for="customer-search">بحث</label><input id="customer-search" type="search" name="search" value="{{ request('search') }}" placeholder="الاسم أو الهاتف أو الرقم الوطني"></div>
            <div class="form-actions"><button class="form-submit" type="submit">بحث</button><a class="form-cancel" href="{{ route('customers.index') }}">مسح</a></div>
        </form>
        <p class="form-note" style="margin-top:16px">عدد النتائج: {{ number_format($customers->total()) }}</p>
        <div class="table-responsive">
            <table>
                <thead><tr><th>#</th><th>الاسم</th><th>الهاتف</th><th>الرقم الوطني</th><th>المدينة</th><th>الإجراءات</th></tr></thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr>
                            <td>{{ $customers->firstItem() + $loop->index }}</td>
                            <td>{{ $customer->name }}</td><td>{{ $customer->phone ?: '-' }}</td>
                            <td>{{ $customer->national_id ?: '-' }}</td><td>{{ $customer->city ?: '-' }}</td>
                            <td>
                                <a class="form-cancel" href="{{ route('customers.show', $customer) }}">عرض</a>
                                @if(in_array(auth()->user()->role, ['admin', 'hr'], true))
                                    <a class="form-cancel" href="{{ route('customers.edit', $customer) }}">تعديل</a>
                                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" style="display:inline" onsubmit="return confirm('حذف سجل العميل؟')">
                                        @csrf @method('DELETE')
                                        <button class="form-submit" type="submit">حذف</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="report-empty">لا توجد سجلات عملاء مطابقة.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="report-pager">{{ $customers->links() }}</div>
    </section>
</main>
@endsection
