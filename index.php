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
                <!-- check for perms -->
                <?php if($_COOKIE["client"] == $column['nameExplainer']){?>
                <li class="list-inline-item" tabindex="0" data-toggle="tooltip" title="Edit"><a href="editor.php?type=edit&tableId=<?=$column['id']?>"><i class="far fa-edit"></i></a></li>
                <li class="list-inline-item" tabindex="0" data-toggle="tooltip" title="Delete">
                    <form action="./assets/includes/postHandler.inc.php" method='get'>
                        <input type="hidden" id="table" name="table" value="planning">
                        <input type="hidden" id="where" name="where" value="id">
                        <input type="hidden" id="is" name="is" value="<?=$column['id']?>">

                        <button type="submit" value="Submit" name="delete"><i class="fas fa-times-circle"></i></button>
                    </form>
                </li>
                <!-- join/leave system -->
                <?php }elseif(strpos($column["participants"], $_COOKIE["client"])!== false){?>
                    <li class="list-inline-item" tabindex="0" data-toggle="tooltip" title="leave"><a href="editor.php?type=leave&table=planning&id=<?=$column['id']?>"><i class="fas fa-user-minus"></i></i></a></li>
                <?php }else{?>
                    <li class="list-inline-item" tabindex="0" data-toggle="tooltip" title="join"><a href="editor.php?type=join&table=planning&id=<?=$column['id']?>"><i class="fas fa-user-plus"></i></i></a></li>
                <?php }?>
                <li class="list-inline-item" tabindex="0" data-toggle="tooltip" title="lijst spelers">
                <a href="#game<?= $column["id"]?>" data-toggle="collapse" aria-expanded="false"><i class="fas fa-users"></i></i></a>
                <div id="game<?= $column["id"]?>" class="text-dark collapse img-thumbnail">
                <b>[Lijst van deelnemers]</b> <br>
                <?=$column["participants"]?>
                </div>
                </li>
            </ul>
            <?php }?>
        </div>
    </div>
    <?php }?>
</div>
</body>
</html>