 <!-- pagination -->
 <?php if($totalPages): ?>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
        <li class="page-item <?php echo $pageno<=1 ? 'disabled' :'' ;?>">
            <a class="page-link" href='<?=$pageno<=1? "#":"?pageno=".$pageno-1;  ?>'>Prev</a>
        </li>
        <?php  foreach(range(1,$totalPages) as $page):?>
            <li class="page-item <?=$page==$pageno?'active':'';?>"><a class="page-link " href="?pageno=<?=$page;?>"><?=$page;?></a></li>
        <?php endforeach; ?>
        <li class="page-item <?php echo $pageno>=$totalPages ? 'disabled' :'' ;?>">
            <a class="page-link" href='<?=$pageno>=$totalPages? "#":"?pageno=".$pageno+1;  ?>'>Next</a>
        </li>
        </ul>
    </nav>
<?php else: ?>
    <h2>Not Fount Results</h2>
<?php endif; ?>