<?php
require_once 'assets/sessionStart.php';
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
    <script src="script.js" defer></script>
    <script src="script_index.js" defer></script>
    <script src="script_login.js" defer></script>
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
          <a class="main_option" id="not_available">Studiamo insieme</a>
        </div>
        <div>
          <a class="sign_in">Accedi</a>
        </div>
        <div id="not_available_div" class="hidden"></div>
      </nav>
    </header>
    <div id="sign_in_div" class="hidden">
      <form id="sign_in_form" method="POST">
        <img id="close_form" src="images/x.png" />
        <h1 class="th">Accedi</h1>
        <p class="error" id="idError"></p>
        <label class="tl">username<br /></label>
        <input
          class="form_input"
          type="text"
          id="txtusername"
          name="username"
          value=""
          placeholder="inserisci l'username" /><br />
        <label class="tl">Password<br /></label>
        <input
          class="form_input"
          type="password"
          id="txtpassword"
          name="password"
          value=""
          placeholder="inserisci la password" /><br />
        <button type="submit" id="id_submit" class="tb">Accedi</button>
      </form>
    </div>

    <div id="blur">
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
      <footer>
        <div class="center">
          <h4>Contattaci</h4>
          <p>Email: ctis03300r@istruzione.it</p>
          <p>Pec: ctis03300r@pec.istruzione.it</p>
          <p>Telefono: 095-6136030</p>
          <p>
            Indirizzo: Via Trapani, 4 (ingresso da via Monetario Floristella)
          </p>
          <h4>Seguici suoi social</h4>
          <a href="#" class="fa fa-facebook"></a>
          <a href="#" class="fa fa-twitter"></a>
          <a href="#" class="fa fa-instagram"></a>
          <a href="#" class="fa fa-youtube"></a>
        </div>
      </footer>
    </div>
  </body>
</html>
