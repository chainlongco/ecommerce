<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

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

    public function addToCart($id)
    {
        if (!Session::has('cart'))
        {
            $item_array = array('productId'=>$id, 'quantity'=>'1');
            $cartArray = array();
            $cartArray[0] = $item_array;
            Session::put('cart', $cartArray);
        }
        else
        {
            $productIdExists = false;
            $productsArray = Session::get('cart');
            foreach(Session::get('cart') as $products) {
                $quantity = 0;
                foreach($products as $key=>$value) {
                    if ($value == $id) {
                        $productIdExists = true;
                    }
                }
                if ($productIdExists == true) {
                    break;
                }
            }
            if ($productIdExists == false) {
                Session::push('cart', array('productId'=>$id, 'quantity'=>'1'));
            } else {
                foreach($productsArray as $key=>$value){
                    print_r("key: " .$key);
                    echo("<br>");
                    print_r("Id: " .$id);
                    //print_r("Value: " .$value);
                    echo("<br>");
                    if($productsArray[$key]['productId'] == $id) {

                        //print_r("inside: " .$productsArray[$key]['quantity']);
                        //Session::put('cart')[$key]['quantity'] = 2;//(int)$productsArray[$key]['quantity'] + 1;
                        Session::pull('cart.' .$key);
                        Session::push('cart', array('productId'=>$id, 'quantity'=>(int)$productsArray[$key]['quantity'] + 1));
                    } else {
                        print_r("not inside");
                    }
                }
            }
        }
        echo "<br>";
        print_r(Session::get('cart'));
        //echo "<br>";
        //print_r(count(Session::get('cart')));
        return view('cart');
    }

    public function cart()
    {
        return view('cart');
    }
}
