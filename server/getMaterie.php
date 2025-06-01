<?php
//Servizio per recuperare l'elenco delle materie dello studente
header('Content-type:application/json; charset=utf-8');
require("mysqli.php");
checkSession();

$conn = openConnection();
$matricola = $_SESSION["matricola"];

// Query per recuperare solo le materie per cui lo studente ha voti
$sql = "SELECT DISTINCT m.id, m.materia
        FROM materie m
        INNER JOIN voti v ON m.id = v.materia
        WHERE v.matricola = '$matricola'
        ORDER BY m.materia";

$data = executeQuery($conn, $sql);
$conn->close();

http_response_code(200);
echo json_encode($data);
?>