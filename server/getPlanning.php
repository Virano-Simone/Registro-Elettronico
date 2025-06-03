<?php
header('Content-type:application/json; charset=utf-8');
require("mysqli.php");
checkSession();

$conn = openConnection();
$matricola = $_SESSION["matricola"];
$classe = $_SESSION["classe"];

$sql = "SELECT a.id, a.classe, a.data, a.materia as materia_id, 
               m.materia as materia_nome, a.argomento
        FROM argomenti a
        INNER JOIN materie m ON a.materia = m.id
        WHERE a.classe = '$classe'
        ORDER BY a.data DESC";

$data = executeQuery($conn, $sql);
$conn->close();

http_response_code(200);
echo json_encode($data);
?>