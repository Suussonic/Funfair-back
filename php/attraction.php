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

// Gérer la demande d'ajout de captcha
if (isset($_POST['add_q']) && isset($_POST['add_r'])) {
    $q = $_POST['add_q'];
    $r = $_POST['add_r'];
    $insert_sql = "INSERT INTO captcha (q, r) VALUES (:q, :r)";
    $stmt = $dbh->prepare($insert_sql);
    $stmt->execute([':q' => $q, ':r' => $r]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Géreée la demande de modification de captcha
if (isset($_POST['edit_id']) && isset($_POST['edit_q']) && isset($_POST['edit_r'])) {
    $edit_id = $_POST['edit_id'];
    $edit_q = $_POST['edit_q'];
    $edit_r = $_POST['edit_r'];
    $update_sql = "UPDATE captcha SET q = :q, r = :r WHERE id = :id";
    $stmt = $dbh->prepare($update_sql);
    $stmt->execute([':q' => $edit_q, ':r' => $edit_r, ':id' => $edit_id]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Récupérer les captchas de la base de données
$sql = "SELECT id, q, r FROM captcha";
$stmt = $dbh->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/captcha.css">
    <link rel="shortcut icon" href="../asset/logo.png" type="image/x-icon">
    <title>Gestion des Captchas</title>
</head>
<body>

<table class="admin-table">
    <tr>
        <th>ID</th>
        <th>Question (Q)</th>
        <th>Réponse (R)</th>
        <th>Actions</th>
    </tr>
    <?php
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch()) {
            echo "<tr>
                <td>" . htmlspecialchars($row["id"]) . "</td>
                <td>" . htmlspecialchars($row["q"]) . "</td>
                <td>" . htmlspecialchars($row["r"]) . "</td>
                <td>
                    <button class='edit-button' onclick=\"openEditPopup(" . htmlspecialchars($row['id']) . ", '" . htmlspecialchars($row['q']) . "', '" . htmlspecialchars($row['r']) . "')\">Modifier</button>
                    <form method='POST' action='" . $_SERVER['PHP_SELF'] . "' style='display:inline;'>
                        <input type='hidden' name='delete_id' value='" . htmlspecialchars($row['id']) . "'>
                        <button type='submit' class='delete-button'>Supprimer</button>
                    </form>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='4' class='no-results'>0 résultats</td></tr>";
    }
    ?>
</table>

<div class="back-to-home">
    <a href="#" onclick="openAddPopup()">Ajouter un captcha</a>
</div>

<div class="buttons-container">
    <a href="pdfcaptcha.php" class="action-button">Télécharger PDF</a>
    <a href="../index.php" class="action-button">Retour au Back</a>
</div>

<!-- Formulaires  pour Ajouter un Captcha -->
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

<!-- Formulaire pour Modifier un Captcha -->
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
    
<!-- Formulaire pour Ajouter un Captcha -->
<div id="addPopupForm" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeAddPopup()">&times;</span>
        <h2>Ajouter un Captcha</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="add_q">Question (Q):</label>
            <input type="text" name="add_q" id="add_q" required>
            <label for="add_r">Réponse (R):</label>
            <input type="text" name="add_r" id="add_r" required>
            <button type="submit" class="action-button">Ajouter</button>
        </form>
    </div>
</div>
    
<script src="../js/popup.js"></script>
</body>
</html>
=======
>>>>>>> c29d3fe871f370c6643a21541108def68e673e4b
