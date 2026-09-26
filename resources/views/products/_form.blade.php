
<div class="
"></div>@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-6 mb-3">
        <label>اسم الصنف *</label>
        <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-3 mb-3">
        <label>الفئة</label>
        <input type="text" name="category" value="{{ old('category', $product->category ?? '') }}" class="form-control" placeholder="دواء، مستحضر...">
    </div>
    <div class="col-md-3 mb-3">
        <label>الوحدة</label>
        <select name="unit" class="form-control">
            <option value="قطعة" {{ ($product->unit ?? '')=='قطعة'?'selected':'' }}>قطعة</option>
            <option value="علبة" {{ ($product->unit ?? '')=='علبة'?'selected':'' }}>علبة</option>
            <option value="شريط" {{ ($product->unit ?? '')=='شريط'?'selected':'' }}>شريط</option>
        </select>
    </div>
    <div class="col-md-3 mb-3">
        <label>سعر الشراء</label>
        <input type="number" step="0.01" name="buy_price" value="{{ old('buy_price', $product->buy_price ?? '') }}" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
        <label>سعر البيع *</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-2 mb-3">
        <label>الكمية *</label>
        <input type="number" name="quantity" value="{{ old('quantity', $product->quantity ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-4 mb-3">
        <label>باركود</label>
        <input type="text" name="barcode" value="{{ old('barcode', $product->barcode ?? '') }}" class="form-control">
    </div>
</div>

@endsection
