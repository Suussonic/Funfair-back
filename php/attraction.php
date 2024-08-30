<?php
session_start();
require('Database.php'); // Ensure this file correctly establishes the $conn variable

// Ajouter une nouvelle attraction
if (isset($_POST['ajouter'])) {
    $nom = $_POST['ajouter_nom'];
    $type = $_POST['ajouter_type'];
    $prix = $_POST['ajouter_prix'];
    $agemin = $_POST['ajouter_agemin'];
    $taillemin = $_POST['ajouter_taillemin'];
    $idstripe = $_POST['ajouter_idstripe'];

    // Use prepared statement to avoid SQL injection
    $requete = "INSERT INTO attraction (nom, type, prix, agemin, taillemin, idstripe) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($requete);
    $stmt->bind_param("ssiiis", $nom, $type, $prix, $agemin, $taillemin, $idstripe);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Mettre à jour une attraction existante
if (isset($_POST['modifier'])) {
    $id = $_POST['modifier_id'];
    $nom = $_POST['modifier_nom'];
    $type = $_POST['modifier_type'];
    $prix = $_POST['modifier_prix'];
    $agemin = $_POST['modifier_agemin'];
    $taillemin = $_POST['modifier_taillemin'];
    $idstripe = $_POST['modifier_idstripe'];

    // Use prepared statement to avoid SQL injection
    $requete = "UPDATE attraction SET nom=?, type=?, prix=?, agemin=?, taillemin=?, idstripe=? WHERE id=?";
    $stmt = $conn->prepare($requete);
    $stmt->bind_param("ssiiisi", $nom, $type, $prix, $agemin, $taillemin, $idstripe, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Supprimer une attraction
if (isset($_POST['supprimer'])) {
    $id = $_POST['supprimer_id'];

    // Use prepared statement to avoid SQL injection
    $requete = "DELETE FROM attraction WHERE id=?";
    $stmt = $conn->prepare($requete);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Récupérer toutes les attractions
$requete = "SELECT * FROM attraction";
$resultat = $conn->query($requete);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Attractions</title>
</head>
<body>

<h2>Gestion des Attractions</h2>

<!-- Formulaire d'ajout d'une nouvelle attraction -->
<form method="post" action="">
    <input type="text" name="ajouter_nom" placeholder="Nom de l'Attraction" required>
    <input type="text" name="ajouter_type" placeholder="Type" required>
    <input type="number" name="ajouter_prix" placeholder="Prix" required>
    <input type="number" name="ajouter_agemin" placeholder="Âge Minimum" required>
    <input type="number" name="ajouter_taillemin" placeholder="Taille Minimum" required>
    <input type="text" name="ajouter_idstripe" placeholder="ID Stripe" required>
    <button type="submit" name="ajouter">Ajouter Attraction</button>
</form>

<h3>Liste des Attractions</h3>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Type</th>
        <th>Prix</th>
        <th>Âge Min</th>
        <th>Taille Min</th>
        <th>ID Stripe</th>
        <th>Actions</th>
    </tr>

    <?php while ($row = $resultat->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['id']); ?></td>
            <td><?php echo htmlspecialchars($row['nom']); ?></td>
            <td><?php echo htmlspecialchars($row['type']); ?></td>
            <td><?php echo htmlspecialchars($row['prix']); ?></td>
            <td><?php echo htmlspecialchars($row['agemin']); ?></td>
            <td><?php echo htmlspecialchars($row['taillemin']); ?></td>
            <td><?php echo htmlspecialchars($row['idstripe']); ?></td>
            <td>
                <!-- Form for modifying an attraction -->
                <form method="post" action="" style="display:inline;">
                    <input type="hidden" name="modifier_id" value="<?php echo $row['id']; ?>">
                    <input type="text" name="modifier_nom" value="<?php echo htmlspecialchars($row['nom']); ?>" required>
                    <input type="text" name="modifier_type" value="<?php echo htmlspecialchars($row['type']); ?>" required>
                    <input type="number" name="modifier_prix" value="<?php echo htmlspecialchars($row['prix']); ?>" required>
                    <input type="number" name="modifier_agemin" value="<?php echo htmlspecialchars($row['agemin']); ?>" required>
                    <input type="number" name="modifier_taillemin" value="<?php echo htmlspecialchars($row['taillemin']); ?>" required>
                    <input type="text" name="modifier_idstripe" value="<?php echo htmlspecialchars($row['idstripe']); ?>" required>
                    <button type="submit" name="modifier">Modifier</button>
                </form>

                <!-- Form for deleting an attraction -->
                <form method="post" action="" style="display:inline;">
                    <input type="hidden" name="supprimer_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="supprimer">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
