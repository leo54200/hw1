<?php

include "connection.php";

session_start();
if(!isset($_SESSION['id_utente'])){
    header("Location: login.php");
}

$messageId = mysqli_real_escape_string($conn, $_POST["messageId"]);

if (isset($_POST['correction']) && isset($_POST['past_message']) && isset($_POST['messageId']) ) {
    $correction = mysqli_real_escape_string($conn,$_POST["correction"]);
    $past_message = mysqli_real_escape_string($conn,$_POST["past_message"]);
    $id_chat = $_SESSION['id_chat'];

    $query = "UPDATE  messaggio SET correzione = '".$correction."' WHERE id = '".$messageId."'";
    if (mysqli_query($conn, $query)) {
        $response = " è stata registrata". $correction. "nel testo precedente" . $past_message;
    } else {
        $response = "Errore: " . mysqli_error($conn);
    }
    echo json_encode($response);
    exit;
}

if(isset($_POST['rating1']) || isset($_POST['rating2']) && isset($_POST['messageId']) ){
    $chiarezza = mysqli_real_escape_string($conn,$_POST["rating1"]);
    $correttezza = mysqli_real_escape_string($conn,$_POST["rating2"]);
    $id_chat = $_SESSION['id_chat'];

    $query = "UPDATE  messaggio SET chiarezza = '".$chiarezza."', correttezza = '".$correttezza."' WHERE id = '".$messageId."'";
    if (mysqli_query($conn, $query)) {
        $response = "è stata registrata". $chiarezza . $correttezza;
    } else {
        $response = "Errore: " . mysqli_error($conn);
    }
    echo json_encode($response);
}

mysqli_close($conn);
exit;

?>