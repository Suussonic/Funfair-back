<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="public/assets/css/captcha.css">
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
    <a href="/" class="action-button">Télécharger PDF</a>
    <a href="/back" class="action-button">Retour au Back</a>
</div>

<div class="back-to-home">
    <a href="/">Retour à l'accueil</a>
</div>

</body>
</html>
