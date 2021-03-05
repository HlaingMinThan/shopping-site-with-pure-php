<?php 
require "./config/common.php";


if(isset($_POST)){
    // validation
    // check user input qty is number or not`
    $product_id=$_POST['id'];
    $product_qty=$_POST['qty'];
    if(is_numeric($product_qty)){

        // check the product is already in the cart or not
        if(isset($_SESSION['cart']['items']['id'.$product_id])){
            $_SESSION['cart']['items']['id'.$product_id]+=$product_qty;
        }else{
            $_SESSION['cart']['items']['id'.$product_id]=$product_qty;
        }
        header('location:cart.php');
    }else{
        $_SESSION['quantityValidationError']="please write quantity number only";
        header("location:product_detail.php?id=$product_id");
    }
}


?>