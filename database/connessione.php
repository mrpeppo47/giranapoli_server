<?php
$host = "localhost";
$user = getenv("DB_USER");
$password = getenv("DB_PASS");
$dbname = getenv("DB_NAME");

$connessione = new mysqli($host, $user, $password, $dbname);

if ($connessione->connect_error) {
    die("Connessione fallita: " . $connessione->connect_error);
}
?>
