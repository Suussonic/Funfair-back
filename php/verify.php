<?php
session_start();

// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('models/Database.php'); // Assurez-vous que ce fichier initialise une connexion PDO nommée $pdo

if (isset($_SESSION['firstname']) && isset($_SESSION['id'])) {
    // Si l'utilisateur est connecté et que l'ID est défini
    $userId = $_SESSION['id'];  // Utilisez 'id' de manière cohérente

    try {
        // Préparer une requête pour récupérer le rôle de l'utilisateur
        $stmt = $dbh->prepare('SELECT role FROM users WHERE id = :id');
        $stmt->execute(['id' => $userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Afficher le bouton "Back" pour tous les utilisateurs connectés
        echo '<a class="cta-button" href="/account">Mon compte</a>';
        echo '<a class="cta-button" href="/logout">Déconnexion</a>';

        // Si l'utilisateur est admin, afficher un lien supplémentaire pour le panneau d'administration
        if ($user && $user['role'] == 'admin') {
            echo '<a class="cta-button" href="https://admin.funfair.ovh/">Admin Panel</a>';
        }

    } catch (PDOException $e) {
        // En cas d'erreur SQL, afficher l'erreur
        echo 'Erreur lors de la requête SQL : ' . $e->getMessage();
    }

} else {
    // Si l'utilisateur n'est pas connecté ou si l'ID n'est pas défini
    echo '<a class="cta-button" href="/login">Se Connecter</a>';
}
?>
