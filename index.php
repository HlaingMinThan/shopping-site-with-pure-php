<?php 
require "./config/common.php";
require "./config/config.php";
include('header.php');
 ?>
<!-- End Banner Area -->
<div class="container">
		<div class="row">
			<div class="col-xl-3 col-lg-4 col-md-5">
				<div class="sidebar-categories">
					<div class="head">Browse Categories</div>
					<ul class="main-categories">
					<?php 
					 $stmt=$pdo->prepare("select * from categories order by id desc");
					 $stmt->execute();
					 $categories=$stmt->fetchAll(PDO::FETCH_OBJ);
                     
                             
                         
						
                          
                    if($categories)
                    {
                        foreach($categories as $category): 
							// get product count of each category
						$statement=$pdo->prepare('select count(*) from products where category_id=?');
						$statement->execute([$category->id]);
						$prdouctAmount=$statement->fetch()[0];
                    ?>
                      		<li class="main-nav-list child"><a href="#"><?= $category->name; ?><span class="number">(<?= $prdouctAmount; ?>)</span></a></li>
                    <?php 
                        endforeach;
                      }
                    ?>
					</ul>
				</div>
			</div>
			<?php 
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
						$stmt=$pdo->prepare("select * from products limit $offset,$recordsPerPage");
						$stmt->execute();
						$products=$stmt->fetchAll(PDO::FETCH_OBJ);
						// total pages
						$statement=$pdo->prepare('select count(*) from products');
						$statement->execute();
						$result=$statement->fetch();
						$totalproducts=$result[0];
						$totalPages=ceil($totalproducts/$recordsPerPage);
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
			
				<!-- Start Best Seller -->
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
				<!-- End Best Seller -->
<?php include('footer.php');?>
