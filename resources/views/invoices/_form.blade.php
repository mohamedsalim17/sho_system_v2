@if($errors->any())
    <div class="form-errors" role="alert"><strong>تعذر حفظ الفاتورة:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

@php
    $currentLines = old('products', isset($invoice)
        ? $invoice->items->map(fn ($item) => ['product_id' => $item->product_id, 'quantity' => $item->quantity])->all()
        : [['product_id' => '', 'quantity' => 1]]);
    $currentStock = isset($invoice)
        ? $invoice->items->groupBy('product_id')->map(fn ($items) => $items->sum('quantity'))
        : collect();
@endphp

<form action="{{ isset($invoice) ? route('invoices.update', $invoice) : route('invoices.store') }}" method="POST" class="data-form" id="invoice-form">
    @csrf
    @if(isset($invoice)) @method('PUT') @endif
    <section class="form-section">
        <h2>بيانات الفاتورة</h2>
        <div class="form-fields">
            <div class="field"><label for="invoice-customer">العميل <span>*</span></label>
                <select id="invoice-customer" name="customer_id" required>
                    <option value="">اختر العميل</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" @selected((string) old('customer_id', $invoice->customer_id ?? '') === (string) $customer->id)>{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field"><label for="invoice-date">تاريخ الفاتورة <span>*</span></label><input id="invoice-date" name="invoice_date" type="date" value="{{ old('invoice_date', isset($invoice?->invoice_date) ? $invoice->invoice_date->format('Y-m-d') : now()->toDateString()) }}" max="{{ now()->toDateString() }}" required></div>
            <div class="field field-wide"><label for="invoice-notes">ملاحظات</label><textarea id="invoice-notes" name="notes" rows="2" maxlength="2000">{{ old('notes', $invoice->notes ?? '') }}</textarea></div>
        </div>
    </section>

    <section class="form-section">
        <h2>المنتجات</h2>
        <p class="form-note">يُحتسب السعر من سعر البيع المحفوظ، وتُراجع الكمية المتاحة عند الحفظ.</p>
        <div class="invoice-lines" id="invoice-lines">
            @foreach($currentLines as $index => $line)
                <div class="invoice-line">
                    <div class="field"><label>المنتج</label>
                        <select name="products[{{ $index }}][product_id]" class="invoice-product" required>
                            <option value="">اختر المنتج</option>
                            @foreach($products as $product)
                                @php($stock = $product->quantity + (int) ($currentStock[$product->id] ?? 0))
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $stock }}" @selected((string) ($line['product_id'] ?? '') === (string) $product->id)>
                                    {{ $product->name }} — {{ number_format((float) $product->price, 2) }} (المتاح: {{ $stock }} {{ $product->unit }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field"><label>الكمية</label><input class="invoice-quantity" type="number" name="products[{{ $index }}][quantity]" value="{{ $line['quantity'] ?? 1 }}" min="1" step="1" required></div>
                    <div class="invoice-line-total" aria-live="polite">0.00</div>
                    <button class="invoice-remove" type="button" aria-label="حذف المنتج من الفاتورة">إزالة</button>
                </div>
            @endforeach
        </div>
        <button class="form-cancel" type="button" id="add-invoice-line">إضافة منتج</button>
        <div class="invoice-total">الإجمالي التقديري: <strong id="invoice-total">0.00</strong></div>
    </section>

    <div class="form-actions"><button class="form-submit" type="submit">{{ isset($invoice) ? 'حفظ تعديلات الفاتورة' : 'حفظ الفاتورة' }}</button><a class="form-cancel" href="{{ route('invoices.index') }}">إلغاء</a></div>
</form>

@push('scripts')
<script>
(() => {
    const lines = document.getElementById('invoice-lines');
    const total = document.getElementById('invoice-total');
    const firstLine = lines.querySelector('.invoice-line');
    const productOptions = firstLine.querySelector('.invoice-product').innerHTML;

    function updateTotals() {
        let sum = 0;
        lines.querySelectorAll('.invoice-line').forEach((line) => {
            const select = line.querySelector('.invoice-product');
            const option = select.options[select.selectedIndex];
            const quantity = Number(line.querySelector('.invoice-quantity').value || 0);
            const stock = Number(option?.dataset.stock || 0);
            line.querySelector('.invoice-quantity').max = stock || '';
            const subtotal = Number(option?.dataset.price || 0) * quantity;
            line.querySelector('.invoice-line-total').textContent = subtotal.toFixed(2);
            sum += subtotal;
        });
        total.textContent = sum.toFixed(2);
    }

    function reindex() {
        lines.querySelectorAll('.invoice-line').forEach((line, index) => {
            line.querySelector('.invoice-product').name = `products[${index}][product_id]`;
            line.querySelector('.invoice-quantity').name = `products[${index}][quantity]`;
        });
        updateTotals();
    }

    document.getElementById('add-invoice-line').addEventListener('click', () => {
        const line = document.createElement('div');
        line.className = 'invoice-line';
        line.innerHTML = `<div class="field"><label>المنتج</label><select class="invoice-product" required>${productOptions}</select></div><div class="field"><label>الكمية</label><input class="invoice-quantity" type="number" value="1" min="1" step="1" required></div><div class="invoice-line-total" aria-live="polite">0.00</div><button class="invoice-remove" type="button" aria-label="حذف المنتج من الفاتورة">إزالة</button>`;
        lines.appendChild(line);
        reindex();
    });

    lines.addEventListener('click', (event) => {
        if (event.target.classList.contains('invoice-remove') && lines.querySelectorAll('.invoice-line').length > 1) {
            event.target.closest('.invoice-line').remove();
            reindex();
        }
    });
    lines.addEventListener('input', updateTotals);
    lines.addEventListener('change', updateTotals);
    updateTotals();
})();
</script>
@endpush
