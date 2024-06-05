<?php
session_start();
if(!isset($_SESSION['id_ruolo'])){
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Gruppo di studio virtuale</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" type="image/x-icon" href="images/logo.png" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="script.js" defer></script>
    <script src="script_index.js" defer></script>
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
          <div class="dropdown_menu_active border_top">Home</div>
        </a>
        <a href="classroom.php">
          <div>Studiamo insieme</div>
        </a>
      </div>
      <nav id="navbar">
        <div>
          <a href="index.php"
            ><img class="middle" id="logo" src="Images/logo.png" alt=""
          /></a>
          <a class="main_option active" href="index.php">Home</a>
          <a class="main_option" href="classroom.php">Studiamo insieme</a>
        </div>
        <div class="dropdown">
        <button class="dropbtn" id="welcome">Bentornato <?php echo $_SESSION['nome'];?></button>
        <div class="dropdown-content">
            <a href="account.php">Profilo</a>
            <a href="logout.php">Esci</a>
        </div>
        </div>
      </nav>
    </header>

    <div class="nav_height"></div>
    <div class="container_img">
    <img src="images/classroom.jpeg" alt="" width="100%" />
    <div class="above_container_center chalk">
        <h2>
        Siamo entusiasti di accoglierti <br />
        nella nostra comunita' educativa
        </h2>
    </div>
    </div>

    <section>
    <div class="flex_center_container">
        <div class="text">
        <h2>
            Siamo qui per rendere il processo di apprendimento divertente
        </h2>
        <p>
            Esplorate un ambiente educativo unico dove la tecnologia e
            l'intelligenza artificiale si incontrano per creare un'esperienza
            di apprendimento coinvolgente e stimolante.
        </p>
        <p>
            In questa classe virtuale, gli studenti vengono trasportati in un
            mondo interattivo dove l'apprendimento diventa coinvolgente,
            stimolante e personalizzato. Ogni aspetto del nostro ambiente
            educativo è stato progettato per ispirare la curiosità, promuovere
            la creatività e coltivare il pensiero critico.
        </p>
        </div>
        <img id="ai_img" src="images/ai.jpg" alt="" />
    </div>
    </section>

    <section>
    <div class="center"><h4>A quale classe vorresti partecipare?</h4></div>
    <div class="classroom">
        <h4 id="classroom_title">Matematica</h4>
        <button id="left" class="classroom_button">
        <span class="material-symbols-outlined"> arrow_back </span>
        </button>
        <button id="right" class="classroom_button">
        <span class="material-symbols-outlined"> arrow_forward </span>
        </button>
        <img id="mathematics_image" src="images/Mathematics.jpg" alt="" />
        <img id="physics_image" class="hidden" src="images/physics.jpg" />
        <img
        id="technology_image"
        width="100%"
        height="100%"
        class="hidden"
        src="images/technology.jpg" />
    </div>
    </section>

    <section>
    <div class="colored_background">
        <h4 class="center">...</h4>
        <div id="flex_img_container">
        <img class="graph_img" src="images/graph.png" alt="" />
        <img class="graph_img" src="images/graph.png" alt="" />
        </div>
    </div>
    </section>

    <div class="line"></div>
    <footer style="background-color: #333; color: white; padding: 20px 0;">
    <div style="max-width: 1200px; margin: 0 auto; display: flex; flex-wrap: wrap; justify-content: space-between;">
        <div style="flex: 1 1 200px; padding: 10px;">
            <h4>Scuola Superiore XYZ</h4>
            <p>Via delle Scuole, 123<br>
            00100 Città, Italia<br>
            Tel: +39 0123 456 789<br>
            Email: info@scuolaxyz.it</p>
        </div>
        <div style="flex: 1 1 200px; padding: 10px;">
            <h4>Link Utili</h4>
            <ul style="list-style: none; padding: 0;">
                <li><a href="/about.html" style="color: white; text-decoration: none;">Chi Siamo</a></li>
                <li><a href="/courses.html" style="color: white; text-decoration: none;">Corsi</a></li>
                <li><a href="/events.html" style="color: white; text-decoration: none;">Eventi</a></li>
                <li><a href="/contact.html" style="color: white; text-decoration: none;">Contatti</a></li>
            </ul>
        </div>
        <div style="flex: 1 1 200px; padding: 10px;">
            <h4>Seguici</h4>
            <a href="https://www.facebook.com" target="_blank" style="color: white; text-decoration: none; margin-right: 10px;">
                <i class="fab fa-facebook-f"></i> Facebook
            </a><br>
            <a href="https://www.twitter.com" target="_blank" style="color: white; text-decoration: none; margin-right: 10px;">
                <i class="fab fa-twitter"></i> Twitter
            </a><br>
            <a href="https://www.instagram.com" target="_blank" style="color: white; text-decoration: none; margin-right: 10px;">
                <i class="fab fa-instagram"></i> Instagram
            </a><br>
        </div>
    </div>
    <div style="text-align: center; padding: 10px; border-top: 1px solid #555; margin-top: 20px;">
        <p>&copy; 2024 Scuola Superiore XYZ. Tutti i diritti riservati.</p>
    </div>
    </footer>
    </body>
</html>