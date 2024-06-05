<?php
  session_start();
  if(!isset($_SESSION['id_utente'])){
    header("Location: login.php");
  }
?>


<!DOCTYPE html>
<html lang="it">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pagina insegnante</title>
    <link rel="stylesheet" href="style_chatbot_teacher.css" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Varela+Round&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" />
    <script src="script_chatbot_teacher.js" defer></script>
  </head>
  <body>

    <header class="site-header">
      <div class="site-identity">
        <img id="logo" src="images/Logo.png" alt="Logo" />
      </div>
      <nav class="site-navigation">
        <ul id="nav">
           <li><a href="logout.php">Logout</a></li> 
        </ul>
        <!-- Mobile dropdown menu -->
        <div id="menu">
          <span id="menu-button" class="material-symbols-rounded">menu</span>
          <li><a href="logout.php">Logout</a></li> 
        </div>
      </nav>
    </header>

    <main>
      <!-- New h3 element -->
      <h3 class="center hidden" id="selected_items">Argomento della chat: </h3>

      <div id="choice" class="center">
        <br />
        <h3>Scegli la materia:</h3>
        <div id="container1">
          <div class="flex_container" id="subjects_container">
          </div>
        </div>

        
        <div id="container2" class="hidden">
          <br />
          <h3>Cosa vuoi fare?</h3>
          <div class="flex_container"> 
            <div id="item01" class="flex_item type" data-id="1" ><h4 >Spiegazione</h4></div>
            <div id="item02" class="flex_item type" data-id="2" ><h4 >Esercizio</h4></div>
          </div>
        </div>
        <form id="types" method="POST">
          <input class="hidden" id="id_subject" name="id_subject" required>
          <input class="hidden" id="id_type" name="id_type" required>
          <button id="enter" type="submit" class="hidden"><h3>Conferma</h3></button>
        </form>
      </div>

      <!-- Chat box -->
      <div class="chat-box"></div>      

      <!-- Input box -->
      <div class="typing-box">
        <div class="typing-content">
          <div class="typing-textarea">
            <textarea id="chat-input" spellcheck="false" disabled="true" placeholder="Scrivi un messaggio qui..." required></textarea>
            <span id="send-button" class="material-symbols-rounded">send</span>
          </div>
          <div class="typing-controls">
          <span id="refresh-button" class="material-symbols-rounded">refresh</span>
          </div>
        </div>
      </div>
      
      <!-- Output box (user) -->
      <template id="outgoing-template">
          <div class="chat-content">
            <div class="chat-details">
              <img src="images/teacher.png" alt="user-img">
              <p></p>
            </div>
          </div>
      </template>

      <!-- Output box (chatbot) -->
      <template id="typing-template">
        <div class="chat-content">
          <div class="chat-details">
            <img src="images/chatbot.png" alt="chatbot-img">
            <div class="typing-animation">
              <div class="typing-dot" style="--delay: 0.2s"></div>
              <div class="typing-dot" style="--delay: 0.3s"></div>
              <div class="typing-dot" style="--delay: 0.4s"></div>
            </div>
          </div>
          <div class="chat-buttons">
            <span id="copyBtn" class="material-symbols-rounded">content_copy</span>
            <span id="editBtn" class="material-symbols-outlined">edit</span>
            <span id="rateBtn" class="material-symbols-outlined">grade</span>
          </div>
        </div>
      </template>

        <!-- Edit box -->
        <div id="editBox" class="hidden">
            <form id="correction_form"  method="POST">
                <textarea name="correction" id="correction"></textarea>
                <textarea class="hidden" name="past_message" id="past_message"></textarea>
                <button>Annulla</button>
                <button id="submit_correction" type="submit">Invia</button>
            </form>
        </div>

        <!-- Rating box -->
        <div id="ratingBox" class="hidden">
            <header>Chiarezza</header>
            <div class="stars1">
                <i id="star1" class="fa-solid fa-star"></i>
                <i id="star2" class="fa-solid fa-star"></i>
                <i id="star3" class="fa-solid fa-star"></i>
                <i id="star4" class="fa-solid fa-star"></i>
                <i id="star5" class="fa-solid fa-star"></i>
            </div>
            <header>Correttezza</header>
            <div class="stars2">
                <i id="star6" class="fa-solid fa-star"></i>
                <i id="star7" class="fa-solid fa-star"></i>
                <i id="star8" class="fa-solid fa-star"></i>
                <i id="star9" class="fa-solid fa-star"></i>
                <i id="star10" class="fa-solid fa-star"></i>
            </div>
            <form id="rating_form" method="post">
                <input class="hidden" type="text" name="rating1" id="rating1">
                <input class="hidden" type="text" name="rating2" id="rating2">
                <input class="hidden" name="current_message" id="current_message"></input>
            <button type="submit" id="sumbit_rating">OK</button>
            </form>
        </div>

    </main>
  </body>
</html>
