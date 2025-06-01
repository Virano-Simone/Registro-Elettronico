<?php
//Servizio per recuperare i voti dello studente loggato
header('Content-type:application/json; charset=utf-8');
require("mysqli.php");
checkSession();

$conn = openConnection();
$matricola = $_SESSION["matricola"]; // Assumendo che la matricola sia salvata in sessione

// Query per recuperare i voti dello studente con il nome della materia
// Aggiungiamo anche l'ID della materia per facilitare i filtri
$sql = "SELECT v.data, v.materia as materia_id, m.materia as materia_nome, v.voto, '' as note
        FROM voti v
        INNER JOIN materie m ON v.materia = m.id
        WHERE v.matricola = '$matricola'
        ORDER BY v.data DESC";

$data = executeQuery($conn, $sql);
$conn->close();

http_response_code(200);
echo json_encode($data);
?>