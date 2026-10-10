<?php
namespace App\Http\Controllers;
use App\Models\Product;
class ProductController extends Controller{
 public function index(){ $products=Product::latest()->get(); return view('products.index',compact('products')); }
 public function create(){ return view('products.create'); }
 public function store(\Illuminate\Http\Request $r){ Product::create($r->all()); return redirect('/products'); }
 public function edit(Product $product){ return view('products.edit',compact('product')); }
 public function update(\Illuminate\Http\Request $r, Product $product){ $product->update($r->all()); return redirect('/products'); }
 public function destroy(Product $product){ $product->delete(); return back(); }
}