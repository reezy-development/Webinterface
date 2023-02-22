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
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            background-color: #1f2226;
            font-family: 'Open Sans', sans-serif;
            display: flex;
            height: 100vh;
            margin: 0;
        }

        .dashboard {
            background-color: #fff;
            flex: 1;
            padding: 20px;
        }
        
        h1 {
            font-size: 24px;
            margin: 0 0 20px;
        }
        
        p {
            font-size: 16px;
            margin: 0;
        }


        .sidebar {
            background-color: #141517;
            width: 250px;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 40px;
            margin-right: 10px;
        }

        .logo h1 {
            color: #fff;
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }

        .nav {
            width: 100%;
            display: flex;
            flex-direction: column;
            margin-top: 40px;
        }

        .nav a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            padding: 10px 20px;
            margin-bottom: 10px;
            border-radius: 6px;
        }

        .nav a:hover {
            background-color: #2a2d31;
        }

        .nav a.active {
            background-color: #088ccf;
        }

        .profile {
            margin-top: auto;
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .profile img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .profile p {
            color: #fff;
            font-size: 16px;
            margin: 0;
        }

        .profile h3 {
            color: #fff;
            font-size: 16px;
            margin: 0;
        }

        .profile h4 {
            color: #fff;
            font-size: 14px;
            margin: 0;
        }

        .profile button {
            background-color: #088ccf;
            border: none;
            color: #fff;
            font-size: 16px;
            text-transform: uppercase;
            padding: 10px 20px;
            margin-left: 20px;
            border-radius: 6px;
            cursor: pointer;
        }

        .profile button:hover {
            background-color: #066ba6;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <img src="logo.png" alt="OpenAI">
            <h1>Infinity-Shop</h1>
        </div>
        <div class="nav">
            <a href="#" class="active">Dashboard</a>
            <a href="#">Messages</a>
            <a href="#">Settings</a>
            <a href="#">Support</a>
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