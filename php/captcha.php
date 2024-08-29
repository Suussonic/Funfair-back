<?php
session_start();
include 'Database.php'; // Database connection

// Handle delete request
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $delete_sql = "DELETE FROM captcha WHERE id = :id";
    $stmt = $dbh->prepare($delete_sql);
    $stmt->execute([':id' => $delete_id]);

    // Redirect to the same page to prevent form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Handle add captcha request
if (isset($_POST['q']) && isset($_POST['r'])) {
    $q = $_POST['q'];
    $r = $_POST['r'];
    $insert_sql = "INSERT INTO captcha (q, r) VALUES (:q, :r)";
    $stmt = $dbh->prepare($insert_sql);
    $stmt->execute([':q' => $q, ':r' => $r]);

    // Redirect to the same page to prevent form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch captchas from database
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
    <title>Captcha</title>
</head>
<body>

<table class="admin-table">
    <tr>
        <th>ID</th>
        <th>Q</th>
        <th>R</th>
    </tr>
    <?php
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch()) {
            echo "<tr>
                <td>" . htmlspecialchars($row["id"]) . "</td>
                <td>" . htmlspecialchars($row["q"]) . "</td>
                <td>" . htmlspecialchars($row["r"]) . "</td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='4' class='no-results'>0 résultats</td></tr>";
    }
    ?>
</table>

<div class="back-to-home">
    <a href="#" onclick="openPopup()">Ajouter un captcha</a>
</div>

<div class="buttons-container">
    <a href="pdfcaptcha.php" class="action-button">Télécharger PDF</a>
    <a href="../index.php" class="action-button">Retour au Back</a>
</div>

<!-- Popup Form -->
<div id="popupForm" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closePopup()">&times;</span>
        <h2>Ajouter un Captcha</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="q">Question (Q):</label>
            <input type="text" name="q" required>
            <label for="r">Réponse (R):</label>
            <input type="text" name="r" required>
            <button type="submit" class="action-button">Ajouter</button>
        </form>
    </div>
</div>

<script src="../js/captcha.js"></script>
</body>
</html>
