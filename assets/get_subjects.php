<?php
session_start();
include "connection.php";

header('Content-Type: application/json');

if (!isset($_SESSION['id_utente'])) {
    echo json_encode(['error' => 'Utente non autenticato']);
    exit;
}

$sql = "SELECT id, nome FROM materia";
$result = $conn->query($sql);

$subjects = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $subjects[] = $row;
    }
    echo json_encode(['subjects' => $subjects]);
} else {
    echo json_encode(['error' => 'Nessun risultato trovato']);
}
$conn->close();
?>
