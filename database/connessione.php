<?php
$host = getenv("DB_HOST");
$port = getenv("DB_PORT");
$user = getenv("DB_USER");
$password = getenv("DB_PASS");
$dbname = getenv("DB_NAME");

$connessione = new mysqli($host, $user, $password, $dbname, $port);

if ($connessione->connect_error) {
    die("Connessione fallita: " . $connessione->connect_error);
}
?>
