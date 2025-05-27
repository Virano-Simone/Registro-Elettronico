<?php
header('Content-type:application/json; charset=utf-8');
require("mysqli.php");
$conn = openConnection();
$user = checkParams("user");
$pass = checkParams("pass");
//evita sqlInjection
$user = $conn->real_escape_string($user);
$pass = $conn->real_escape_string($pass);
//facendo questa query, user è case unsensitive ma la password deve essere case sensitive
$sql = "";
$data = executeQuery($conn, $sql);
if (count($data) == 0) {
    http_response_code(401);
    die("Username errato");
} else {
    $dbPass = $data[0]["Pwd"];
    //echo("$pass");
    if ($dbPass != $pass) {
        http_response_code(401);
        die("Password errata");
    } else {
        //crea la sessione
        session_start();
        //dentro la sessione creiamo una chiave scadenza
        //time mi restituisce data e ora correnti in secondi
        $_SESSION["scadenza"] = time() + TIMEOUT;
        //questa chiave serve a identificare il correntista che ha eseguito il login 
        $_SESSION["cCorrentista"] = $data[0]["cCorrentista"];
        setcookie(session_name(), session_id(), $_SESSION["scadenza"], "/");
        http_response_code(200);
        //nel caso di errore non serve serializzare la risposta perchè il client parsifica solo nel caso di 
        //status 200
        echo (json_encode("OK"));
    }
}

$conn->close();
?>