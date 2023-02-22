<?php
require 'dbconnect.php';

// Verarbeite das Formular, wenn es abgesendet wird
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $benutzername = $_POST['benutzername'];
    $passwort = $_POST['passwort'];

    // Überprüfe, ob der Benutzername und das Passwort in der Datenbank vorhanden sind
    $sql = "SELECT * FROM benutzer WHERE benutzername='$benutzername'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($passwort, $row['passwort'])) {
            // Benutzername und Passwort sind korrekt
            // Starte die Sitzung und leite den Benutzer zur Startseite weiter
            session_start();
            $_SESSION['benutzername'] = $benutzername;
            header('Location: index.php');
            exit;
        } else {
            // Passwort ist falsch
            $fehlermeldung = 'Falsches Passwort.';
        }
    } else {
        // Benutzername ist falsch oder der Benutzer existiert nicht
        $fehlermeldung = 'Benutzername nicht gefunden.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
            height: 500px;
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

        .forgot-password {
            margin-top: 20px;
            color: #fff;
            text-decoration: none;
            font-size: 16px;
        }

        .register-link {
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
            <input type="password" name="passwort" placeholder="Passwort" required>
            <input type="submit" value="Anmelden">
        </form>
        <a href="#" class="forgot-password">Passwort vergessen?</a>
        <a href="register.php" class="register-link">Noch keinen Account? Jetzt registrieren!</a>
    </div>
</body>
</html>