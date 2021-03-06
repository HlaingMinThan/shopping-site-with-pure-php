<?php 
include('header.php');
 ?>
<!-- End Banner Area -->
<div class="container">
		<div class="row">
			<div class="col-xl-3 col-lg-4 col-md-5">
				<!-- categories sidebar -->
				<?php require "./components/categories.php" ?>
			</div>
			<?php 
					//instock products pagination
				// check pageno exist or not
				if(isset($_GET['pageno'])) 
				{
					$pageno=$_GET['pageno'];
				}
				else{
					$pageno=1;
				}
				$recordsPerPage=3;
				$offset=($pageno-1)*$recordsPerPage;
				// show only instock product
				$stmt=$pdo->prepare("select * from products where quantity>0 limit $offset,$recordsPerPage");
				$stmt->execute();
				$products=$stmt->fetchAll(PDO::FETCH_OBJ);
				// total pages
				// get only instock products count
				$statement=$pdo->prepare("select count(*) from products where quantity>0");
				$statement->execute();
				$result=$statement->fetch();
				$totalproducts=$result[0];//instock products count
				$totalPages=ceil($totalproducts/$recordsPerPage);
			?>
			<div class="col-xl-9 col-lg-8 col-md-7">
				<h1	h1>All Products</h1>
				<?php require "./components/pagination.php"; ?>
			
				<!-- Start Products section -->
				<section class="lattest-product-area pb-40 category-list">
					<div class="row">
					<?php foreach($products as $product) : ?>
						<!-- single product -->
						<div class="col-lg-4 col-md-6">
							<div class="single-product">
							<a href="product_detail.php?id=<?=$product->id;?>" >
								<img class="img-fluid" src="admin/images/products/<?=escape($product->image);?>">
							</a>
								<div class="product-details">
									<h6><a href="product_detail.php?id=<?=escape($product->id);?>"><?= escape($product->name); ?></a></h6>
									<div class="price">
										<h6 class="text-success"><?= escape($product->price); ?>Kyats</h6>
										<?php
											// get category name from product category_id
											 $stmt=$pdo->prepare("select * from categories where id =$product->category_id");
											 $stmt->execute();
											 $category=$stmt->fetch(PDO::FETCH_OBJ);
										?>
										<h6><?= escape($category->name); ?></h6>
									</div>
									<div class="prd-bottom">
										<?php require "./components/addToCartFormButton.php" ?>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
					</div>
				</section>
				<!-- End Products section-->
			</div>
<?php include('footer.php');?>
