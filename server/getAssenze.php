<?php
header('Content-type:application/json; charset=utf-8');
require("mysqli.php");
checkSession();

$conn = openConnection();
$matricola = $_SESSION["matricola"];

$sql = "SELECT id, matricola, data, giustificato
        FROM assenze 
        WHERE matricola = '$matricola'
        ORDER BY data DESC";

$data = executeQuery($conn, $sql);
$conn->close();

http_response_code(200);
echo json_encode($data);
?>