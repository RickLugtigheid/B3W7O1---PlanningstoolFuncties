<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>planning tool (Rick Lugtigheid)</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/5eb0758b3a.js" crossorigin="anonymous"></script>
</head>
<body>
<!-- Nav bar -->
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <!-- Brand -->

  <!-- Links -->
  <ul class="navbar-nav">
  <li class="nav-item h-0">
      <a href="#user" data-toggle="collapse" aria-expanded="false"><i class="fas fa-user-circle nav-link active pb-0"></i></a>
      <div id="user" class="text-dark collapse">

      <?php if($_POST["name"] != ""){
          $name = htmlspecialchars($_POST["name"]);
          setcookie("client", $name);
          //Refresh to update the page
          header("Refresh:0");
        }else if(isset($_POST["cookie-logout"])){
          setcookie("client", "", time() - 3600);
          //Refresh to update the page
          header("Refresh:0");
        }
        if($_COOKIE["client"] == ""){
      ?>

      <form action="index.php" method='post'>
        <input value="" name="name"></input>
        <button type="submit" name="cookie-user"></button>
	    </form>	
      <?php }else{?>
          <b class="text-white">welkom <?= $_COOKIE["client"]?></b>
          <form action="index.php" method='post'><button type="submit" name="cookie-logout">Logout</button></form>	
      <?php }?>
    </div>
  </li>

    <li class="nav-item">
      <a class="nav-link <?php if($page == "planning"){echo "active";}?>" href="index.php">planning</a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php if($page == "games"){echo "active";}?>" href="games.php">games</a>
    </li>

    <!-- Dropdown -->
    <?php if($_COOKIE["client"] != ""){?>
    <li class="nav-item dropdown <?php if($page == "tool"){echo "active";}?>">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        Tools
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="editor.php?type=new">Add to planning</a>
        <a class="dropdown-item" href="editor.php?type=newgame">Add game</a>
      </div>
    </li>
    <?php }?>
  </ul>
</nav>
