<?php
$conn = null;
//TIMEOUT deve essere una variabile espressa in secondi
define("TIMEOUT", 1200);
function openConnection()
{
    define("DB_NAME", "registroelettronico");
    //in caso in cui mysql sia su un'altra macchina dobbiamo immetere l'indirizzo IP della
    //macchina su cui è installato mysql
    define("DB_HOST", "localhost");
    //utente creato automaticamente da db mysql quando creiamo un db
    //serve per collegarsi al db    
    define("DB_USER", "root");
    define("DB_PASS", "");

    //serve per abilitare il try catch sulle righe successive
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    try {
        //mysqli è una libreria che permette di connettersi a mysql
        //questo istanzia una nuova connessione al db people e la ritorniamo
        global $conn;
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        //il charset è il set di caratteri che il server deve utilizzare per comunicare con il db
        $conn->set_charset("utf8mb4");
        return $conn;
    } catch (mysqli_sql_exception $err) {
        //se non riesce a connettersi ritorna un errore 503: "errore connessione db"
        http_response_code(503);
        //die stampa il messaggio e termina lo script
        //per accedere ai metodi di un oggetto si usa ->
        die("<b>Errore connessione db </b>" . $err->getMessage());
    }
}
function executeQuery($conn, $sql): mixed
{
    try {
        //query metodo dell'oggetto conn che esegue la query. nelle chiamate get 
        // i dati sono restituiti sotto forma di recordset php
        $result = $conn->query($sql);
        //in tutte le chiamatate diverse dalla GET php restituisce true se è andato
        //tutto bene, false in caso di errore
        if (!is_bool($result)) {
            //fetch_all converte da recordSet php a vettore enumerativo di json 
            //solo nel caso della chiamate GET
            $data = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $data = $result;
        }
        return $data;
    } catch (mysqli_sql_exception $err) {
        //chiudo la connessione e termino lo script
        $conn->close();
        http_response_code(500);
        die("<b>Errore query</b>" . $err->getMessage());
    }
}

function checkParams($param): mixed
{
    //per accedere a una variabile globale devo scrivere "global" seguito dal nome della variabile
    global $conn;
    //php consegna tutti i parametri dentro $_REQUEST
    if (isset($_REQUEST[$param]))
        //ritorna il valore del parametro(nel primo caso il contenuto del textBox)
        return $_REQUEST[$param];
    else {
        //errore di parametri mancanti
        http_response_code(400);
        if ($conn)
            $conn->close();
        die("Parametro $param mancante");
    }

}

function checkSession()
{
    //accede alla sessione se c'è altrimenti ne crea una nuova
    session_start();
    //se la scadenza è impostata e se la sessione non è scaduta 
    if (isset($_SESSION['scadenza']) && time() < $_SESSION['scadenza']) {
        $_SESSION['scadenza'] = time() + TIMEOUT;
        setcookie(session_name(), session_id(), $_SESSION["scadenza"], "/");
    } else {
        //altrimenti o la sessione è scaduta oppure non esiste la distruggo
        session_unset();
        session_destroy();
        //-1 indica che il cookie è già scaduto
        setcookie(session_name(), '', -1, '/');
        http_response_code(403);
        die("Sessione scaduta");
    }
}
?>