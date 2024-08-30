<?php
session_start();
include 'Database.php';

// Gérer la demande de suppression
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $delete_sql = "DELETE FROM reservations WHERE id = :id";
    $stmt = $dbh->prepare($delete_sql);
    $stmt->execute([':id' => $delete_id]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Gérer la demande d'ajout de réservation
if (isset($_POST['add_attractionid']) && isset($_POST['add_montant']) && isset($_POST['add_quantity']) && isset($_POST['add_date']) && isset($_POST['add_heure']) && isset($_POST['add_email'])) {
    $attractionid = $_POST['add_attractionid'];
    $montant = $_POST['add_montant'];
    $quantity = $_POST['add_quantity'];
    $date = $_POST['add_date'];
    $heure = $_POST['add_heure'];
    $email = $_POST['add_email'];
    
    $insert_sql = "INSERT INTO reservations (attractionid, montant, quantity, date, heure, email) VALUES (:attractionid, :montant, :quantity, :date, :heure, :email)";
    $stmt = $dbh->prepare($insert_sql);
    $stmt->execute([
        ':attractionid' => $attractionid,
        ':montant' => $montant,
        ':quantity' => $quantity,
        ':date' => $date,
        ':heure' => $heure,
        ':email' => $email
    ]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Gérer la demande de modification de réservation
if (isset($_POST['edit_id']) && isset($_POST['edit_attractionid']) && isset($_POST['edit_montant']) && isset($_POST['edit_quantity']) && isset($_POST['edit_date']) && isset($_POST['edit_heure']) && isset($_POST['edit_email'])) {
    $edit_id = $_POST['edit_id'];
    $edit_attractionid = $_POST['edit_attractionid'];
    $edit_montant = $_POST['edit_montant'];
    $edit_quantity = $_POST['edit_quantity'];
    $edit_date = $_POST['edit_date'];
    $edit_heure = $_POST['edit_heure'];
    $edit_email = $_POST['edit_email'];
    
    $update_sql = "UPDATE reservations SET attractionid = :attractionid, montant = :montant, quantity = :quantity, date = :date, heure = :heure, email = :email WHERE id = :id";
    $stmt = $dbh->prepare($update_sql);
    $stmt->execute([
        ':attractionid' => $edit_attractionid,
        ':montant' => $edit_montant,
        ':quantity' => $edit_quantity,
        ':date' => $edit_date,
        ':heure' => $edit_heure,
        ':email' => $edit_email,
        ':id' => $edit_id
    ]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Récupérer les réservations de la base de données
$sql = "SELECT id, attractionid, montant, quantity, date, heure, email FROM reservations";
$stmt = $dbh->query($sql);
?>
