<?php
session_start();
include 'Database.php'; 

// Gérer la demande de suppression
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $delete_sql = "DELETE FROM captcha WHERE id = :id";
    $stmt = $dbh->prepare($delete_sql);
    $stmt->execute([':id' => $delete_id]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
    
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/captcha.css">
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

<div id="addPopupForm" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeAddPopup()">&times;</span>
        <h2>Ajouter un Captcha</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="add_q">Question (Q):</label>
            <input type="text" name="add_q" required>
            <label for="add_r">Réponse (R):</label>
            <input type="text" name="add_r" required>
            <button type="submit" class="action-button">Ajouter</button>
        </form>
    </div>
</div>


<div id="editPopupForm" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeEditPopup()">&times;</span>
        <h2>Modifier un Captcha</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="edit_id" id="edit_id">
            <label for="edit_q">Question (Q):</label>
            <input type="text" name="edit_q" id="edit_q" required>
            <label for="edit_r">Réponse (R):</label>
            <input type="text" name="edit_r" id="edit_r" required>
            <button type="submit" class="action-button">Modifier</button>
        </form>
    </div>
</div>

</body>
</html>
