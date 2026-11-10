@if($errors->any())
    <div class="form-errors" role="alert">
        <strong>يرجى مراجعة الحقول التالية:</strong>
        <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<form action="{{ isset($product) ? route('products.update', $product) : route('products.store') }}" method="POST" class="data-form">
    @csrf
    @if(isset($product)) @method('PUT') @endif

    <section class="form-section">
        <h2>بيانات المنتج</h2>
        <div class="form-fields">
            <div class="field"><label for="product-name">اسم المنتج <span>*</span></label><input id="product-name" name="name" value="{{ old('name', $product->name ?? '') }}" maxlength="255" required autofocus></div>
            <div class="field"><label for="product-category">الفئة</label><input id="product-category" name="category" value="{{ old('category', $product->category ?? '') }}" maxlength="150"></div>
            <div class="field"><label for="product-barcode">الباركود</label><input id="product-barcode" name="barcode" value="{{ old('barcode', $product->barcode ?? '') }}" maxlength="100"></div>
            <div class="field"><label for="product-supplier">المورد</label><input id="product-supplier" name="supplier" value="{{ old('supplier', $product->supplier ?? '') }}" maxlength="255"></div>
            <div class="field"><label for="product-unit">الوحدة</label>
                @php($unit = old('unit', $product->unit ?? 'قطعة'))
                <select id="product-unit" name="unit">
                    @foreach(['قطعة', 'علبة', 'شريط', 'كرتونة', 'كيلوجرام', 'لتر'] as $option)
                        <option value="{{ $option }}" @selected($unit === $option)>{{ $option }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field"><label for="product-expiry">تاريخ الصلاحية</label><input id="product-expiry" name="expiry_date" type="date" value="{{ old('expiry_date', $product->expiry_date ?? '') }}"></div>
        </div>
    </section>

    <section class="form-section">
        <h2>التسعير والمخزون</h2>
        <div class="form-fields">
            <div class="field"><label for="product-purchase-price">سعر الشراء</label><input id="product-purchase-price" name="purchase_price" type="number" step="0.01" min="0" value="{{ old('purchase_price', $product->buy_price ?? '') }}"></div>
            <div class="field"><label for="product-price">سعر البيع <span>*</span></label><input id="product-price" name="price" type="number" step="0.01" min="0" value="{{ old('price', $product->price ?? '') }}" required></div>
            <div class="field"><label for="product-quantity">الكمية <span>*</span></label><input id="product-quantity" name="quantity" type="number" step="1" min="0" value="{{ old('quantity', $product->quantity ?? 0) }}" required></div>
        </div>
    </section>

    <div class="form-actions">
        <button class="form-submit" type="submit">{{ isset($product) ? 'حفظ التعديلات' : 'حفظ المنتج' }}</button>
        <a class="form-cancel" href="{{ route('products.index') }}">إلغاء</a>
    </div>
</form>
