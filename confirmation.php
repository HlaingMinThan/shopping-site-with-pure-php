<?php

require "./header.php";

if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header('Location: login.php');
}

if (!empty($_SESSION['cart']) && !empty($_SESSION['cart']['items'])) {
	$userId = $_SESSION['user_id'];
	// start getting total price 
	$total = 0;
	$items=$_SESSION['cart']['items'];
	foreach ($items as $product_id => $qty) {
		$id=substr($product_id,2);
		$stmt = $pdo->prepare("select * FROM products where id=?");
		$stmt->execute([$id]);
		$product=$stmt->fetch(PDO::FETCH_OBJ);
		$total+=$product->price*$qty;
	}
	// end getting total price 

	//insert into orders table
	$stmt = $pdo->prepare("insert into orders(customer_id,total_price,order_date) VALUES (?,?,?)");
	$result = $stmt->execute([$userId,$total,date('Y-m-d H:i:s')]);

	if ($result) {
		$orderId = $pdo->lastInsertId();
		// insert into order_details
		foreach ($items as $product_id => $qty) {
			$id=substr($product_id,2);

			$stmt = $pdo->prepare("insert into order_details(order_id,product_id,quantity) values (?,?,?)");
			$result = $stmt->execute([$orderId,$id,$qty]);

			$qtyStmt = $pdo->prepare("select quantity from products where id=?");
			$qtyStmt->execute([$id]);
			$qResult = $qtyStmt->fetch(PDO::FETCH_OBJ);

			$updateQty = $qResult->quantity - $qty;

			$stmt = $pdo->prepare("update products set quantity=? WHERE id=?");

			$stmt->execute([$updateQty,$id]);
		}

		unset($_SESSION['cart']);

	}
}

?>


	<!--================Order Details Area =================-->
	<section class="order_details section_gap">
		<div class="container">
			<h3 class="title_confirmation">Thank you. Your order has been received.</h3>
			<div class="row order_d_inner">
				<div class="col-lg-6">
					<div class="details_item">
						<h4>Order Info</h4>
						<ul class="list">
							<li><a href="#"><span>Order number</span> : 60235</a></li>
							<li><a href="#"><span>Date</span> : Los Angeles</a></li>
							<li><a href="#"><span>Total</span> : USD 2210</a></li>
							<li><a href="#"><span>Payment method</span> : Check payments</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="details_item">
						<h4>Shipping Address</h4>
						<ul class="list">
							<li><a href="#"><span>Street</span> : 56/8</a></li>
							<li><a href="#"><span>City</span> : Los Angeles</a></li>
							<li><a href="#"><span>Country</span> : United States</a></li>
							<li><a href="#"><span>Postcode </span> : 36952</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--================End Order Details Area =================-->
<?php require "footer.php"; ?>