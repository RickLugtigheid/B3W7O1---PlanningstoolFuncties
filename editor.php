<?php 
    $page = "tool";
    require './assets/includes/header.inc.php';

    include './assets/includes/database.inc.php';
    $type = ($_GET["type"]);
    if($type == "new"){
    ?>
    <form action="assets/includes/postHandler.inc.php" method="post">
    <div class="form-group w-25 container img-thumbnail mt-5">
    <label>name of the game: </label><input class="form-control" list="gameName" name="gameName">
        <datalist id="gameName">
        <?php
            $table = manipulateDatabase(connect("school"), "get", "games");
            foreach($table as $col){
        ?>
        <option value="<?=$col['name']?>">
        <?php }?>
    </datalist>
        
        <br>
        <label>start time: </label><input class="form-control" type="datetime-local" name="startTime"><br>
        <input type="submit" name="planning-new">
    </div>
    </form>
    <?php }
    else if($type == "newgame"){
        ?>
        <form action="assets/includes/postHandler.inc.php" method="post">
        <div class="form-group w-25 container img-thumbnail mt-5">
            name of the game: <input class="form-control" name="gameName"> 
            <br>
            <textarea class="form-control" rows="4" cols="50" name="description">description...</textarea> <br><br>
            give an image url: <input class="form-control" name="imgUrl" id="imgUrl"><br>
            what is the name of your image?: <input class="form-control" name="imgName" id="imgName"><br><br>
            game webpage link: <input class="form-control" name="url"> <br>
            game video iframe: <input class="form-control" name="youtube"> <br>
            <br>
            min players: <input class="form-control" name="maxP"> <br>
            max players: <input class="form-control" name="minP"> <br>
            <br>
            explain in minutes: <input class="form-control" name="explainTime"> <br>
            playtime in minutes: <input class="form-control" name="playTime"> <br>
            <input type="submit" name="game-new">
        </div>
        <?php }
    elseif($type == "join" || $type == "leave"){
        $id = $_GET["id"];
        $table = manipulateDatabase(connect("school"), "get", array("where", "planning", "id", $id));//get the table
        
        foreach($table as $col){
            if($type == "join"){
                $parti = $col['participants']." ".$_COOKIE['client']."<br> ";
            }else{
                $parti = str_replace($_COOKIE['client']."<br>", "", $col['participants']);
            }
        }
        echo $parti;
        manipulateDatabase(connect("school"), "update", array("planning", "participants", $parti, "id", $id));
        //when table is deleted get back
        header("Location: index.php");
        exit();
    }elseif($type == "edit"){
        $tableEdit = manipulateDatabase(connect("school"), "get", array("where", "planning", "id", htmlspecialchars($_GET["tableId"])));
        foreach($tableEdit as $col){
        ?>
        <form action="assets/includes/postHandler.inc.php" method="post">
        name of the game: <input list="gameName" name="gameName" value="<?=$col['nameGame']?>">
        <datalist id="gameName">
        <?php
            $table = manipulateDatabase(connect("school"), "get", "games");
            foreach($table as $colGames){
        ?>
        <option value="<?=$colGames['name']?>">
        <?php }?>
    </datalist>
    
    <br><!-- value="<= date('Y-m-d\TH:i:sP', $tableEdit['startTime']);?>" -->
    start time: <input type="datetime-local" name="startTime" > <br>
    <input type="hidden" id="id" name="id" value="<?=$col['id']?>">
    <input type="submit" name="planning-edit">
    </form>
    <?php }
    
}elseif($type == "editgame"){
        $tableEdit = manipulateDatabase(connect("school"), "get", array("where", "games", "id", htmlspecialchars($_GET["tableId"])));
        foreach($tableEdit as $col)
        ?>
        <form action="assets/includes/postHandler.inc.php" method="post">
        <input type="hidden" id="id" name="id" value="<?=$col['id']?>">
        name of the game: <input name="gameName" value="<?=$col['name']?>"> 
        <br>
        <textarea rows="4" cols="50" name="description"><?=$col['description']?> </textarea><br><br>
        game webpage link: <input name="url" value="<?=$col['url']?>"> <br>
        <br>
        min players: <input name="maxP" value="<?=$col['min_players']?>"> <br>
        max players: <input name="minP" value="<?=$col['max_players']?>"> <br>
        <br>
        explain in minutes: <input name="explainTime" value="<?=$col['explain_minutes']?>"> <br>
        playtime in minutes: <input name="playTime" value="<?=$col['play_minutes']?>"> <br>
        <input type="submit" name="game-edit">
    <?php }
    elseif($type == "response"){
    $postInfo = htmlspecialchars($_GET['post']);
    ?>
    <div class="text-center mt-5 pt-4 img-thumbnail">
        <h4 class="mb-4 <?php if($postInfo == "succes"){echo "text-success";}else{echo "text-danger";} ?>">Request: <?= $postInfo?> <?= htmlspecialchars($_GET['message'])?></h4>
    </div>
    <?php
    }else{
        //send back to the mainpage with a parameter for debugging
        header("Location: ./index.php?type=notValid");
        exit();
    }
    ?>
</body>
</html>