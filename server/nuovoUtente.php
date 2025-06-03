<?php
header('Content-type:application/json; charset=utf-8');
require("mysqli.php");

$conn = openConnection();

$nome = checkParams("Nome");
$cognome = checkParams("Cognome");
$mail = checkParams("Mail");
$pwd = checkParams("Pwd");
$residenza = checkParams("Residenza");
$indirizzo = checkParams("Indirizzo");
$tipoUtente = checkParams("TipoUtente");
if($tipoUtente == "0") {
	$classe = checkParams("Classe");
}
$nomeImmagine = checkParams("Immagine");


// Sanificazione dati per evitare SQL injection
$nome = $conn->real_escape_string(trim($nome));
$cognome = $conn->real_escape_string(trim($cognome));
$mail = $conn->real_escape_string(trim($mail));
$pwd = $conn->real_escape_string($pwd);
$residenza = $conn->real_escape_string($residenza);
$indirizzo = $conn->real_escape_string(trim($indirizzo));
$tipoUtente = $conn->real_escape_string($tipoUtente);
$classe = $conn->real_escape_string($classe);

$docente = ($tipoUtente == "1") ? 1 : 0;

$sql = "INSERT INTO studenti (cognome, nome, mail, pass, classe, residenza, indrizzo, immagine, docente) 
        VALUES ('$cognome', '$nome', '$mail', '$pwd', '$classe', '$residenza', '$indirizzo', '$nomeImmagine', $docente)";

try {
    $data = executeQuery($conn, $sql);
    if ($data) {

        // Recupera la matricola appena inserita
        $matricola = $conn->insert_id;

        $username = strtolower($cognome) . "-" . $matricola;

        $sqlUpdate = "UPDATE studenti SET user='$username' WHERE matricola=$matricola";
        $conn->query($sqlUpdate);

        http_response_code(200);
        echo(json_encode($data));
    } else {
        http_response_code(500);
        die(json_encode($data));
    }

} catch (Exception $e) {
    http_response_code(500);
    die(json_encode($data));
}

$conn->close();
?>