<?php
header('Content-type:application/json; charset=utf-8');
require("mysqli.php");
$conn = openConnection();
$user = checkParams("user");
$pass = checkParams("pass");
//evita sqlInjection
$user = $conn->real_escape_string($user);
$pass = $conn->real_escape_string($pass);
$sql = "SELECT * 
FROM studenti
WHERE user='$user'";
$data = executeQuery($conn, $sql);
if (count($data) == 0) {
    http_response_code(401);
    die("Username errato");
} else {
    $dbPass = $data[0]["pass"];
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
        $_SESSION["matricola"] = $data[0]["matricola"];
        $_SESSION["nome"] = $data[0]["nome"];
        $_SESSION["cognome"] = $data[0]["cognome"];
        $_SESSION["classe"] = $data[0]["classe"];
        $_SESSION["immagine"] = $data[0]["immagine"];
        setcookie(session_name(), session_id(), $_SESSION["scadenza"], "/");
        http_response_code(200);
        //nel caso di errore non serve serializzare la risposta perchè il client parsifica solo nel caso di 
        //status 200
        echo (json_encode("OK"));
    }
}

$conn->close();
?>