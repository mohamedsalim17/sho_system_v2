<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('customer')->latest('id')->paginate(25);

        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get(['id', 'name']);
        $products = Product::where('quantity', '>', 0)->orderBy('name')->get(['id', 'name', 'price', 'quantity', 'unit']);

        return view('invoices.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedInvoice($request);

        $invoice = DB::transaction(function () use ($data) {
            $invoice = Invoice::create([
                'customer_id' => $data['customer_id'],
                'invoice_date' => $data['invoice_date'],
                'total_amount' => 0,
                'notes' => $data['notes'] ?? null,
            ]);

            $this->replaceItems($invoice, $data['products']);

            return $invoice;
        });

        return redirect()->route('invoices.show', $invoice)->with('success', 'تم حفظ الفاتورة وتحديث المخزون.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['customer', 'items.product']);

        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $invoice->load('items');
        $customers = Customer::orderBy('name')->get(['id', 'name']);
        $products = Product::orderBy('name')->get(['id', 'name', 'price', 'quantity', 'unit']);

        return view('invoices.edit', compact('invoice', 'customers', 'products'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $data = $this->validatedInvoice($request);

        DB::transaction(function () use ($data, $invoice) {
            $invoice = Invoice::whereKey($invoice->id)->lockForUpdate()->firstOrFail();
            foreach ($invoice->items as $item) {
                Product::whereKey($item->product_id)->lockForUpdate()->increment('quantity', $item->quantity);
            }

            $invoice->update([
                'customer_id' => $data['customer_id'],
                'invoice_date' => $data['invoice_date'],
                'notes' => $data['notes'] ?? null,
            ]);
            $invoice->items()->delete();
            $this->replaceItems($invoice, $data['products']);
        });

        return redirect()->route('invoices.show', $invoice)->with('success', 'تم تحديث الفاتورة والمخزون.');
    }

    public function destroy(Invoice $invoice)
    {
        DB::transaction(function () use ($invoice) {
            $invoice = Invoice::whereKey($invoice->id)->lockForUpdate()->firstOrFail();
            foreach ($invoice->items as $item) {
                Product::whereKey($item->product_id)->lockForUpdate()->increment('quantity', $item->quantity);
            }
            $invoice->delete();
        });

        return redirect()->route('invoices.index')->with('success', 'تم حذف الفاتورة وإرجاع كمياتها إلى المخزون.');
    }

    private function validatedInvoice(Request $request): array
    {
        return $request->validate([
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'invoice_date' => ['required', 'date', 'before_or_equal:today'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'products' => ['required', 'array', 'min:1', 'max:100'],
            'products.*.product_id' => ['required', 'integer', 'distinct', 'exists:products,id'],
            'products.*.quantity' => ['required', 'integer', 'min:1', 'max:100000'],
        ]);
    }

    private function replaceItems(Invoice $invoice, array $lines): void
    {
        $total = 0;
        foreach ($lines as $line) {
            $product = Product::whereKey($line['product_id'])->lockForUpdate()->firstOrFail();
            $quantity = (int) $line['quantity'];
            if ($product->quantity < $quantity) {
                throw ValidationException::withMessages([
                    'products' => "الكمية المطلوبة من المنتج «{$product->name}» أكبر من المتاح في المخزون.",
                ]);
            }

            $price = (float) $product->price;
            $subtotal = round($price * $quantity, 2);
            $product->decrement('quantity', $quantity);
            $invoice->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => $subtotal,
            ]);
            $total += $subtotal;
        }

        $invoice->update(['total_amount' => round($total, 2)]);
    }
}
