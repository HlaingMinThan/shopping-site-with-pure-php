<?php

require "../config/common.php";
require "../config/config.php";

$id=$_GET['id'];
$stmt=$pdo->prepare("delete from categories where id = ?");
$stmt->execute([$id]);
header("location:cat_index.php");