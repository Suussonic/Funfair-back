<?php
session_start();
include 'Database.php'; 


if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $delete_sql = "DELETE FROM users WHERE id = :id";
    $stmt = $dbh->prepare($delete_sql);
    $stmt->execute([':id' => $delete_id]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}


if (isset($_POST['add_name']) && isset($_POST['add_email'])) {
    $name = $_POST['add_name'];
    $email = $_POST['add_email'];
    $insert_sql = "INSERT INTO users (name, email) VALUES (:name, :email)";
    $stmt = $dbh->prepare($insert_sql);
    $stmt->execute([':name' => $name, ':email' => $email]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}


if (isset($_POST['edit_id']) && isset($_POST['edit_name']) && isset($_POST['edit_email'])) {
    $edit_id = $_POST['edit_id'];
    $edit_name = $_POST['edit_name'];
    $edit_email = $_POST['edit_email'];
    $update_sql = "UPDATE users SET name = :name, email = :email WHERE id = :id";
    $stmt = $dbh->prepare($update_sql);
    $stmt->execute([':name' => $edit_name, ':email' => $edit_email, ':id' => $edit_id]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}


$sql = "SELECT id, name, email FROM users";
$stmt = $dbh->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/users.css">
    <link rel="shortcut icon" href="../asset/logo.png" type="image/x-icon">
    <title>Gestion utilisateur</title>
</head>
<body>

<table class="admin-table">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>
    <?php
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch()) {
            echo "<tr>
                <td>" . htmlspecialchars($row["id"]) . "</td>
                <td>" . htmlspecialchars($row["name"]) . "</td>
                <td>" . htmlspecialchars($row["email"]) . "</td>
                <td>
                    <button class='edit-button' onclick=\"openEditPopup(" . htmlspecialchars($row['id']) . ", '" . htmlspecialchars($row['name']) . "', '" . htmlspecialchars($row['email']) . "')\">Edit</button>
                    <form method='POST' action='" . $_SERVER['PHP_SELF'] . "' style='display:inline;'>
                        <input type='hidden' name='delete_id' value='" . htmlspecialchars($row['id']) . "'>
                        <button type='submit' class='delete-button'>Delete</button>
                    </form>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='4' class='no-results'>No results</td></tr>";
    }
    ?>
</table>

<div class="back-to-home">
    <a href="#" onclick="openAddPopup()">Add User</a>
</div>

<div class="buttons-container">
    <a href="pdfusers.php" class="action-button">Download PDF</a>
    <a href="../index.php" class="action-button">Back</a>
</div>

<div id="addPopupForm" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeAddPopup()">&times;</span>
        <h2>Add User</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="add_name">Name:</label>
            <input type="text" name="add_name" required>
            <label for="add_email">Email:</label>
            <input type="email" name="add_email" required>
            <button type="submit" class="action-button">Add</button>
        </form>
    </div>
</div>


<div id="editPopupForm" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeEditPopup()">&times;</span>
        <h2>Edit User</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="edit_id" id="edit_id">
            <label for="edit_name">Name:</label>
            <input type="text" name="edit_name" id="edit_name" required>
            <label for="edit_email">Email:</label>
            <input type="email" name="edit_email" id="edit_email" required>
            <button type="submit" class="action-button">Edit</button>
        </form>
    </div>
</div>
    
<script src="../js/popup.js"></script>
</body>
</html>
