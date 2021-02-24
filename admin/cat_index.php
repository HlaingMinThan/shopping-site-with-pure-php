<?php
    require "../config/common.php";
    if(!$_SESSION["user_id"] && !$_SESSION["logged_in"]){
      header("location:login.php");
    }
    if($_SESSION["user_id"] && $_SESSION["logged_in"] && $_SESSION["role"]!=1){
      header("location:login.php");
    }
    require "../config/config.php";
    require "layout/header.php";
    if(isset($_COOKIE['search'])){
        unset($_COOKIE["search"]);
    }
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Categories</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <a href="cat_add.php" class="btn btn-success mb-3">Add Category</a>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Category Table</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered text-center">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">id</th>
                      <th>Name</th>
                      <th>Description</th>
                      <th colspan="2">Action</th>
                    </tr>
                  </thead>
                  <tbody>
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
                      $recordsPerPage=5;
                      $offset=($pageno-1)*$recordsPerPage;
                      $stmt=$pdo->prepare("select * from categories limit $offset,$recordsPerPage");
                      $stmt->execute();
                      $categories=$stmt->fetchAll(PDO::FETCH_OBJ);
                      // total pages
                      $statement=$pdo->prepare('select count(*) from categories');
                      $statement->execute();
                      $result=$statement->fetch();
                      $totalcategories=$result[0];
                      $totalPages=ceil($totalcategories/$recordsPerPage);
                             
                         

                          
                    if($categories)
                    {
                        foreach($categories as $category): 
                    ?>
                      <tr >
                        <td><?=escape($category->id);?></td>
                        <td><?=escape($category->name);?></td>
                        <td><?=escape(substr($category->description,0,50));?>...</td>
                        <td>
                          <a href="cat_edit.php?id=<?=$category->id; ?>" class="btn btn-warning">Edit</a>
                        </td>
                        <td>
                          <a href="cat_delete.php?id=<?=$category->id; ?>" class="btn btn-danger" onclick="return confirm('are u sure want to delete');">Delete</a>
                        </td>
                      </tr>
                    <?php 
                        endforeach;
                      }
                    ?>
                  </tbody>
                    <!-- pagination -->
                    <nav aria-label="Page navigation example">
                      <ul class="pagination">
                        <li class="page-item <?php echo $pageno<=1 ? 'disabled' :'' ;?>">
                            <a class="page-link" href='<?=$pageno<=1? "#":"?pageno=".$pageno-1;  ?>'>Prev</a>
                        </li>
                        <?php  foreach(range(1,$totalPages) as $page):?>
                          <li class="page-item"><a class="page-link" href="?pageno=<?=$page;?>"><?=$page;?></a></li>
                        <?php endforeach; ?>
                        <li class="page-item <?php echo $pageno>=$totalPages ? 'disabled' :'' ;?>">
                            <a class="page-link" href='<?=$pageno>=$totalPages? "#":"?pageno=".$pageno+1;  ?>'>Next</a>
                        </li>
                      </ul>
                    </nav>
                </table>
              </div>
            </div> 
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
 
    <?php require "layout/footer.php"; ?>