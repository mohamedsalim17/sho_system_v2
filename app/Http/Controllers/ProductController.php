<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
class ProductController extends Controller{
 public function index(Request $request){
    $products = Product::when($request->search, function($q) use ($request){
        $q->where('name','like','%'.$request->search.'%');
    })->latest()->paginate(20); // لازم paginate ما get
    return view('products.index', compact('products'));
}
 public function create(){ return view('products.create'); }
public function store(Request $r){
    $r->validate([
        'name' => 'required',
        'purchase_price' => 'required|numeric',
        'price' => 'required|numeric|gt:purchase_price',
    ],[
        'price.gt' => 'لا يمكن أن يكون سعر البيع أقل من سعر الشراء'
    ]);

    \App\Models\Product::create([
        'name' => $r->name,
        'barcode' => $r->barcode,
        'category' => $r->category,
        'unit' => $r->unit,
        'buy_price' => $r->purchase_price, // هنا التحويل المهم
        'price' => $r->price,
        'quantity' => $r->quantity,
        'description' => $r->description,
    ]);

    return redirect('/products')->with('success','تم الحفظ');
}
 
lic function edit(Product $product){ return view('products.edit',compact('product')); }
public function update(Request $r, \App\Models\Product $product){
    $r->validate([
        'name' => 'required',
        'purchase_price' => 'required|numeric',
        'price' => 'required|numeric|gt:purchase_price',
    ],[
        'price.gt' => 'لا يمكن أن يكون سعر البيع أقل من سعر الشراء'
    ]);

    $product->update([
        'name' => $r->name,
        'barcode' => $r->barcode,
        'category' => $r->category,
        'unit' => $r->unit,
        'buy_price' => $r->purchase_price, // نفس التحويل
        'price' => $r->price,
        'quantity' => $r->quantity,
        'description' => $r->description,
    ]);

    return redirect('/products')->with('success','تم التعديل');
}

 public function destroy(Product $product){ $product->delete(); return back(); }
}