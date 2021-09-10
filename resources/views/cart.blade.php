@extends('layouts.master')
@section('title', 'My Cart')
@section('content')

<?php
    require_once(public_path() ."/shared/component.php");
?>

<div id="mycart">
<div class="container-fluid">
    <div class="row px-5">
        <div class="col-md-7">
            <div class="shopping-cart py-4">
                <h5>My Cart</h5>
                <hr>
                <div id="orderlist">
                    <?php
                        orderListDivElement();             
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="price-detail py-4">
                <div id="pricedetail">
                    <?php 
                        priceDetaiDivElement();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function(){
        $('.quantityPlus').click(function(){
            var productId = retrieveProductId("quantityPlus", this.id);
            var quantityElementId = "#quantity" + productId;
            var quantity = $(quantityElementId).val();
            quantity = Number(quantity) + 1;
            $(quantityElementId).val(quantity);
            fetchPriceDetail(productId, quantity);
            setTimeout(fetchCartCount, 500, productId, quantity);  // Needs to delay to execute to wait for Session quantity to be set
        });

        $('.quantityMinus').click(function(){
            var productId = retrieveProductId("quantityMinus", this.id);
            var quantityElementId = "#quantity" + productId;
            var quantity = $(quantityElementId).val();
            quantity = Number(quantity) - 1;
            if (quantity == 0) {
                if (confirm('Are you sure to remove this item?')) {   
                    $(quantityElementId).val(quantity);
                    
                    fetchOrderListForRemove(productId);
                    fetchPriceDetail(productId, quantity);
                    setTimeout(fetchCartCount, 500, productId, quantity);  // Needs to delay to execute to wait for Session quantity to be set
                } else {
                    $(quantityElementId).val(Number(quantity)+1);
                }
            } else {
                $(quantityElementId).val(quantity);
                fetchPriceDetail(productId, quantity);
                setTimeout(fetchCartCount, 500, productId, quantity);  // Needs to delay to execute to wait for Session quantity to be set
            }
        });

        $('.remove').click(function(){
            var productId = retrieveProductId("remove", this.id);
            fetchOrderListForRemove(productId);
            fetchPriceDetail(productId, 0);
            setTimeout(fetchCartCount, 500, productId, 0);  // Needs to delay to execute to wait for Session quantity to be set
        });

        
        $('.quantity').change(function(){
            alert("go");
        });
        
        function fetchPriceDetail(productId, quantity) 
        {
            var value = quantity;
            $.ajax({
                type: 'GET',
                url: '/cart-price',
                data: {'id': productId, 'quantity': value},
                success: function(response) {
                    console.log(response);
                    $('#pricedetail').html(response);
                }
            });
        }

        function fetchOrderListForRemove(productId)
        {
            $.ajax({
                type: 'GET',
                url: '/cart-order',
                data: {'id': productId},
                success: function(response) {
                    console.log(response);
                    $('#orderlist').html(response);
                }
            });
        }

        function fetchCartCount(productId, quantity)
        {
            $.ajax({
                type: 'GET',
                url: '/cart-count',
                data: {'id': productId, 'quantity': quantity},
                success: function(response) {
                    console.log(response);      
                    $('#cartcount').html(response);
                }
            });
        }

        function retrieveProductId(elementClass, elementClassId)
        {
            var lengthClass = elementClass.length;
            var lengthClassId = elementClassId.length;
            var productId = elementClassId.substr(lengthClass, (lengthClassId-lengthClass));

            return productId;
        }
    });

</script>


@endsection