<?php
session_start();
include 'Database.php'; 

// Handle make admin request
if (isset($_POST['make_admin_id'])) {
    $make_admin_id = $_POST['make_admin_id'];
    $update_sql = "UPDATE users SET role = 'admin' WHERE id = :id";
    $stmt = $dbh->prepare($update_sql);
    $stmt->execute([':id' => $make_admin_id]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch users from the database
$sql = "SELECT id, firstname, lastname, email, role FROM users";
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
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>
    <?php
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch()) {
            echo "<tr>
                <td>" . htmlspecialchars($row["id"]) . "</td>
                <td>" . htmlspecialchars($row["firstname"]) . "</td>
                <td>" . htmlspecialchars($row["lastname"]) . "</td>
                <td>" . htmlspecialchars($row["email"]) . "</td>
                <td>" . htmlspecialchars($row["role"]) . "</td>
                <td>";
                
            // Only show the "Make Admin" button if the user is not already an admin
            if ($row["role"] !== "admin") {
                echo "<form method='POST' action='" . $_SERVER['PHP_SELF'] . "' style='display:inline;'>
                        <input type='hidden' name='make_admin_id' value='" . htmlspecialchars($row['id']) . "'>
                        <button type='submit' class='admin-button'>Make Admin</button>
                      </form>";
            } else {
                echo "Admin"; // Show "Admin" if the user is already an admin
            }

            echo "</td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='6' class='no-results'>No results</td></tr>";
    }
    ?>
</table>

<div class="back-to-home">
    <a href="../index.php" class="action-button">Back</a>
</div>

<script src="../js/popup.js"></script>
</body>
</html>
