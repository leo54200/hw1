<?php
include "connection.php";
session_start();

// Assicurati che l'output sia solo JSON
header('Content-Type: application/json');

if (!isset($_SESSION['id_utente'])) {
    echo json_encode(['error' => 'Utente non autenticato']);
    exit;
}

if (isset($_POST['id_type']) || isset($_POST['id_subject'])) {
try {
    $subject = $_POST['id_subject'];
    $type = $_POST['id_type'];
    $id_utente = $_SESSION['id_utente'];
    $data = date('Y-m-d H:i:s');
    $query = "INSERT INTO chat (id_utente, data, id_materia, tipo) VALUES ('$id_utente', '$data', '$subject', '$type')";

    if (mysqli_query($conn, $query)) {
        $id_chat = mysqli_insert_id($conn);
        $_SESSION['id_chat'] = $id_chat;
        $response = ['id_chat' => $id_chat, 'message' => 'Chat session started'];
    } else {
        $response = ['error' => 'Failed to start chat session: ' . mysqli_error($conn)];
    }
} catch (Exception $e) {
    $response = ['error' => 'Errore durante l\'esecuzione della query: ' . $e->getMessage()];
}
}
else {
    $response = ['error' => 'Parametri mancanti'];}

mysqli_close($conn);
echo json_encode($response);
exit; // Assicurati di uscire dallo script dopo aver inviato la risposta JSON
?>
