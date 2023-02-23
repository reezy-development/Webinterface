<?php
require 'mysql/dbconnect.php';

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
<html lang="de">
<head>
    <title>Registrieren</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
<div class="card">
    <img src="img/logo.png" alt="OpenAI" class="logo">
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