<?php 
include('header.php');
if(isset($_GET['cat_id'])){
    $_SESSION['cat_id']=$_GET['cat_id'];
}
 ?>
<!-- End Banner Area -->
<div class="container">
		<div class="row">
			<div class="col-xl-3 col-lg-4 col-md-5">
				<!-- categories sidebar -->
				<?php require "./components/categories.php" ?>
				<?php
					$id=isset($_GET['cat_id'])?$_GET['cat_id']:$_SESSION['cat_id'];
					$stmt=$pdo->prepare("select * from categories where id =?");
					$stmt->execute([$id]);
					$category=$stmt->fetch(PDO::FETCH_OBJ);
					$categoryName=$category->name;
				?>
			</div>
			<?php 
				if(isset($_GET['cat_id']) || isset($_SESSION['cat_id'])){

                    $id=isset($_GET['cat_id'])?$_GET['cat_id']:$_SESSION['cat_id'];
                      // pagination
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
                    $stmt=$pdo->prepare("select * from products where  category_id=? limit $offset,$recordsPerPage");
                    $stmt->execute([$id]);
                    $products=$stmt->fetchAll(PDO::FETCH_OBJ);
                    // total pages
                    $statement=$pdo->prepare("select count(*) from products where  category_id=?");
                    $statement->execute([$id]);
                    $result=$statement->fetch();
                    $totalproducts=$result[0];
                    $totalPages=ceil($totalproducts/$recordsPerPage);
                }
				
			?>
			<div class="col-xl-9 col-lg-8 col-md-7">
				<h1>Category-<?= escape($categoryName); ?></h1>
                <?php require "./components/pagination.php"; ?>
			
				<!-- Start Products section -->
				<section class="lattest-product-area pb-40 category-list">
					<div class="row">
					<?php foreach($products as $product) : ?>
						<!-- single product -->
						<div class="col-lg-4 col-md-6">
							<div class="single-product">
							<a href="product_detail.php?id=<?=$product->id;?>">
								<img class="img-fluid" src="admin/images/products/<?=escape($product->image);?>" alt="">
							</a>
								<div class="product-details">
									<h6><a href="product_detail.php?id=<?=escape($product->id);?>"><?= escape($product->name); ?></a></h6>
									<div class="price">
										<h6 class="text-success"><?= escape($product->price); ?>Kyats</h6>
										<h6><?= escape($categoryName); ?></h6>
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