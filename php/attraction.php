<?php
session_start();
include 'Database.php'; 

// Gérer la demande de suppression
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $delete_sql = "DELETE FROM attraction WHERE id = :id";
    $stmt = $dbh->prepare($delete_sql);
    $stmt->execute([':id' => $delete_id]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Gérer la demande d'ajout d'attraction
if (isset($_POST['add_nom']) && isset($_POST['add_type']) && isset($_POST['add_prix']) && isset($_POST['add_agemin']) && isset($_POST['add_taillemin']) && isset($_POST['add_idstripe'])) {
    $nom = $_POST['add_nom'];
    $type = $_POST['add_type'];
    $prix = $_POST['add_prix'];
    $agemin = $_POST['add_agemin'];
    $taillemin = $_POST['add_taillemin'];
    $idstripe = $_POST['add_idstripe'];
    
    $insert_sql = "INSERT INTO attraction (nom, type, prix, agemin, taillemin, idstripe) VALUES (:nom, :type, :prix, :agemin, :taillemin, :idstripe)";
    $stmt = $dbh->prepare($insert_sql);
    $stmt->execute([':nom' => $nom, ':type' => $type, ':prix' => $prix, ':agemin' => $agemin, ':taillemin' => $taillemin, ':idstripe' => $idstripe]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Gérer la demande de modification d'attraction
if (isset($_POST['edit_id']) && isset($_POST['edit_nom']) && isset($_POST['edit_type']) && isset($_POST['edit_prix']) && isset($_POST['edit_agemin']) && isset($_POST['edit_taillemin']) && isset($_POST['edit_idstripe'])) {
    $edit_id = $_POST['edit_id'];
    $edit_nom = $_POST['edit_nom'];
    $edit_type = $_POST['edit_type'];
    $edit_prix = $_POST['edit_prix'];
    $edit_agemin = $_POST['edit_agemin'];
    $edit_taillemin = $_POST['edit_taillemin'];
    $edit_idstripe = $_POST['edit_idstripe'];
    
    $update_sql = "UPDATE attraction SET nom = :nom, type = :type, prix = :prix, agemin = :agemin, taillemin = :taillemin, idstripe = :idstripe WHERE id = :id";
    $stmt = $dbh->prepare($update_sql);
    $stmt->execute([':nom' => $edit_nom, ':type' => $edit_type, ':prix' => $edit_prix, ':agemin' => $edit_agemin, ':taillemin' => $edit_taillemin, ':idstripe' => $edit_idstripe, ':id' => $edit_id]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Récupérer les attractions de la base de données
$sql = "SELECT id, nom, type, prix, agemin, taillemin, idstripe FROM attraction";
$stmt = $dbh->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/capchat.css">
    <link rel="shortcut icon" href="../asset/logo.png" type="image/x-icon">
    <title>Gestion des Attractions</title>
</head>
<body>

<table class="admin-table">
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Type</th>
        <th>Prix</th>
        <th>Âge Min.</th>
        <th>Taille Min.</th>
        <th>ID Stripe</th>
        <th>Actions</th>
    </tr>
    <?php
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch()) {
            echo "<tr>
                <td>" . htmlspecialchars($row["id"]) . "</td>
                <td>" . htmlspecialchars($row["nom"]) . "</td>
                <td>" . htmlspecialchars($row["type"]) . "</td>
                <td>" . htmlspecialchars($row["prix"]) . "</td>
                <td>" . htmlspecialchars($row["agemin"]) . "</td>
                <td>" . htmlspecialchars($row["taillemin"]) . "</td>
                <td>" . htmlspecialchars($row["idstripe"]) . "</td>
                <td>
                    <button class='edit-button' onclick=\"openEditPopup(" . htmlspecialchars($row['id']) . ", '" . htmlspecialchars($row['nom']) . "', '" . htmlspecialchars($row['type']) . "', '" . htmlspecialchars($row['prix']) . "', '" . htmlspecialchars($row['agemin']) . "', '" . htmlspecialchars($row['taillemin']) . "', '" . htmlspecialchars($row['idstripe']) . "')\">Modifier</button>
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
    <a href="#" onclick="openAddPopup()">Ajouter une attraction</a>
</div>

<div class="buttons-container">
    <a href="pdfattraction.php" class="action-button">Télécharger PDF</a>
    <a href="../index.php" class="action-button">Retour au Back</a>
</div>

<!-- Formulaire pour Ajouter une Attraction -->
<div id="addPopupForm" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeAddPopup()">&times;</span>
        <h2>Ajouter une Attraction</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="add_nom">Nom:</label>
            <input type="text" name="add_nom" id="add_nom" required>
            <label for="add_type">Type:</label>
            <input type="text" name="add_type" id="add_type" required>
            <label for="add_prix">Prix:</label>
            <input type="number" name="add_prix" id="add_prix" required>
            <label for="add_agemin">Âge Minimum:</label>
            <input type="number" name="add_agemin" id="add_agemin" required>
            <label for="add_taillemin">Taille Minimum:</label>
            <input type="number" name="add_taillemin" id="add_taillemin" required>
            <label for="add_idstripe">ID Stripe:</label>
            <input type="text" name="add_idstripe" id="add_idstripe" required>
            <button type="submit" class="action-button">Ajouter</button>
        </form>
    </div>
</div>

<!-- Formulaire pour Modifier une Attraction -->
<div id="editPopupForm" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeEditPopup()">&times;</span>
        <h2>Modifier une Attraction</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="edit_id" id="edit_id">
            <label for="edit_nom">Nom:</label>
            <input type="text" name="edit_nom" id="edit_nom" required>
            <label for="edit_type">Type:</label>
            <input type="text" name="edit_type" id="edit_type" required>
            <label for="edit_prix">Prix:</label>
            <input type="number" name="edit_prix" id="edit_prix" required>
            <label for="edit_agemin">Âge Minimum:</label>
            <input type="number" name="edit_agemin" id="edit_agemin" required>
            <label for="edit_taillemin">Taille Minimum:</label>
            <input type="number" name="edit_taillemin" id="edit_taillemin" required>
            <label for="edit_idstripe">ID Stripe:</label>
            <input type="text" name="edit_idstripe" id="edit_idstripe" required>
            <button type="submit" class="action-button">Modifier</button>
        </form>
    </div>
</div>

<script src="../js/popup.js"></script>
</body>
</html>
