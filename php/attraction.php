<?php
session_start();
include 'Database.php';

// Fetch the reservations from the database
$sql = "SELECT id, nom, type, prix, agemin, taillemin, idstripe FROM reservation";
$stmt = $dbh->query($sql);

// Display the data in raw format
if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "ID: " . htmlspecialchars($row["id"]) . "\n";
        echo "Nom: " . htmlspecialchars($row["nom"]) . "\n";
        echo "Type: " . htmlspecialchars($row["type"]) . "\n";
        echo "Prix: " . htmlspecialchars($row["prix"]) . "\n";
        echo "Âge Minimum: " . htmlspecialchars($row["agemin"]) . "\n";
        echo "Taille Minimum: " . htmlspecialchars($row["taillemin"]) . "\n";
        echo "ID Stripe: " . htmlspecialchars($row["idstripe"]) . "\n";
        echo "--------------------------\n";
    }
} else {
    echo "0 résultats\n";
}
