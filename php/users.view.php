<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="public/assets/css/users.css">
    <title>Liste des Utilisateurs</title>
</head>
<body>

<h1>Liste des Utilisateurs</h1>

<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Genre</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($users)) : ?>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($user["id"]); ?></td>
                    <td><?php echo htmlspecialchars($user["firstname"]); ?></td>
                    <td><?php echo htmlspecialchars($user["lastname"]); ?></td>
                    <td><?php echo htmlspecialchars($user["email"]); ?></td>
                    <td><?php echo htmlspecialchars($user["gender"]); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="5">0 résultats</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="buttons-container">
    <a href="download_pdf.php" class="action-button">Télécharger PDF</a>
    <a href="back.php" class="action-button">Retour au Back</a>
</div>

<div class="back-to-home">
    <a href="/">Retour à l'accueil</a>
</div>

</body>
</html>
