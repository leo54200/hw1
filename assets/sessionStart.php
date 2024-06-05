<?php
  session_start();
if(isset($_SESSION['username'])){
  if($_SESSION['id_ruolo'] == 1)
    header("Location: home.php");
  else if($_SESSION['id_ruolo'] == 2)
    header("Location: tutor.php");
  else if($_SESSION['id_ruolo'] == 3)
    header("Location: admin.php");
}

?>