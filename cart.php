<?php 
    require "./header.php";
?>


    <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">
                <div class="table-responsive">
                
                <?php if(isset($_SESSION['cart']) && !empty($_SESSION['cart']['items'])){ ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php 
                           
                            $items=$_SESSION['cart']['items'];
                            $subtotal=0;
                            foreach($items as $product_id=>$qty) :
                                //$product_id = 'id2'
                                $id=substr($product_id,2);
                                // echo ($id);
                                $stmt=$pdo->prepare("select * from products where id =?");  
                                $stmt->execute([$id]);
                                $product=$stmt->fetch(PDO::FETCH_OBJ);
                                $total=$product->price*$qty;
                                
                                $subtotal+=$product->price*$qty; 
                            ?>
                            <tr>
                                <td>
                                    <div class="media">
                                        <div class="d-flex">
                                            <a href="product_detail.php?id=<?=$product->id;?>">
                                            <img src="./admin/images/products/<?=$product->image;?>" width="100" height="100">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <p><?= $product->name; ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h5 class=""><?= $product->price; ?> kyats</h5>
                                </td>
                                <td>
                                    <div class="product_count">
                                        <b><?= $qty; ?></b>
                                        <!-- <input type="text" name="qty" id="sst" maxlength="12" value="<?=$qty?>" title="Quantity:"
                                            class="input-text qty">
                                        <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                                            class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                                        <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
                                            class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button> -->
                                    </div>
                                </td>
                                <td>
                                <!-- total -->
                                    <h5><?= $total; ?>kyats</h5>
                                </td>
                                <td>
                                    <a href="clear_item.php?clear_item_id=<?=$product_id?>" class="primary-btn">Remove from cart</a>
                                </td>
                            </tr>
                            <?php endforeach;?>
                            
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <h5>Subtotal</h5>
                                </td>
                                <td>
                                    <h5><?= $subtotal; ?> kyats</h5>
                                </td>
                            </tr>
                            <tr class="out_button_area">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="checkout_btn_inner d-flex align-items-center">
                                        <a class="gray_btn" href="./index.php">Continue Shopping</a>
                                        <a class="primary-btn" href="./confirmation.php">Order Submit</a>
                                        <a class="gray_btn" href="clear_items.php">Clear Items</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                <?php  } else {?>  
                    <h2>No Items in the cart yet!</h2>   
                    <a class="primary-btn" href="./index.php">Go Back Shopping</a>
                <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <!--================End Cart Area =================-->

   <?php require "footer.php" ?>