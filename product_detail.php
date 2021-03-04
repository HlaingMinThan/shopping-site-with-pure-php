<?php 
  include('header.php'); 
  $id=$_GET['id'];
  $stmt=$pdo->prepare("select * from products where id =?");  
  $stmt->execute([$id]);
  $product=$stmt->fetch(PDO::FETCH_OBJ);

  // get category name from product category_id
  $stmt=$pdo->prepare("select * from categories where id =?");
  $stmt->execute([$product->category_id]);
  $category=$stmt->fetch(PDO::FETCH_OBJ);
  $categoryName=$category->name;
?>
<!--================Single Product Area =================-->
<div class="product_image_area" style="padding: 0;">
  <div class="container">
    <div class="row s_product_inner">
      <div class="col-lg-6">
        <img class="img-fluid mt-5" src="admin/images/products/<?=escape($product->image);?>" style="width:80%;">

      </div>
      <div class="col-lg-5 offset-lg-1">
        <div class="s_product_text">
          <h3><?= escape($product->name); ?></h3>
          <h2><?= escape($product->price); ?> Kyats</h2>
          <ul class="list">
            <li><a class="active" href="#"><span>Category</span> : <?= $categoryName; ?></a></li>
            <li><a href="#"><span>in stock</span> : <?= $product->quantity; ?></a></li>
            <p style="color:red"><?= empty($_SESSION['quantityError'])?'':$_SESSION['quantityError']; ?></p>
          </ul>
          <p><?= $product->description; ?></p>
          <!-- add to cart functionality -->
            <form action="add_to_cart.php" method="POST">
                <input type="hidden" name="_token" value="<?=empty($_SESSION['_token'])?'':$_SESSION['_token'];?>">
                <input type="hidden" name="id" value="<?=$product->id;?>">
                <div class="product_count">
                <label for="qty">Quantity:</label>
                <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
                <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
                class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
              </div>
              <div class="card_area d-flex align-items-center">
                <button class="primary-btn" type="submit" style="border: 0;">Add to Cart</button>
                <a class="primary-btn" href="./index.php">Go back</a>
              </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div><br>
<!--================End Single Product Area =================-->

<!--================End Product Description Area =================-->
<?php include('footer.php');?>
