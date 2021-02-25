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