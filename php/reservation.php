<?php
session_start();
include 'Database.php';

// Gérer la demande de suppression
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $delete_sql = "DELETE FROM reservations WHERE id = :id";
    $stmt = $dbh->prepare($delete_sql);
    $stmt->execute([':id' => $delete_id]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Gérer la demande d'ajout de réservation
if (isset($_POST['add_attractionid']) && isset($_POST['add_montant']) && isset($_POST['add_quantity']) && isset($_POST['add_date']) && isset($_POST['add_heure']) && isset($_POST['add_email'])) {
    $attractionid = $_POST['add_attractionid'];
    $montant = $_POST['add_montant'];
    $quantity = $_POST['add_quantity'];
    $date = $_POST['add_date'];
    $heure = $_POST['add_heure'];
    $email = $_POST['add_email'];
    
    $insert_sql = "INSERT INTO reservations (attractionid, montant, quantity, date, heure, email) VALUES (:attractionid, :montant, :quantity, :date, :heure, :email)";
    $stmt = $dbh->prepare($insert_sql);
    $stmt->execute([
        ':attractionid' => $attractionid,
        ':montant' => $montant,
        ':quantity' => $quantity,
        ':date' => $date,
        ':heure' => $heure,
        ':email' => $email
    ]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Gérer la demande de modification de réservation
if (isset($_POST['edit_id']) && isset($_POST['edit_attractionid']) && isset($_POST['edit_montant']) && isset($_POST['edit_quantity']) && isset($_POST['edit_date']) && isset($_POST['edit_heure']) && isset($_POST['edit_email'])) {
    $edit_id = $_POST['edit_id'];
    $edit_attractionid = $_POST['edit_attractionid'];
    $edit_montant = $_POST['edit_montant'];
    $edit_quantity = $_POST['edit_quantity'];
    $edit_date = $_POST['edit_date'];
    $edit_heure = $_POST['edit_heure'];
    $edit_email = $_POST['edit_email'];
    
    $update_sql = "UPDATE reservations SET attractionid = :attractionid, montant = :montant, quantity = :quantity, date = :date, heure = :heure, email = :email WHERE id = :id";
    $stmt = $dbh->prepare($update_sql);
    $stmt->execute([
        ':attractionid' => $edit_attractionid,
        ':montant' => $edit_montant,
        ':quantity' => $edit_quantity,
        ':date' => $edit_date,
        ':heure' => $edit_heure,
        ':email' => $edit_email,
        ':id' => $edit_id
    ]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Récupérer les réservations de la base de données
$sql = "SELECT id, attractionid, montant, quantity, date, heure, email FROM reservations";
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
    <a href="pdfreservations.php" class="action-button">Télécharger PDF</a>
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

