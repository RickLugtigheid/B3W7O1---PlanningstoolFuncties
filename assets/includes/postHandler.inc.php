<?php
if(isset($_POST['planning-new'])){
    $name = $_COOKIE["client"];
    $gameName = htmlspecialchars($_POST["gameName"]);
    $startTime = htmlspecialchars($_POST["startTime"]);

    ///error checking
    if(empty($name)||empty($gameName)||empty($startTime)){
        header("Location: ../../editor.php?type=response&post=error => &message=niet alle informatie is gegeven");
        exit();
    }

    //now we get the game with the name $gameName
    include './database.inc.php';
    $conn = connect("school");
    
    $gameInfo = manipulateDatabase($conn, "get", array("where", "games", "name", $gameName));

    foreach($gameInfo as $inf){
        $duration = $inf["play_minutes"] + $inf["explain_minutes"];
    }
    //insert the info we got into the database
    manipulateDatabase($conn, "insert", array("planning", array("nameGame", "nameExplainer", "duration", "startTime", "participants"), array($gameName, $name, $duration, date("Y-m-d H:i:s", strtotime($startTime)), "")));
    
    //we are done so we go back
    header("Location: ../../editor.php?type=new&post=succes");
    exit();
}elseif(isset($_POST['game-new'])){
    $name = htmlspecialchars($_POST["gameName"]);
    $description = htmlspecialchars($_POST["description"]);
    $imgUrl = htmlspecialchars($_POST["imgUrl"]);
    $imgName = htmlspecialchars($_POST["imgName"]);

    $url = htmlspecialchars($_POST["url"]);
    $youtube = htmlspecialchars($_POST["youtube"]);

    $maxPlayers = htmlspecialchars($_POST["maxP"]);
    $minPlayers = htmlspecialchars($_POST["minP"]);

    $explainTime = htmlspecialchars($_POST["explainTime"]);
    $playTime = htmlspecialchars($_POST["playTime"]);

    ///error checking
    if(empty($name)||empty($description)||empty($maxPlayers)||empty($minPlayers)||empty($explainTime)||empty($playTime)){
        header("Location: ../../editor.php?type=response&post=error => &message=niet alle informatie is gegeven");
        exit();
    }elseif($maxPlayers <= $minPlayers){
        header("Location: ../../editor.php?type=response&post=error => &message=max spelers mag niet lager zijn dan min spelers");
        exit();
    }

    include './database.inc.php';
    $conn = connect("school");
    file_put_contents("../afbeeldingen/".$imgName.".png", file_get_contents($imgUrl));

    //create an embed from yt link
    preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $youtube, $matches);
    $id = $matches[1];
    $embed = '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$id.'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';

    //insert the info we got into the database
    manipulateDatabase($conn, "insert", array("games", array("name", "description", "image","url", "youtube", "min_players", "max_players", "play_minutes", "explain_minutes"), array($name, $description, $imgName.".png", $url, $embed, $minPlayers, $maxPlayers, $playTime, $explainTime)));
    
    //we are done so we go back
    header("Location: ../../editor.php?type=response&post=succes");
    exit();
}elseif(isset($_POST['planning-edit'])){
    include './database.inc.php';
    $conn = connect("school");

    $newST = htmlspecialchars($_POST["startTime"]);
    $newGame = htmlspecialchars($_POST["gameName"]);
    $id = htmlspecialchars($_POST["id"]);

    manipulateDatabase($conn, "update", array("planning", array("nameGame", "startTime"), array($newGame, $newST), "id", $id));
    //manipulateDatabase($conn, "update", array("planning", "startTime", $newST, "id", $id));

    // header("Location: ../../editor.php?type=response&post=succes");
    // exit();
}elseif(isset($_POST['game-edit'])){
    include './database.inc.php';
    $conn = connect("school");

    $id = htmlspecialchars($_POST["id"]);
    var_dump($id);
    $name = htmlspecialchars($_POST["gameName"]);
    $description = htmlspecialchars($_POST["description"]);

    $url = htmlspecialchars($_POST["url"]);
    $youtube = htmlspecialchars($_POST["youtube"]);

    $maxPlayers = htmlspecialchars($_POST["maxP"]);
    $minPlayers = htmlspecialchars($_POST["minP"]);

    $explainTime = htmlspecialchars($_POST["explainTime"]);
    $playTime = htmlspecialchars($_POST["playTime"]);

    if(empty($name) || empty($description)){
        header("Location: ../../editor.php?type=response&post=error => &message=niet alle informatie is gegeven");
        exit();
    }elseif($maxPlayers <= $minPlayers){
        header("Location: ../../editor.php?type=response&post=error => &message=max spelers mag niet lager zijn dan min spelers");
        exit();
    }

    manipulateDatabase($conn, "update", array("games", array("name", "description", "url", "min_players", "max_players", "play_minutes", "explain_minutes"), array($name, $description, $url, $minPlayers, $maxPlayers, $playTime, $explainTime), "id", $id));

    header("Location: ../../editor.php?type=response&post=succes");
    exit();
}elseif(isset($_GET['delete'])){
    include './database.inc.php';

    $table =  htmlspecialchars($_GET["table"]);
    $where =  htmlspecialchars($_GET["where"]);
    $is =  htmlspecialchars($_GET["is"]);
    echo $table.$where.$is;
    manipulateDatabase(connect("school"), "delete", array($table, $where, $is));
    //when table is deleted get back
    header("Location: ../../index.php");
    exit();
}else{
    //send back if this page isn't run by a valid form or is run by typing it into the url
    header("Location: ../../editor.php?type=response&post=geen toegang");
    exit();
}
?>