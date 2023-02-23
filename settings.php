<?php
session_start();

require 'dbconnect.php';

// Überprüfen, ob der Benutzer angemeldet ist
if (!isset($_SESSION['benutzername'])) {
    header('Location: login.php');
    exit;
}

// Abfrage, um Benutzerdaten aus der Datenbank abzurufen
$stmt = $conn->prepare("SELECT * FROM benutzer WHERE benutzername = ?");
$stmt->bind_param('s', $_SESSION['benutzername']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$benutzername = $row['benutzername'];
$profilbild = $row['profilbild'];
$rang = $row['rang'];
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <title>Settings</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<div class="sidebar">
    <div class="logo">
        <img src="img/logo.png" alt="OpenAI">
        <h1>Webinterface</h1>
    </div>
    <div class="nav">
        <a href="index.php">Dashboard</a>
        <a href="#">Messages</a>
        <a href="#" class="active">Settings</a>
        <a href="#">Support</a>
    </div>
    <div class="profile">
        <img src="<?php echo $profilbild ?>" alt="Profile">
        <h3><?php echo strtoupper($benutzername); ?></h3>
        <button onclick="window.location.href='logout.php'">Logout</button>
    </div>
</div>
<div class="settings">
    <h1>Settings</h1>
    <p>Here are your settings</p>
</div>
</body>
</html>
