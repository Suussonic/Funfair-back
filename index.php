<?php
include 'php/Database.php';
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
            <a href="/php/graph.php" class="admin-button">logs</a>
            <a href="/php/users.php" class="admin-button">Gestion Utilisateurs</a>
            <a href="/php/captcha.php" class="admin-button">Gestion captcha</a>
            <a href="/php/reservation.php" class="admin-button">Gestion reservation</a>
            <a href="/php/att.php" class="admin-button">Gestion attractions</a>
            <a href="/php/newsletter.php" class="admin-button">Newsletter</a>
            <a href="https://funfair.ovh" class="admin-button">Retour a FunFair</a>
        </div>
    </div>
</body>
<script src="public/assets/js/easterEgg.js"></script>
</html>
