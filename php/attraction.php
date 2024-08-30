<?php
session_start();
require('Database.php');

// Ajouter une nouvelle attraction
if (isset($_POST['ajouter'])) {
    $nom = $_POST['ajouter_nom'];
    $type = $_POST['ajouter_type'];
    $prix = $_POST['ajouter_prix'];
    $agemin = $_POST['ajouter_agemin'];
    $taillemin = $_POST['ajouter_taillemin'];
    $idstripe = $_POST['ajouter_idstripe'];

    $requete = "INSERT INTO attraction (nom, type, prix, agemin, taillemin, idstripe) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($requete);
    $stmt->bind_param("ssiiis", $nom, $type, $prix, $agemin, $taillemin, $idstripe);
    $stmt->execute();
    $stmt->close();
    header("Location: attractions.php");
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

    $requete = "UPDATE attraction SET nom=?, type=?, prix=?, agemin=?, taillemin=?, idstripe=? WHERE id=?";
    $stmt = $conn->prepare($requete);
    $stmt->bind_param("ssiiisi", $nom, $type, $prix, $agemin, $taillemin, $idstripe, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: attractions.php");
    exit();
}

// Supprimer une attraction
if (isset($_POST['supprimer'])) {
    $id = $_POST['supprimer_id'];

    $requete = "DELETE FROM attraction WHERE id=?";
    $stmt = $conn->prepare($requete);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: attractions.php");
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
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['nom']; ?></td>
            <td><?php echo $row['type']; ?></td>
            <td><?php echo $row['prix']; ?></td>
            <td><?php echo $row['agemin']; ?></td>
            <td><?php echo $row['taillemin']; ?></td>
            <td><?php echo $row['idstripe']; ?></td>
            <td>
                <form method="post" action="" style="display:inline;">
                    <input type="hidden" name="modifier_id" value="<?php echo $row['id']; ?>">
                    <input type="text" name="modifier_nom" value="<?php echo $row['nom']; ?>" required>
                    <input type="text" name="modifier_type" value="<?php echo $row['type']; ?>" required>
                    <input type="number" name="modifier_prix" value="<?php echo $row['prix']; ?>" required>
                    <input type="number" name="modifier_agemin" value="<?php echo $row['agemin']; ?>" required>
                    <input type="number" name="modifier_taillemin" value="<?php echo $row['taillemin']; ?>" required>
                    <input type="text" name="modifier_idstripe" value="<?php echo $row['idstripe']; ?>" required>
                    <button type="submit" name="modifier">Modifier</button>
                </form>

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
<?php
session_start();
require('Database.php');

// Ajouter une nouvelle attraction
if (isset($_POST['ajouter'])) {
    $nom = $_POST['ajouter_nom'];
    $type = $_POST['ajouter_type'];
    $prix = $_POST['ajouter_prix'];
    $agemin = $_POST['ajouter_agemin'];
    $taillemin = $_POST['ajouter_taillemin'];
    $idstripe = $_POST['ajouter_idstripe'];

    $requete = "INSERT INTO attraction (nom, type, prix, agemin, taillemin, idstripe) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($requete);
    $stmt->bind_param("ssiiis", $nom, $type, $prix, $agemin, $taillemin, $idstripe);
    $stmt->execute();
    $stmt->close();
    header("Location: attractions.php");
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

    $requete = "UPDATE attraction SET nom=?, type=?, prix=?, agemin=?, taillemin=?, idstripe=? WHERE id=?";
    $stmt = $conn->prepare($requete);
    $stmt->bind_param("ssiiisi", $nom, $type, $prix, $agemin, $taillemin, $idstripe, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: attractions.php");
    exit();
}

// Supprimer une attraction
if (isset($_POST['supprimer'])) {
    $id = $_POST['supprimer_id'];

    $requete = "DELETE FROM attraction WHERE id=?";
    $stmt = $conn->prepare($requete);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: attractions.php");
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
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['nom']; ?></td>
            <td><?php echo $row['type']; ?></td>
            <td><?php echo $row['prix']; ?></td>
            <td><?php echo $row['agemin']; ?></td>
            <td><?php echo $row['taillemin']; ?></td>
            <td><?php echo $row['idstripe']; ?></td>
            <td>
                <form method="post" action="" style="display:inline;">
                    <input type="hidden" name="modifier_id" value="<?php echo $row['id']; ?>">
                    <input type="text" name="modifier_nom" value="<?php echo $row['nom']; ?>" required>
                    <input type="text" name="modifier_type" value="<?php echo $row['type']; ?>" required>
                    <input type="number" name="modifier_prix" value="<?php echo $row['prix']; ?>" required>
                    <input type="number" name="modifier_agemin" value="<?php echo $row['agemin']; ?>" required>
                    <input type="number" name="modifier_taillemin" value="<?php echo $row['taillemin']; ?>" required>
                    <input type="text" name="modifier_idstripe" value="<?php echo $row['idstripe']; ?>" required>
                    <button type="submit" name="modifier">Modifier</button>
                </form>

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
