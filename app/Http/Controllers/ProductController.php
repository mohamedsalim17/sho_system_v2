<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
class ProductController extends Controller {
    public function index(Request $r){
        $q=Product::query();
        if($s=$r->search) $q->where('name','like',"%$s%")->orWhere('barcode','like',"%$s%");
        return view('products.index',['products'=>$q->latest()->paginate(10)]);
    }
    public function create(){ $product=new Product(); return view('products.create',compact('product')); }
    public function store(Request $r){
        $r->validate(['name'=>'required','price'=>'required|numeric','quantity'=>'required|integer']);
        Product::create($r->all());
        return redirect()->route('products.index')->with('success','تم');
    }
    public function edit(Product $product){ return view('products.edit',compact('product')); }
    public function update(Request $r, Product $product){ $product->update($r->all()); return redirect()->route('products.index'); }
    public function destroy(Product $product){ $product->delete(); return back(); }
}
