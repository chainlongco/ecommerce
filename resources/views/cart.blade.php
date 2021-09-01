@extends('layouts.master')
@section('title', 'My Cart')
@section('content')

<div class="container-fluid">
    <div class="row px-5">
        <div class="col-md-7">
            <div class="shopping-cart my-6">
                <?php
                    require_once(public_path() ."/shared/component.php");
                    use App\Models\Product;

                    if (Session::has('cart')){
                        foreach (Session::get('cart') as $products){
                            $quantity = 0;
                            $product = null;
                            foreach($products as $key=>$value) {              
                                if ($key == "productId") {
                                    $product = Product::find($value);
                                }
                                if ($key == "quantity") {
                                    $quantity = $value;
                                }            
                            }
                            if ($product != null) {
                                cartElement($product->gallery, $product->name, $product->description, $product->price, $quantity);
                            }       
                        }
                        
                    }                    
                ?>
            </div>
        </div>
        <div class="col-md-5">

        </div>
    </div>
</div>


@endsection