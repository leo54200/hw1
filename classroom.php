<?php 
  session_start();
  if(!isset($_SESSION['username']) || $_SESSION['id_ruolo'] != 1){
   header("location: Webprogramming/index.php");
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="style_classroom.css" />
    <link rel="icon" type="image/x-icon" href="images/logo.png" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gruppo di studio virtuale</title>
    <script src="script.js" defer></script>
    <script src="script_classroom.js" defer></script>
  </head>
  <body>
    <header>
      <div id="menu" class="nav_height">
        <div></div>
        <div></div>
        <div></div>
      </div>
      <div id="dropdown_menu" class="hidden">
        <a href="index.php">
          <div class="border_top">Home</div>
        </a>
        <a href="classroom.php">
          <div class="dropdown_menu_active">Studiamo insieme</div>
        </a>
      </div>
      <nav id="navbar">
        <div>
          <a href="index.php"
            ><img class="middle" id="logo" src="Images/logo.png" alt=""
          /></a>
          <a class="main_option" href="index.php">Home</a>
          <a class="active main_option" href="classroom.php"
            >Studiamo insieme</a
          >
        </div>
        <div class="dropdown">
        <button class="dropbtn" id="welcome">Bentornato <?php echo $_SESSION['nome'];?></button>
        <div class="dropdown-content">
            <a href="account.php">Profilo</a>
            <a href="logout.php">esci</a>
        </div>
        </div>
      </nav>
    </header>
    <div class="nav_height"></div>
    <h2 class="center">Benvenuto nella nostra classe</h2>

    <div id="flexcontainer_guys">
      <div id="chat">
        <div id="bot_answer" class="hidden"></div>
        <img id="guy1" class="guy1_3" src="images/guy1.PNG" alt="" />
        <img
          id="speaking_guy1"
          class="guy1_3 hidden"
          src="images/speaking_guy1.PNG" />
        <img id="guy2" class="guy" src="images/guy2.PNG" alt="" />
        <img
          id="speaking_guy2"
          class="guy hidden"
          src="images/speaking_guy2.PNG" />
        <img id="guy3" class="guy1_3" src="images/guy3.PNG" alt="" />
        <img
          id="speaking_guy3"
          class="guy1_3 hidden"
          src="images/speaking_guy3.PNG" />
        <img id="table" src="images/table.PNG" alt="" />
        <div id="bar">
          <input id="input_message" type="text" placeholder="Scrivi qui..." />
          <button id="submit_message" class="material-symbols-outlined middle">
            send
          </button>
        </div>
      </div>

      <div id="history_box">
        <p class="history_box_title">Cronologia della conversazione</p>
        <div id="container"></div>
      </div>
    </div>

    <div class="center">
      <button id="next_button">Premi per avanzare nella conversazione</button>
    </div>
  </body>
</html>
