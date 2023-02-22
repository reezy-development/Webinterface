<?php
require 'dbconnect.php';

// Verarbeite das Formular, wenn es abgesendet wird
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $benutzername = $_POST['benutzername'];
    $email = $_POST['email'];
    $passwort = password_hash($_POST['passwort'], PASSWORD_DEFAULT);

    // Überprüfe, ob der Benutzername oder die E-Mail-Adresse bereits in der Datenbank vorhanden sind
    $sql = "SELECT * FROM benutzer WHERE benutzername='$benutzername' OR email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 0) {
        // Benutzername und E-Mail-Adresse sind noch nicht in der Datenbank vorhanden
        // Füge den neuen Benutzer in die Datenbank ein
        $sql = "INSERT INTO benutzer (benutzername, email, passwort) VALUES ('$benutzername', '$email', '$passwort')";
        if (mysqli_query($conn, $sql)) {
            // Benutzer wurde erfolgreich eingefügt
            // Starte die Sitzung und leite den Benutzer zur Startseite weiter
            session_start();
            $_SESSION['benutzername'] = $benutzername;
            header('Location: index.php');
            exit;
        } else {
            $fehlermeldung = 'Fehler beim Hinzufügen des Benutzers: ' . mysqli_error($conn);
        }
    } else {
        // Benutzername oder E-Mail-Adresse sind bereits in der Datenbank vorhanden
        $fehlermeldung = 'Benutzername oder E-Mail-Adresse bereits in Verwendung.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrieren</title>
    <style>
        body {
            background-color: #1f2226;
            font-family: 'Open Sans', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            width: 400px;
            height: 600px;
            border-radius: 6px;
            background-color: #141517;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .logo {
            width: 150px;
            margin-bottom: 30px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            background-color: #1c1e21;
            border: none;
            color: #fff;
            font-size: 16px;
            padding: 15px;
            width: 100%;
            margin-bottom: 20px;
            border-radius: 6px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #088ccf;
            border: none;
            color: #fff;
            font-size: 16px;
            text-transform: uppercase;
            padding: 15px;
            width: 100%;
            border-radius: 6px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #066ba6;
        }

        .error {
            color: #ff4242;
            font-size: 16px;
            margin-bottom: 20px;
            text-align: center;
        }

        .login-link {
            margin-top: 20px;
            color: #fff;
            text-decoration: none;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="card">
        <img src="logo.png" alt="OpenAI" class="logo">
        <form method="post">
        <?php if (isset($fehlermeldung)): ?>
            <div class="error"><?php echo $fehlermeldung; ?></div>
        <?php endif; ?>
            <input type="text" name="benutzername" placeholder="Benutzername" required>
            <input type="email" name="email" placeholder="E-Mail-Adresse" required>
            <input type="password" name="passwort" placeholder="Passwort" required>
            <input type="submit" value="Registrieren">
        </form>
        <a href="login.php" class="login-link">Bereits registriert? Hier anmelden!</a>
    </div>
</body>
</html>