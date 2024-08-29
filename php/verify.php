<?php
session_start();

// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('Database.php'); // Assurez-vous que ce fichier initialise une connexion PDO nommée $pdo

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['firstname']) && isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];

    try {
        // Préparer une requête pour récupérer le rôle de l'utilisateur
        $stmt = $pdo->prepare('SELECT role FROM users WHERE id = :id');
        $stmt->execute(['id' => $userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Débogage : afficher le résultat de la requête
        if ($user) {
            echo "Rôle de l'utilisateur : " . $user['role'];
        } else {
            echo "Utilisateur non trouvé dans la base de données.";
        }

        // Vérifier le rôle de l'utilisateur
        if ($user && $user['role'] === 'admin') {
            // L'utilisateur est admin, afficher le contenu de la page
            echo "Bienvenue, administrateur!";
            // Ici, tu peux ajouter le contenu de ta page pour les admins
        } else {
            // L'utilisateur n'est pas admin ou non trouvé, rediriger vers l'accueil
            header('Location: https://funfair.ovh');
            exit();
        }

    } catch (PDOException $e) {
        // En cas d'erreur SQL, afficher l'erreur
        echo 'Erreur lors de la requête SQL : ' . $e->getMessage();
    }

} else {
    // L'utilisateur n'est pas connecté, rediriger vers l'accueil
    header('Location: https://funfair.ovh');
    exit();
}
?>
