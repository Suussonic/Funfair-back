<?php
session_start();
include_once('Database.php');

// Gérer la demande de suppression
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $delete_sql = "DELETE FROM users WHERE id = :id";
    $stmt = $dbh->prepare($delete_sql);
    $stmt->execute([':id' => $delete_id]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Gérer la demande d'ajout d'utilisateur
if (isset($_POST['add_lastname']) && isset($_POST['add_firstname']) && isset($_POST['add_gender']) && isset($_POST['add_email']) && isset($_POST['add_confirm']) && isset($_POST['add_cle']) && isset($_POST['add_role'])) {
    $lastname = $_POST['add_lastname'];
    $firstname = $_POST['add_firstname'];
    $gender = $_POST['add_gender'];
    $email = $_POST['add_email'];
    $confirm = $_POST['add_confirm'];
    $cle = $_POST['add_cle'];
    $role = $_POST['add_role'];
    
    $insert_sql = "INSERT INTO users (lastname, firstname, gender, email, confirm, cle, role) VALUES (:lastname, :firstname, :gender, :email, :confirm, :cle, :role)";
    $stmt = $dbh->prepare($insert_sql);
    $stmt->execute([':lastname' => $lastname, ':firstname' => $firstname, ':gender' => $gender, ':email' => $email, ':confirm' => $confirm, ':cle' => $cle, ':role' => $role]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Gérer la demande de modification d'utilisateur
if (isset($_POST['edit_id']) && isset($_POST['edit_lastname']) && isset($_POST['edit_firstname']) && isset($_POST['edit_gender']) && isset($_POST['edit_email']) && isset($_POST['edit_confirm']) && isset($_POST['edit_cle']) && isset($_POST['edit_role'])) {
    $edit_id = $_POST['edit_id'];
    $edit_lastname = $_POST['edit_lastname'];
    $edit_firstname = $_POST['edit_firstname'];
    $edit_gender = $_POST['edit_gender'];
    $edit_email = $_POST['edit_email'];
    $edit_confirm = $_POST['edit_confirm'];
    $edit_cle = $_POST['edit_cle'];
    $edit_role = $_POST['edit_role'];

    $update_sql = "UPDATE users SET lastname = :lastname, firstname = :firstname, gender = :gender, email = :email, confirm = :confirm, cle = :cle, role = :role WHERE id = :id";
    $stmt = $dbh->prepare($update_sql);
    $stmt->execute([':lastname' => $edit_lastname, ':firstname' => $edit_firstname, ':gender' => $edit_gender, ':email' => $edit_email, ':confirm' => $edit_confirm, ':cle' => $edit_cle, ':role' => $edit_role, ':id' => $edit_id]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Récupérer les utilisateurs de la base de données
$sql = "SELECT id, lastname, firstname, gender, email, confirm, cle, role FROM users";
$stmt = $dbh->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/captcha.css">
    <link rel="shortcut icon" href="../asset/logo.png" type="image/x-icon">
    <title>Gestion des Utilisateurs</title>
</head>
<body>

<table class="admin-table">
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Genre</th>
        <th>Email</th>
        <th>Confirm</th>
        <th>Cle</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>
    <?php
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch()) {
            echo "<tr>
                <td>" . htmlspecialchars($row["id"]) . "</td>
                <td>" . htmlspecialchars($row["lastname"]) . "</td>
                <td>" . htmlspecialchars($row["firstname"]) . "</td>
                <td>" . htmlspecialchars($row["gender"]) . "</td>
                <td>" . htmlspecialchars($row["email"]) . "</td>
                <td>" . htmlspecialchars($row["confirm"]) . "</td>
                <td>" . htmlspecialchars($row["cle"]) . "</td>
                <td>" . htmlspecialchars($row["role"]) . "</td>
                <td>
                    <button class='edit-button' onclick=\"openEditPopup(" . htmlspecialchars($row['id']) . ", '" . htmlspecialchars($row['lastname']) . "', '" . htmlspecialchars($row['firstname']) . "', '" . htmlspecialchars($row['gender']) . "', '" . htmlspecialchars($row['email']) . "', '" . htmlspecialchars($row['confirm']) . "', '" . htmlspecialchars($row['cle']) . "', '" . htmlspecialchars($row['role']) . "')\">Modifier</button>
                    <form method='POST' action='" . $_SERVER['PHP_SELF'] . "' style='display:inline;'>
                        <input type='hidden' name='delete_id' value='" . htmlspecialchars($row['id']) . "'>
                        <button type='submit' class='delete-button'>Supprimer</button>
                    </form>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='9' class='no-results'>0 résultats</td></tr>";
    }
    ?>
</table>

<div class="back-to-home">
    <a href="#" onclick="openAddPopup()">Ajouter un utilisateur</a>
</div>

<div class="buttons-container">
    <a href="pdfusers.php" class="action-button">Télécharger PDF</a>
    <a href="../index.php" class="action-button">Retour au Back</a>
</div>

<!-- Formulaires pour Ajouter un Utilisateur -->
<div id="addPopupForm" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeAddPopup()">&times;</span>
        <h2>Ajouter un Utilisateur</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="add_lastname">Nom:</label>
            <input type="text" name="add_lastname" required>
            <label for="add_firstname">Prénom:</label>
            <input type="text" name="add_firstname" required>
            <label for="add_gender">Genre:</label>
            <input type="text" name="add_gender" required>
            <label for="add_email">Email:</label>
            <input type="email" name="add_email" required>
            <label for="add_confirm">Confirm:</label>
            <input type="number" name="add_confirm" required>
            <label for="add_cle">Cle:</label>
            <input type="number" name="add_cle" required>
            <label for="add_role">Role:</label>
            <input type="text" name="add_role" required>
            <button type="submit" class="action-button">Ajouter</button>
        </form>
    </div>
</div>

<!-- Formulaire pour Modifier un Utilisateur -->
<div id="editPopupForm" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeEditPopup()">&times;</span>
        <h2>Modifier un Utilisateur</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="edit_id" id="edit_id">
            <label for="edit_lastname">Nom:</label>
            <input type="text" name="edit_lastname" id="edit_lastname" required>
            <label for="edit_firstname">Prénom:</label>
            <input type="text" name="edit_firstname" id="edit_firstname" required>
            <label for="edit_gender">Genre:</label>
            <input type="text" name="edit_gender" id="edit_gender" required>
            <label for="edit_email">Email:</label>
            <input type="email" name="edit_email" id="edit_email" required>
            <label for="edit_confirm">Confirm:</label>
            <input type="number" name="edit_confirm" id="edit_confirm" required>
            <label for="edit_cle">Cle:</label>
            <input type="number" name="edit_cle" id="edit_cle" required>
            <label for="edit_role">Role:</label>
            <input type="text" name="edit_role" id="edit_role" required>
            <button type="submit" class="action-button">Modifier</button>
        </form>
    </div>
</div>

<script src="../js/popup.js"></script>
</body>
</html>
