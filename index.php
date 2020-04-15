<?php 
$page = "planning";
require './assets/includes/header.inc.php';?>
<div class="container">
    <?php
        require './assets/includes/database.inc.php';
        $conn = connect("school");
        //$table = manipulateDatabase($conn, "get", "planning");
        $table = manipulateDatabase($conn, "get", array("order", "planning", "startTime"));
        foreach($table as $column){
        if($currMonth != date("Y-M",strtotime($column['startTime']))){
            $currMonth = date("Y-M",strtotime($column['startTime']));
            ?>
        <div><?=date("Y-M",strtotime($column['startTime']))?></div>
        <?php }?>
    <div class="row row-striped">
        <div class="col-2 text-right">
            <h1 class="display-4"><span class="badge badge-secondary"><?=date("d",strtotime($column['startTime']))?></span></h1>
            <h2><?=date("D",strtotime($column['startTime']))?></h2>
        </div>
        <div class="col-10">
            <h3 class="text-uppercase"><strong><?=$column['nameGame']?></strong></h3>
            <ul class="list-inline">
                <li class="list-inline-item"><i class="fa fa-calendar-o" aria-hidden="true"></i>  <?=date("l",strtotime($column['startTime']))?></li>
                <li class="list-inline-item"><i class="fa fa-clock-o" aria-hidden="true"></i> <?=date("H:i",strtotime($column['startTime']))?></li>
            </ul>
            <p>Will be explained by: <?=$column['nameExplainer']?>.</p>
            <!-- edit/delete -->
            <?php if($_COOKIE["client"] != ""){?>
                <ul class="list-inline">
                <li class="list-inline-item" tabindex="0" data-toggle="tooltip" title="Edit"><a href=""><i class="far fa-edit"></i></a></li>
                <li class="list-inline-item" tabindex="0" data-toggle="tooltip" title="Delete"><a href="editor.php?type=delete&table=planning&where=id&is=<?=$column['id']?>"><i class="fas fa-times-circle"></i></a></li>
                <li class="list-inline-item" tabindex="0" data-toggle="tooltip" title="join"><a href=""><i class="fas fa-user-plus"></i></i></a></li>
            </ul>
            <?php }?>
        </div>
    </div>
    <?php }?>
</div>
</body>
</html>