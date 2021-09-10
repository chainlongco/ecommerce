<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
require_once(public_path() ."/shared/component.php");

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
                    if($productsArray[$key]['productId'] == $id) {
                        Session::pull('cart.' .$key);
                        Session::push('cart', array('productId'=>$id, 'quantity'=>(int)$productsArray[$key]['quantity'] + 1));
                    } else {
                        //print_r("not inside");
                    }
                }
            }
        }
        return redirect('/cart');
    }

    public function cart()
    {
        return view('cart');
    }

    public function cartPriceDetail(Request $request)
    {
        //print_r($request->input('quantity'));
        $id = $request->input('id');
        $quantity = $request->input('quantity');
        $productsArray = Session::get('cart');
        foreach($productsArray as $key=>$value){
            if($productsArray[$key]['productId'] == $id) {
                if ($quantity != 0) {
                    Session::pull('cart.' .$key);
                    Session::push('cart', array('productId'=>$id, 'quantity'=>(int)$quantity));
                } else {
                    Session::forget('cart.' .$key);
                }
            } else {
                //print_r("not inside");
            }
        }
        echo (priceDetaiDivElement());
    }

    public function cartRemoveFromOrderList(Request $request)
    {
        //echo $request->input('id');
        $id = $request->input('id');
        $productsArray = Session::get('cart');
        foreach($productsArray as $key=>$value){
            if($productsArray[$key]['productId'] == $id) {
                Session::forget('cart.' .$key);
            } else {
                //print_r("not inside");
            }
        }
        echo orderListDivElement();
    }

    public function cartCount(Request $request)
    {

        $count = 0;
        if (Session::has('cart')) {
            foreach (Session::get('cart') as $products){
                foreach($products as $key=>$value) {
                    if ($key == "quantity") {
                        $count = $count + (int)$value;
                    }
                }
            }
        }
        echo cartCountSpanElement();
        //print_r($count);
        //print_r($request->input('quantity'));
    }

}
