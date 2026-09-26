@extends('layouts.app')
@section('content')
<div class="card"><h3>إضافة صنف</h3>
<form action="{{ route('products.update', $product) }}" method="POST">
 @csrf @method('PUT')
 @include('products._form')
<label>اسم الصنف *</label><input type="text" name="name" value="{{ old('name') }}" class="input" required>
<label>الباركود</label><input type="text" name="barcode" value="{{ old('barcode') }}" class="input">
<label>الفئة</label><input type="text" name="category" value="{{ old('category') }}" class="input">
<label>الوحدة</label><input type="text" name="unit" value="{{ old('unit') }}" class="input" placeholder="قطعة / كرتونة">
<label>سعر الشراء</label><input type="number" step="0.01" name="purchase_price" value="{{ old('purchase_price') }}" class="input">
<label>سعر البيع *</label><input type="number" step="0.01" name="price" value="{{ old('price') }}" class="input" required>
<label>الكمية *</label><input type="number" name="quantity" value="{{ old('quantity',0) }}" class="input" required>
<label>الوصف</label><textarea name="description" class="input"></textarea>
<button class="btn btn-primary">حفظ</button> <a href="{{ route('products.index') }}" class="btn btn-secondary">رجوع</a>
</form></div>
@endsection
