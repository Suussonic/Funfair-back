<?php
include 'models/Database.php';

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


require 'views/back/captcha.view.php';
?>