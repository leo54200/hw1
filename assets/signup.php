<?php
session_start();
include "connection.php";

function validate($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
  $nome = validate(Ucwords(strtolower($_POST['nome'])));
  $cognome = validate(Ucwords(strtolower($_POST['cognome'])));
  $username = validate(strtolower($_POST['username']));
  $password = validate(($_POST['password']));
  $ruolo = $_POST['id_ruolo'];
if(empty($nome) || empty($cognome) || empty($username) ||empty($password)||empty($ruolo))
echo json_encode(["success" => false, "message" => "non hai compilato tutti i campi obbligatori"]);
elseif(strlen($password)<4) 
echo json_encode(["success" => false, "message" => "la password deve contenere almeno 4 caratteri"]);
else{
    $query = "SELECT * FROM utente WHERE username = '".$username."'";
      $res = mysqli_query($conn, $query) or die("Errore : " .mysqli_error($conn));
      if (mysqli_num_rows($res) > 0)
          echo json_encode(["success" => false, "message" =>"username già in uso"]);
          else{
            $nome = mysqli_real_escape_string($conn, $_POST['nome']);
            $cognome = mysqli_real_escape_string($conn, $_POST['cognome']);
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $password = password_hash($password, PASSWORD_BCRYPT);

            $query = "INSERT INTO utente (nome, cognome, username, password, ruolo) VALUES ('$nome' ,'$cognome', '$username', '$password', '$ruolo')";
            if (mysqli_query($conn, $query)) {
            echo json_encode(["success" => true, "message" => "{$nome} è stato registrato"]); 
            }
            else echo json_encode(["success" => false, "error" => "Errore durante la registrazione"]);
            mysqli_free_result($res);
            mysqli_close($conn);
            exit;
      }
    }
  }
?>
