<?php
if(isset($_POST['planning-new'])){
    $name = $_COOKIE["client"];
    $gameName = htmlspecialchars($_POST["gameName"]);
    $startTime = htmlspecialchars($_POST["startTime"]);

    ///error checking
    if(empty($name)||empty($gameName)||empty($startTime)){
        header("Location:  ../../editor.php?type=new&post=emptyfields&pet=$name&gameName=$gameName&country=$startTime");
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
    manipulateDatabase($conn, "insert", array("planning", array("nameGame", "nameExplainer", "duration", "startTime"), array($gameName, $name, $duration, date("Y-m-d H:i:s", strtotime($startTime)))));
    
    //we are done so we go back
    header("Location: ../../editor.php?type=new&post=done");
    exit();
}else{
    //send back if this page isn't run by a valid form or is run by typing it into the url
    header("Location: ../../editor.php?type=response&post=incorrect");
    exit();
}
?>