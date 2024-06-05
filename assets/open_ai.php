<?php

include "connection.php";

session_start();
if(!isset($_SESSION['id_utente'])){
    header("Location: login.php");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Method Not Allowed"]);
    exit;
}

$apiKey = "API_KEY";
$apiUrl = "https://api.openai.com/v1/chat/completions";

// Ottenere il corpo della richiesta dal client
$requestBody = file_get_contents("php://input");
$requestData = json_decode($requestBody, true);

// Salvare il messaggio dell'utente
$userText = mysqli_real_escape_string($conn, end($requestData['messages'])['content']);
$role = 'user';
$mittente = ($role == 'user' ? 1 : 2);
$data = date('Y-m-d H:i:s');
$id_chat = $_SESSION['id_chat'];

$query = "INSERT INTO messaggio ( id_chat, testo, data, mittente) VALUES ('".$id_chat."', '".$userText."', '".$data."', '".$mittente."')";
if (mysqli_query($conn, $query) === false) {
    error_log("Errore nell'inserimento del messaggio dell'utente nel database: " . mysqli_error($conn));
    mysqli_close($conn);
    header("Content-Type: application/json");
    echo json_encode(["error" => "Errore durante l'inserimento del messaggio nel database"]);
    exit;
}

// Inizializzare una sessione curl
$ch = curl_init($apiUrl);

// Impostare le opzioni di curl
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer " . $apiKey,
]);
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);

// Eseguire la richiesta e ottenere la risposta
$response = curl_exec($ch);

// Controllo degli errori
if ($response === false) {
    $error = curl_error($ch);
    curl_close($ch);
    mysqli_close($conn);

    // Log dell'errore
    error_log("Errore curl: " . $error);
    // Restituire un messaggio di errore al client
    header("Content-Type: application/json");
    echo json_encode(["error" => "Errore nella comunicazione con il server OpenAI: " . $error]);
    exit;
}

// Controllo del codice di stato HTTP
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode >= 400) {
    // Log dell'errore
    error_log("Errore HTTP: " . $httpCode . " - " . $response);
    // Restituire un messaggio di errore al client
    header("Content-Type: application/json");
    echo json_encode(["error" => "Errore nella risposta del server OpenAI: " . $response]);
    exit;
}

// Decodificare la risposta dell'API di OpenAI
$responseData = json_decode($response, true);
$messageContent = $responseData['choices'][0]['message']['content'];

// Inserire il messaggio nel database
$testo = mysqli_real_escape_string($conn, $messageContent);
$role = $responseData['choices'][0]['message']['role'];
$mittente = ($role == 'user' ? 1 : 2);
$data = date('Y-m-d H:i:s');
$id_chat = $_SESSION['id_chat'];

$query = "INSERT INTO messaggio ( id_chat, testo, data, mittente) VALUES ('".$id_chat."', '".$testo."', '".$data."', '".$mittente."')";
if (mysqli_query($conn, $query)) {
    $messageId = mysqli_insert_id($conn);
} else {
    error_log("Errore nell'inserimento del messaggio nel database: " . mysqli_error($conn));
    mysqli_close($conn);
    header("Content-Type: application/json");
    echo json_encode(["error" => "Errore durante l'inserimento del messaggio nel database"]);
    exit;
}

// Restituire la risposta e l'ID del messaggio al client
header("Content-Type: application/json");
echo json_encode(['messageId' => $messageId, 'messageContent' => $messageContent]);

mysqli_close($conn);
exit;

?>