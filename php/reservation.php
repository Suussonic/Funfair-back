<?php
session_start();
include 'Database.php'; 

$sql = "SELECT id, attractionid, montant, quantity, jour, heure, email FROM reservations";
$stmt = $dbh->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/captcha.css">
    <link rel="shortcut icon" href="../asset/logo.png" type="image/x-icon">
    <title>Gestion des Réservations</title>
</head>
<body>

<table class="admin-table">
    <tr>
        <th>ID</th>
        <th>Attraction ID</th>
        <th>Montant</th>
        <th>Quantité</th>
        <th>Date</th>
        <th>Heure</th>
        <th>Email</th>
    </tr>
    <?php
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch()) {
            echo "<tr>
                <td>" . htmlspecialchars($row["id"]) . "</td>
                <td>" . htmlspecialchars($row["attractionid"]) . "</td>
                <td>" . htmlspecialchars($row["montant"]) . "</td>
                <td>" . htmlspecialchars($row["quantity"]) . "</td>
                <td>" . htmlspecialchars($row["date"]) . "</td>
                <td>" . htmlspecialchars($row["heure"]) . "</td>
                <td>" . htmlspecialchars($row["email"]) . "</td>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='8' class='no-results'>0 résultats</td></tr>";
    }
    ?>
</table>

<div class="back-to-home">
    <a href="#" onclick="openAddPopup()">Ajouter une réservation</a>
</div>

<div class="buttons-container">
    <a href="pdfreservation.php" class="action-button">Télécharger PDF</a>
    <a href="../index.php" class="action-button">Retour au Back</a>
</div>



<script src="../js/popup.js"></script>
</body>
</html>

