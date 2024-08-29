<?php
include 'Database.php';

if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $delete_sql = "DELETE FROM captcha WHERE id = :id";
    $stmt = $dbh->prepare($delete_sql);
    $stmt->execute([':id' => $delete_id]);

    // Redirect to the same page to prevent form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Définir la requête SQL pour récupérer les données de la table captcha
$sql = "SELECT id, q, r FROM captcha";
$stmt = $dbh->query($sql); // Exécuter la requête


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/captcha.css">
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
        // Afficher les données de chaque ligne
        while ($row = $stmt->fetch()) {
            echo "<tr>
                <td>" . htmlspecialchars($row["id"]) . "</td>
                <td>" . htmlspecialchars($row["q"]) . "</td>
                <td>" . htmlspecialchars($row["r"]) . "</td>
            </tr>";
        }
    } else {
        // Si aucun enregistrement n'est trouvé, afficher un message
        echo "<tr><td colspan='4'>0 résultats</td></tr>";
    }
    ?>
</table>
</body>
    <div class="buttons-container">
    <a href="pdfcaptcha.php" class="action-button">Télécharger PDF</a>
    <a href="../index.php" class="action-button">Retour au Back</a>
</div>

<div class="back-to-home">
    <a href="https://funfair.ovh">Retour à l'accueil</a>
</div>

</body>
</html>
