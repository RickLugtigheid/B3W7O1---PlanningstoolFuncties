<?php 
    $page = "tool";
    require './assets/includes/header.inc.php';

    include './assets/includes/database.inc.php';
    $type = ($_GET["type"]);
    if($type == "new"){
    ?>
    <form action="assets/includes/postHandler.inc.php" method="post">
    name of the game: <input list="gameName" name="gameName">
    <datalist id="gameName">
    <?php
        $table = manipulateDatabase(connect("school"), "get", "games");
        foreach($table as $col){
    ?>
    <option value="<?=$col['name']?>">
    <?php }?>
  </datalist>
    
    <br>
    start time: <input type="datetime-local" name="startTime"><br>
    <input type="submit" name="planning-new">
    </form>
    <?php }
    elseif($type == "delete"){
        $table = $_GET["table"];
        $where = $_GET["where"];
        $is = $_GET["is"];
        echo $table.$where.$is;
        manipulateDatabase(connect("school"), "delete", array($table, $where, $is));
        //when table is deleted get back
        header("Location: index.php");
        exit();
    }
    elseif($type == "response"){
    ?>
    <p>resonse</p>
    <?php
    }
    else{
        //send back to the mainpage with a parameter for debugging
        header("Location: ./index.php?type=notValid");
        exit();
    }
    ?>
</body>
</html>