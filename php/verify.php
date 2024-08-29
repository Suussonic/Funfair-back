<?php
session_start();

// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('Database.php'); // Assurez-vous que ce fichier initialise une connexion PDO nommée $pdo

if (isset($_SESSION['firstname']) && isset($_SESSION['id'])) {
    // Si l'utilisateur est connecté et que l'ID est défini
    $userId = $_SESSION['id'];

    try {
        // Préparer une requête pour récupérer le rôle de l'utilisateur
        $stmt = $pdo->prepare('SELECT role FROM users WHERE id = :id');
        $stmt->execute(['id' => $userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si l'utilisateur n'est pas admin, rediriger vers l'accueil
        if (!$user || $user['role'] != 'admin') {
            header('Location: https://funfair.ovh');
            exit(); // Arrêter le script après la redirection
        }

        // Si l'utilisateur est admin, il peut rester sur la page
        echo "Bienvenue sur la page d'administration.";

    } catch (PDOException $e) {
        // En cas d'erreur SQL, afficher l'erreur
        echo 'Erreur lors de la requête SQL : ' . $e->getMessage();
    }

} else {
    // Si l'utilisateur n'est pas connecté ou si l'ID n'est pas défini, rediriger vers l'accueil
    header('Location: https://funfair.ovh');
    exit(); // Arrêter le script après la redirection
}
?>
