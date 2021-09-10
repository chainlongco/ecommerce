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
        $('#quantityPlus').click(function(){
            var value = $("#quantity").val();
            value = Number(value) + 1;
            $("#quantity").val(value);
            fetchPriceDetail();
            setTimeout(fetchCartCount, 300);  // Needs to delay to execute to wait for Session quantity to be set
        });

        $('#quantityMinus').click(function(){
            var value = $("#quantity").val();
            value = Number(value) - 1;
            if (value == 0) {
                if (confirm('Are you sure to remove this item?')) {   
                    $("#quantity").val(value);
                    
                    fetchOrderListForRemove();
                    fetchPriceDetail();
                    setTimeout(fetchCartCount, 300);  // Needs to delay to execute to wait for Session quantity to be set
                } else {
                    $("#quantity").val(Number(value)+1);
                }
            } else {
                $("#quantity").val(value);
                fetchPriceDetail();
                setTimeout(fetchCartCount, 300);  // Needs to delay to execute to wait for Session quantity to be set
            }
        });

        $('#remove').click(function(){
            fetchOrderListForRemove();
            fetchPriceDetailForRemoveButton();
            setTimeout(fetchCartCount, 300);  // Needs to delay to execute to wait for Session quantity to be set
        });

        
        $('#quantity').change(function(){
            alert("go");
        });
        
        function fetchPriceDetail() 
        {
            var value = $("#quantity").val();
            $.ajax({
                type: 'GET',
                url: '/cart-price',
                data: {'id': 1, 'quantity': value},
                success: function(response) {
                    console.log(response);
                    $('#pricedetail').html(response);
                }
            });
        }

        function fetchPriceDetailForRemoveButton() 
        {
            var value = 0;
            $.ajax({
                type: 'GET',
                url: '/cart-price',
                data: {'id': 1, 'quantity': value},
                success: function(response) {
                    console.log(response);
                    $('#pricedetail').html(response);
                }
            });
        }

        function fetchOrderListForRemove()
        {
            $.ajax({
                type: 'GET',
                url: '/cart-order',
                data: {'id': 1},
                success: function(response) {
                    console.log(response);
                    $('#orderlist').html(response);
                }
            });
        }

        function fetchCartCount()
        {
            var value = $("#quantity").val();
            $.ajax({
                type: 'GET',
                url: '/cart-count',
                data: {'id': 1, 'quantity': value},
                success: function(response) {
                    console.log(response);
                    $('#cartcount').html(response);
                }
            });
        }
    });

</script>


@endsection