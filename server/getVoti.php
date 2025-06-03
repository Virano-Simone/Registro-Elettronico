<?php
header('Content-type:application/json; charset=utf-8');
require("mysqli.php");
checkSession();

$conn = openConnection();
$matricola = $_SESSION["matricola"]; 

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