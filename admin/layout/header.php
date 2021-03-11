<?php 

require "../config/common.php";
require "../config/config.php";

if(!$_SESSION["user_id"] && !$_SESSION["logged_in"]){
  header("location:/admin/login.php");
}
if($_SESSION["user_id"] && $_SESSION["logged_in"] && $_SESSION["role"]!=1){
  header("location:/admin/login.php");
}
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Creative Coder Shopping Admin</title>
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
  <?php
  $path=$_SERVER["REQUEST_URI"];
  $pathCut=substr($path,7);
  $pathCutArr=explode('?',$pathCut);
  $fileName=$pathCutArr[0];
  // die($fileName);
  if($fileName==='' || $fileName==='index.php' || $fileName==='searchProducts.php'){
    $action="searchProducts.php";
  }
  if($fileName==='cat_index.php' || $fileName==='searchCategories.php'){
    $action="searchCategories.php";
  }
  if($fileName==='user_index.php' || $fileName==='searchUsers.php'){
    $action="searchUsers.php";
  }
  ?>

    <!-- SEARCH FORM -->
    <?php if($fileName==""||$fileName=="index.php"||$fileName=="cat_index.php"||$fileName=="user_index.php"||$fileName=="searchProducts.php"||$fileName=="searchUsers.php"||$fileName=="searchCategories.php"):?>
      <form class="form-inline ml-3"  action="<?=$action;?>"> 
        <div class="input-group input-group-sm">
          <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search" name="search">
          <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>
    <?php endif; ?>
    <div class="">
      <a class="btn btn-primary ml-3" href="logout.php">Logout</a>
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">CC Shopping Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?=escape($_SESSION['username']);?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="index.php" class="nav-link <?=$fileName===''||$fileName==='index.php' ? 'active':'';?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Products
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="cat_index.php" class="nav-link  <?=$fileName==='cat_index.php' ? 'active':'';?>">
              <i class="fa fa-list-alt ml-1"></i>
              <p>
                Categories
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="user_index.php" class="nav-link  <?=$fileName==='user_index.php' ? 'active':'';?>">
              <i class="nav-icon fas fa-user"></i>
              <p>
              Customers
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="order_index.php" class="nav-link  <?=$fileName==='order_index.php' ? 'active':'';?>">
              <i class="fa fa-shopping-cart ml-1"></i>
              <p>
                Orders
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
               Reporting
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="weekly_reports.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Weekly Reporting</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="monthly_reports.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Monthly Reporting</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="royal_users.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Royal Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Best Seller Items</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  