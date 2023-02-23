<?php
session_start();

require '../mysql/dbconnect.php';

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
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<div class="sidebar">
    <div class="logo">
        <img src="../img/logo.png" alt="OpenAI">
        <h1>Webinterface</h1>
    </div>
    <div class="nav">
        <a href="#" class="active">Dashboard</a>
        <a href="users.php">Users</a>
        <a href="settings.php">Settings</a>
    </div>
    <div class="profile">
        <img src="<?php echo $profilbild ?>" alt="Profile">
        <h3><?php echo strtoupper($benutzername); ?></h3>
        <button onclick="window.location.href='logout.php'">Logout</button>
    </div>
</div>
<div class="dashboard">
    <h1>Dashboard</h1>
    <p>Data</p>
</div>
</body>
</html>