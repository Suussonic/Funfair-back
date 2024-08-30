<?php
session_start();
include 'Database.php'; 
// Requête SQL pour récupérer les réservations
$sql = "SELECT id, nom, type, prix, agemin, taillemin, idstripe FROM reservation";
$stmt = $dbh->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reservation.css">
    <link rel="shortcut icon" href="../asset/logo.png" type="image/x-icon">
    <title>Affichage des Réservations</title>
</head>
<body>

<table class="admin-table">
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Type</th>
        <th>Prix</th>
        <th>Âge Minimum</th>
        <th>Taille Minimum</th>
        <th>ID Stripe</th>
    </tr>
    <?php
    if ($stmt && $stmt->rowCount() > 0) {  // Vérifie si la requête a retourné des résultats
        while ($row = $stmt->fetch()) {
            echo "<tr>
                <td>" . htmlspecialchars($row['id']) . "</td>
                <td>" . htmlspecialchars($row['nom']) . "</td>
                <td>" . htmlspecialchars($row['type']) . "</td>
                <td>" . htmlspecialchars($row['prix']) . "</td>
                <td>" . htmlspecialchars($row['agemin']) . "</td>
                <td>" . htmlspecialchars($row['taillemin']) . "</td>
                <td>" . htmlspecialchars($row['idstripe']) . "</td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='7' class='no-results'>0 résultats</td></tr>";
    }
    ?>
</table>

<div class="buttons-container">
    <a href="pdfreservation.php" class="action-button">Télécharger PDF</a>
    <a href="../index.php" class="action-button">Retour au Back</a>
</div>

</body>
</html>