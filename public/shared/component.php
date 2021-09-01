<?php
    function cartElement($imageName, $productName, $productDescription, $price, $quantity)
    {
        print_r($imageName);
        $element = "
            <form action=\"/cart\" method=\"get\" class=\"cart-items\">
                <div class=\"border rounded\">
                    <div class=\"row bg-white\">
                        <div class=\"col-md-3\">
                            <img src=\"\images\\" .$imageName . "\" style=\"width: 100%\">
                                      
                        </div>
                        <div class=\"col-md-6\">
                            <h5 class=\"pt-2\">" .$productName ."</h3>
                            <small class=\"text-secondary\">" .$productDescription ."</small>
                            <h5 class=\"pt-1\">" .$price ."</h5>
                            <div class=\"pb-1\">
                            <button type=\"submit\" class=\"btn btn-warning\">Save for Later</button>
                            <button type=\"submit\" class=\"btn btn-danger mx-2\" name=\"remove\">Remove</button>
                            </div>
                        </div>
                        <div class=\"col-md-3\">
                            <div class=\"py-5\">
                                <button type=\"button\" class=\"btn bg-light border rounded-circle\"><i class=\"fas fa-minus\"></i></button>
                                <input type=\"text\" value=\"" .$quantity ."\" class=\"form-control w-25 d-inline\">
                                <button type=\"button\" class=\"btn bg-light border rounded-circle\"><i class=\"fas fa-plus\"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        ";
        echo $element;
    }
?>