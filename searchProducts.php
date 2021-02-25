<?php 
include('header.php');
 ?>
<!-- End Banner Area -->
<div class="container">
		<div class="row">
			<div class="col-xl-3 col-lg-4 col-md-5">
				<?php require "./components/categories.php" ?>
			</div>
			<?php 
					 // pagination
                        // check pageno exist or not
                        if(isset($_GET['search'])){
                            setcookie("search",$_GET['search'],time()+3600);
                        }
						if(isset($_GET['pageno'])) 
						{
						  $pageno=$_GET['pageno'];
						}
						else{
						  $pageno=1;
						}
                        if(isset($_GET['search'])||isset($_COOKIE['search'])){
                            $recordsPerPage=3;
                            $offset=($pageno-1)*$recordsPerPage;
                            $search=isset($_GET['search'])?$_GET['search']:$_COOKIE['search'];
                            $stmt=$pdo->prepare("select * from products where name like '%$search%' limit $offset,$recordsPerPage");
                            $stmt->execute();
                            $products=$stmt->fetchAll(PDO::FETCH_OBJ);
                            // total pages
                            $statement=$pdo->prepare("select count(*) from products where name like '%$search%'");
                            $statement->execute();
                            $result=$statement->fetch();
                            $totalproducts=$result[0];
                            $totalPages=ceil($totalproducts/$recordsPerPage);
                        }
			?>
			<div class="col-xl-9 col-lg-8 col-md-7">
			<!-- Start Pagination Bar -->
			<div class="filter-bar d-flex flex-wrap align-items-center">
				<div class="pagination">
					<a href="<?=$pageno<=1? "#":"?pageno=".$pageno-1; ?>" class="prev-arrow" <?php echo $pageno<=1 ? 'disabled' :'' ;?>><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
					<?php  foreach(range(1,$totalPages) as $page):?>
						<a  href="?pageno=<?=$page;?>"><?=$page;?></a>
					<?php endforeach; ?>

					<a  href='<?=$pageno>=$totalPages? "#":"?pageno=".$pageno+1;  ?>' class="next-arrow" <?php echo $pageno>=$totalPages ? 'disabled' :'' ;?>><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
				</div>
			</div>
				<!-- End Pagination Bar -->
			
				<!-- Start Products section -->
				<section class="lattest-product-area pb-40 category-list">
					<div class="row">
					<?php foreach($products as $product) : ?>
						<!-- single product -->
						<div class="col-lg-4 col-md-6">
							<div class="single-product">
								<img class="img-fluid" src="admin/images/products/<?=escape($product->image);?>" alt="">
								<div class="product-details">
									<h6><?= escape($product->name); ?></h6>
									<div class="price">
										<h6 class="text-success"><?= escape($product->price); ?>Kyats</h6>
									</div>
									<div class="prd-bottom">

										<a href="" class="social-info">
											<span class="ti-bag"></span>
											<p class="hover-text">add to bag</p>
										</a>
										<a href="./product_detail.php" class="social-info">
											<span class="lnr lnr-move"></span>
											<p class="hover-text">view more</p>
										</a>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
					</div>
				</section>
				<!-- End Products section-->
<?php include('footer.php');?>
