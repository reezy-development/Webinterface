<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webpanel";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Verbindung fehlgeschlagen: " . mysqli_connect_error());
}
?>