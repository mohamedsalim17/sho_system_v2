@extends('layouts.app')
@section('content')
<div class="container py-4" dir="rtl">
    {{-- الهيدر مع زر الإضافة --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">👥 إدارة العملاء</h3>
            <small class="text-muted">إجمالي العملاء: {{ $customers->count() }} عميل</small>
        </div>
        <a href="{{ route('customers.create') }}" class="btn btn-primary rounded-3 shadow px-4">
            + إضافة عميل جديد
        </a>
    </div>

    {{-- رسالة النجاح --}}
    @if(session('success'))
        <div class="alert alert-success rounded-3 shadow-sm">{{ session('success') }}</div>
    @endif

    {{-- الجدول الاحترافي --}}
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">#</th>
                            <th class="py-3">العميل</th>
                            <th class="py-3">الهاتف</th>
                            <th class="py-3">الرقم الوطني</th>
                            <th class="py-3">المدينة</th>
                            <th class="text-center py-3">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                        <tr>
                            <td class="ps-4 fw-bold text-muted">{{ $customer->id }}</td>
                            <td>
                                <div class="fw-bold">{{ $customer->name }}</div>
                                <small class="text-muted">{{ $customer->address }}</small>
                            </td>
                            <td><span class="badge bg-light text-dark border rounded-3">{{ $customer->phone ?? '-' }}</span></td>
                            <td><small>{{ $customer->national_id ?? '-' }}</small></td>
                            <td>{{ $customer->city ?? '-' }} - {{ $customer->state ?? '' }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm btn-outline-primary rounded-3" title="تعديل">✏️</a>
                                    
                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('متأكد عايز تحذف {{ $customer->name }}؟')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="حذف">🗑️</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <h1>📭</h1>
                                    <p>لا يوجد عملاء حالياً</p>
                                    <a href="{{ route('customers.create') }}" class="btn btn-primary rounded-3">أضف أول عميل</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    body { background-color: #f8f9fa
