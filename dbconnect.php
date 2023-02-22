<?php
// Verbindung zur Datenbank herstellen
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webinterface";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Überprüfe die Verbindung
if (!$conn) {
    die("Verbindung fehlgeschlagen: " . mysqli_connect_error());
}
?>