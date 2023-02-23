<?php
require 'mysql/dbconnect.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $benutzername = $_POST['benutzername'];
    $passwort = $_POST['passwort'];

    $sql = "SELECT * FROM benutzer WHERE benutzername='$benutzername'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($passwort, $row['passwort'])) {
            session_start();
            $_SESSION['benutzername'] = $benutzername;
            header('Location: index.php');
            exit;
        } else {
            $fehlermeldung = 'Falsches Passwort.';
        }
    } else {
        $fehlermeldung = 'Benutzername nicht gefunden.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="card">
    <img src="img/logo.png" alt="logo" class="logo">
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