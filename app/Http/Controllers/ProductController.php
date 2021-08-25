<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('product', ['products'=>$products]);
    }

    public function detail($id)
    {
        $product = Product::find($id);
        return view('detail', ['product'=>$product]);
    }

    public function search(Request $request)
    {
        $products = Product::where('name', 'like', '%' .$request->search .'%')->orWhere('description', 'like', '%' .$request->search .'%' )->get();
        return view('search', ['products'=>$products]);
    }
}
