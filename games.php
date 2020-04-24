<?php 
$page = "games";
require './assets/includes/header.inc.php';?>
<div class="container mb-3">
<h1 class="text-center mt-2 mb-3"><strong>Spellen</strong></h1>
<?php   require './assets/includes/database.inc.php';
        $conn = connect("school");
        $table = manipulateDatabase($conn, "get", "games");
        foreach($table as $column){?>
    <div class="row row-striped img-thumbnail mb-3 bg-light">
        <div class="col-2 text-right row">
        <a href="#game<?= $column["id"]?>" data-toggle="collapse" aria-expanded="false"><img src="./assets/afbeeldingen/<?=$column['image']?>" class="img-fluid" alt="<?=$column['image']?> not found"></a>
        <div id="game<?= $column["id"]?>" class="text-dark collapse"><div><?= $column["youtube"]?></div><div class="col-12 img-thumbnail"><?=$column["description"]?></div></div>
        </div>
            <div class="col-10">
                <a href="<?= $column["url"]?>" target="_blank"><h3 class="text-uppercase"><strong><?=$column['name']?></strong></h3></a>
                <b>aantal Spelers:</b><br>
                <b> Minimaal <?=$column["min_players"]?></b><br>
                <b> Maximaal <?=$column["max_players"]?></b><br><br>

                <b>Speel tijd: <?=$column["play_minutes"] + $column["explain_minutes"]?>min</b><br>
                <!-- Check if the client is loged in -->
                <?php if($_COOKIE["client"] != ""){?>
                    <ul class="list-inline">
                    <li class="list-inline-item" tabindex="0" data-toggle="tooltip" title="Edit"><a href="editor.php?type=editgame&tableId=<?=$column['id']?>"><i class="far fa-edit"></i></a></li>
                <li class="list-inline-item" tabindex="0" data-toggle="tooltip" title="Delete">
                    <form action="./assets/includes/postHandler.inc.php" method='get'>
                        <input type="hidden" id="table" name="table" value="games">
                        <input type="hidden" id="where" name="where" value="id">
                        <input type="hidden" id="is" name="is" value="<?=$column['id']?>">

                        <button type="submit" value="Submit" name="delete"><i class="fas fa-times-circle"></i></button>
                    </form>
                </li>
                <?php }?>
            </div>
    </div>
        <?php }?>