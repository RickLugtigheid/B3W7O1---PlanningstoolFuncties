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
        <div class="col-2 text-right">
        <a href="#game<?= $column["id"]?>" data-toggle="collapse" aria-expanded="false"><img src="./assets/afbeeldingen/<?=$column['image']?>" class="img-fluid" alt="<?=$column['image']?> not found"></a>
        <p id="game<?= $column["id"]?>" class="text-dark collapse"><?= $column["youtube"]?></p>
        </div>
            <div class="col-10">
                <a href="<?= $column["url"]?>" target="_blank"><h3 class="text-uppercase"><strong><?=$column['name']?></strong></h3></a>
                <b>aantal Spelers:</b><br>
                <b> Minimaal <?=$column["min_players"]?></b><br>
                <b> Maximaal <?=$column["max_players"]?></b><br><br>

                <b>Speel tijd: <?=$column["play_minutes"] + $column["explain_minutes"]?>min</b><br>
            </div>
    </div>
        <?php }?>