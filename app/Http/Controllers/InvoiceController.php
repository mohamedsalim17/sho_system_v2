<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Product;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

Class InvoiceController extends Controller
{
    // صفحة اضافة الفاتورة
    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('invoices.create', compact('customers', 'products'));
    }

    // حفظ الفاتورة
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'invoice_date' => 'required|date',
            'products' => 'required|array',
        ]);

        DB::transaction(function () use ($request) {
            $total = 0;
            foreach($request->products as $product){
                $total += $product['price'] * $product['quantity'];
            }

            $invoice = Invoice::create([
                'customer_id' => $request->customer_id,
                'invoice_date' => $request->invoice_date,
                'total_amount' => $total,
                'notes' => $request->notes
            ]);

            foreach($request->products as $product){
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'subtotal' => $product['price'] * $product['quantity']
                ]);
            }
        });

        return redirect()->route('invoices.create')->with('success', 'تم حفظ الفاتورة بنجاح');
    }
    public function index()
{
    $products = Product::all();
    return view('invoices.index',compact('products'));
}
public function show($id){}
}
