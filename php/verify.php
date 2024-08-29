<?php
session_start();

// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('Database.php'); // Assurez-vous que ce fichier initialise une connexion PDO nommée $pdo

function isAdmin($pdo, $userId) {
    try {
        // Préparer une requête pour récupérer le rôle de l'utilisateur
        $stmt = $pdo->prepare('SELECT role FROM users WHERE id = :id');
        $stmt->execute(['id' => $userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'utilisateur est un admin
        return $user && $user['role'] === 'admin';
    } catch (PDOException $e) {
        // En cas d'erreur SQL, afficher l'erreur
        echo 'Erreur lors de la requête SQL : ' . $e->getMessage();
        return false;
    }
}

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];

    // Vérifier si l'utilisateur est un admin
    if (isAdmin($pdo, $userId)) {
        // L'utilisateur est admin, afficher le contenu de la page
        echo "Bienvenue, administrateur!";
        // Ici, tu peux ajouter le contenu de ta page pour les admins
    } else {
        // L'utilisateur n'est pas admin, rediriger vers l'accueil
        header('Location: https://funfair.ovh');
        exit();
    }
} else {
    // L'utilisateur n'est pas connecté, rediriger vers l'accueil
    header('Location: https://funfair.ovh');
    exit();
}
?>
