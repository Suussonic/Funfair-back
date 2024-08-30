<?php
session_start();
include_once('Database.php');

// Gérer la demande de suppression
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $delete_sql = "DELETE FROM users WHERE id = :id";
    $stmt = $dbh->prepare($delete_sql);
    $stmt->execute([':id' => $delete_id]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Gérer la demande d'ajout d'utilisateur
if (isset($_POST['add_lastname']) && isset($_POST['add_firstname']) && isset($_POST['add_gender']) && isset($_POST['add_email']) && isset($_POST['add_confirm']) && isset($_POST['add_cle'])) {
    $lastname = $_POST['add_lastname'];
    $firstname = $_POST['add_firstname'];
    $gender = $_POST['add_gender'];
    $email = $_POST['add_email'];
    $confirm = $_POST['add_confirm'];
    $cle = $_POST['add_cle'];
    
    $insert_sql = "INSERT INTO users (lastname, firstname, gender, email, confirm, cle) VALUES (:lastname, :firstname, :gender, :email, :confirm, :cle)";
    $stmt = $dbh->prepare($insert_sql);
    $stmt->execute([
        ':lastname' => $lastname, 
        ':firstname' => $firstname, 
        ':gender' => $gender, 
        ':email' => $email, 
        ':confirm' => $confirm, 
        ':cle' => $cle
    ]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Gérer la demande de modification d'utilisateur
if (isset($_POST['edit_id']) && isset($_POST['edit_lastname']) && isset($_POST['edit_firstname']) && isset($_POST['edit_gender']) && isset($_POST['edit_email']) && isset($_POST['edit_confirm']) && isset($_POST['edit_cle'])) {
    $edit_id = $_POST['edit_id'];
    $edit_lastname = $_POST['edit_lastname'];
    $edit_firstname = $_POST['edit_firstname'];
    $edit_gender = $_POST['edit_gender'];
    $edit_email = $_POST['edit_email'];
    $edit_confirm = $_POST['edit_confirm'];
    $edit_cle = $_POST['edit_cle'];

    $update_sql = "UPDATE users SET lastname = :lastname, firstname = :firstname, gender = :gender, email = :email, confirm = :confirm, cle = :cle WHERE id = :id";
    $stmt = $dbh->prepare($update_sql);
    $stmt->execute([
        ':lastname' => $edit_lastname, 
        ':firstname' => $edit_firstname, 
        ':gender' => $edit_gender, 
        ':email' => $edit_email, 
        ':confirm' => $edit_confirm, 
        ':cle' => $edit_cle, 
        ':id' => $edit_id
    ]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Récupérer les utilisateurs de la base de données
$sql = "SELECT id, lastname, firstname, gender, email, confirm, cle FROM users";
$stmt = $dbh->query($sql);
?>
