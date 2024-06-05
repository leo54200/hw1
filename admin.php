<?php 
  session_start();
  if(!isset($_SESSION['username']) || $_SESSION['id_ruolo'] != 3){
   header("location: index.php");
  }
?>