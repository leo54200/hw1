<?php
require_once "assets/signup.php";
?>
<!DOCTYPE html>
        <html lang="it">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>registrazione</title>
            <link rel="stylesheet" href="style_signup.css"/>
            <script src="script_signup.js" defer></script>
          </head>
        <body>

    <form id="sign_in_form" method="POST">
      <h1 class="th">Registra un utente</h1>
      <p>*campi obbligatori per la registrazione</p>
        <p id="idError"class="error"></p>
      <label class="tl">Nome*<br /></label>
      <input
        type="text"
        id="txtnome"
        name="nome"
        value=""
        placeholder="inserisci il nome "
      /><br />
      <label class="tl">Cognome*<br /></label>
      <input
        type="text"
        id="txtcognome"
        name="cognome"
        value=""
        placeholder="inserisci il cognome"
      /><br />
      <label class="tl">username*<br /></label>
      <input
        type="text"
        id="txtusername"
        name="username"
        value=""
        placeholder="inserisci l'username"
      /><br />
      <label class="tl">Password*<br /></label>
      <input
        type="password"
        id="txtpassword"
        name="password"
        value=""
        placeholder="inserisci la password"
      /> <br />
      <label class="tl">Tipo utente*</label>
      <select name="id_ruolo" id="id_ruolo">
  <option value="" selected disabled hidden>Seleziona un tipo utente</option>
  <option value="1">Studente</option>
  <option value="2">Tutor</option>
  <option value="3">Admin</option>
</select>
<br />
      <button  name="submit_signup" class="tb" type="submit" id="submit_signup">registra</button>
    </form>
</body>
</html>