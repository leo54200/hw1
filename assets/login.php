<?php
include "connection.php";
session_start();

function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  function setSessionAndCookie($key, $value) {
    $_SESSION[$key] = $value;
    $_COOKIE[$key] = $value;
    setcookie($key, $value, time() + 86400 * 365);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
      $username = validate(strtolower($_POST['username']));
      $password = validate($_POST['password']);
      if (empty($username) && empty($password)) echo "Devi compilare tutti i campi";
      else if(empty($username)) echo "username richiesto";
      else if(empty($password))echo "Password richiesta";
      else{
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $query = "SELECT * FROM utente WHERE username = '".$username."'";
        $res = mysqli_query($conn, $query) or die("Errore : " .mysqli_error($conn));
        if(mysqli_num_rows($res) > 0) {
          $row = mysqli_fetch_assoc($res);
          if (password_verify($_POST['password'], $row['password'])) {
            // Imposta le variabili di sessione e i cookie
            setSessionAndCookie("id_utente", $row['id']);
            setSessionAndCookie("username", $username);
            setSessionAndCookie("nome", $row['nome']);
            setSessionAndCookie("id_ruolo", $row['ruolo']);        
            switch($row['ruolo']) {
              case '1':
                echo "Studente";
                break;
              case '2':
                echo "Professore";
                break;
              case '3':
                echo "Admin";
                break;
              default:
              echo "Errore sconosciuto";  
              }          
            mysqli_free_result($res);
            mysqli_close($conn);
            exit;
          } 
        }
        echo "username o password errata";
      }
    }
  ?>