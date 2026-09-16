<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;


Class ProductController extends Controller
{
    public function create()
    
    {
       return view ('products.create');
    }
    
    public function store(Request $request)
    {

         Product::create($request->all());
       return "تم الحفظ بنجاح ";
   
}
public function index()
{
    $products = Product::all();
    return view('products.index',compact('products'));
}

}
    

   

    