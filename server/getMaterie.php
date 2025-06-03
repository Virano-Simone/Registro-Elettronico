<?php
header('Content-type:application/json; charset=utf-8');
require("mysqli.php");
checkSession();

$conn = openConnection();
$matricola = $_SESSION["matricola"];

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