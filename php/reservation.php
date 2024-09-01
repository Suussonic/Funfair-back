<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'Database.php'; 

$sql = "SELECT id, attractionid, montant, quantity, jour, heur, email FROM reservations";
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
        <th>Actions</th>
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
                <td>
                    <button class='edit-button' onclick=\"openEditPopup(" . htmlspecialchars($row['id']) . ", '" . htmlspecialchars($row['attractionid']) . "', '" . htmlspecialchars($row['montant']) . "', '" . htmlspecialchars($row['quantity']) . "', '" . htmlspecialchars($row['date']) . "', '" . htmlspecialchars($row['heure']) . "', '" . htmlspecialchars($row['email']) . "')\">Modifier</button>
                    <form method='POST' action='" . $_SERVER['PHP_SELF'] . "' style='display:inline;'>
                        <input type='hidden' name='delete_id' value='" . htmlspecialchars($row['id']) . "'>
                        <button type='submit' class='delete-button'>Supprimer</button>
                    </form>
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

<!-- Formulaire pour Ajouter une Réservation -->
<div id="addPopupForm" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeAddPopup()">&times;</span>
        <h2>Ajouter une Réservation</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="add_attractionid">Attraction ID:</label>
            <input type="number" name="add_attractionid" required>
            <label for="add_montant">Montant:</label>
            <input type="number" name="add_montant" required>
            <label for="add_quantity">Quantité:</label>
            <input type="number" name="add_quantity" required>
            <label for="add_date">Date:</label>
            <input type="date" name="add_date" required>
            <label for="add_heure">Heure:</label>
            <input type="time" name="add_heure" required>
            <label for="add_email">Email:</label>
            <input type="email" name="add_email" required>
            <button type="submit" class="action-button">Ajouter</button>
        </form>
    </div>
</div>

<!-- Formulaire pour Modifier une Réservation -->
<div id="editPopupForm" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeEditPopup()">&times;</span>
        <h2>Modifier une Réservation</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="edit_id" id="edit_id">
            <label for="edit_attractionid">Attraction ID:</label>
            <input type="number" name="edit_attractionid" id="edit_attractionid" required>
            <label for="edit_montant">Montant:</label>
            <input type="number" name="edit_montant" id="edit_montant" required>
            <label for="edit_quantity">Quantité:</label>
            <input type="number" name="edit_quantity" id="edit_quantity" required>
            <label for="edit_date">Date:</label>
            <input type="date" name="edit_date" id="edit_date" required>
            <label for="edit_heure">Heure:</label>
            <input type="time" name="edit_heure" id="edit_heure" required>
            <label for="edit_email">Email:</label>
            <input type="email" name="edit_email" id="edit_email" required>
            <button type="submit" class="action-button">Modifier</button>
        </form>
    </div>
</div>

<script src="../js/popup.js"></script>
</body>
</html>

