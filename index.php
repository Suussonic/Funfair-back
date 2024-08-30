<?php
include 'php/Database.php';
// include 'php/verify.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="asset/logo.png" type="image/x-icon">
    <title>Fun Fair - Back Office</title>
    <link rel="stylesheet" href="css/back.css">
</head>
<body>
    <div class="container">
        <h1>Administration Fun Fair</h1>
        <div class="button-container">
            <a href="/logs" class="admin-button">logs</a>
            <a href="/php/user.php" class="admin-button">Gestion Utilisateurs</a>
            <a href="/php/captcha.php" class="admin-button">Gestion captcha</a>
            <a href="/captcha" class="admin-button">Gestion avis</a>
            <a href="/php/reservation.php" class="admin-button">Gestion reservation</a>
            <a href="/captcha" class="admin-button">Gestion attractions</a>
            <a href="/captcha" class="admin-button">Newsletter</a>
            <a href="gestion-horaires.html" class="admin-button">Gestion Horaires</a>
            <a href="parametres.html" class="admin-button">Paramètres</a>
        </div>
    </div>
</body>
<script src="public/assets/js/easterEgg.js"></script>
</html>
