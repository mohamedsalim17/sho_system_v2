@extends('layouts.app')
@section('content')
<div class="card">
<div style="display:flex;justify-content:space-between"><h3>الأصناف</h3><a href="{{ route('products.create') }}" class="btn btn-primary">+ إضافة</a></div>
<form method="GET" style="display:flex;gap:8px;margin:15px 0"><input type="text" name="search" value="{{ request('search') }}" class="input" placeholder="بحث بالاسم او الباركود" style="margin:0"><button class="btn btn-secondary">بحث</button></form>
<table><tr><th>#</th><th>الاسم</th><th>الباركود</th><th>الفئة</th><th>السعر</th><th>الكمية</th><th>إجراء</th></tr>
@forelse($products as $p)<tr><td>{{ $p->id }}</td><td>{{ $p->name }}</td><td>{{ $p->barcode }}</td><td>{{ $p->category }}</td><td>{{ $p->price }}</td><td>{{ $p->quantity }}</td><td><a href="{{ route('products.edit',$p) }}" class="btn btn-warning">تعديل</a> <form action="{{ route('products.destroy',$p) }}" method="POST" style="display:inline">@csrf @method('DELETE')<button class="btn btn-danger" onclick="return confirm('حذف؟')">حذف</button></form></td></tr>
@empty<tr><td colspan="7" style="text-align:center">لا يوجد أصناف</td></tr>@endforelse
</table><div style="margin-top:10px">{{ $products->links() }}</div>
</div>
@endsection
