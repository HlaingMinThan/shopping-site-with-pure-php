<?php 
    session_start();
    $id=$_GET['clear_item_id'];
    unset($_SESSION['cart']['items'][$id]);
    header("location:cart.php");
?>