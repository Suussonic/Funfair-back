<?php
session_start();

// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Augmenter temporairement la limite de mémoire (optionnel)
ini_set('memory_limit', '256M');

// Inclure le fichier de connexion à la base de données
require_once 'Database.php'; // Assurez-vous que ce fichier initialise une connexion PDO nommée $dbh

// Vérifier si la connexion PDO est établie
if (!$dbh) {
    die('Erreur : Impossible de se connecter à la base de données.');
}

// Fonction pour afficher la popup
function displayPopup($message) {
    echo '
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Accès Refusé</title>
        <style>
            body { margin: 0; font-family: Arial, sans-serif; background-color: #f2f2f2; }
            .popup-overlay {
                display: flex;
                justify-content: center;
                align-items: center;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1000;
            }
            .popup-content {
                background: #fff;
                padding: 30px;
                border-radius: 8px;
                text-align: center;
                box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            }
            .popup-content h1 {
                margin-bottom: 20px;
                font-size: 24px;
                color: #333;
            }
            .popup-content p {
                font-size: 16px;
                color: #666;
                margin-bottom: 30px;
            }
            .popup-content button {
                background-color: #007bff;
                border: none;
                color: white;
                padding: 10px 20px;
                font-size: 16px;
                cursor: pointer;
                border-radius: 5px;
                transition: background-color 0.3s;
            }
            .popup-content button:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>
        <div class="popup-overlay">
            <div class="popup-content">
                <h1>Accès Refusé</h1>
                <p>' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</p>
                <button onclick="window.location.href=\'https://funfair.ovh\'">Retour à l\'accueil</button>
            </div>
        </div>
    </body>
    </html>';
    exit;
}

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];

    try {
        // Préparer et exécuter la requête pour récupérer le rôle de l'utilisateur
        $stmt = $dbh->prepare('SELECT role FROM users WHERE id = :id');
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $user['role'] === 'admin') {
            // L'utilisateur est admin
            echo '<script>console.log("Vous êtes connecté en tant qu\'administrateur.");</script>';
            // Placez ici le code réservé aux administrateurs
        } else {
            // L'utilisateur n'est pas admin
            displayPopup("Vous n'avez pas l'autorisation pour accéder à cette page.");
        }
    } catch (PDOException $e) {
        // Gérer les erreurs de la base de données
        error_log('Erreur lors de la requête SQL : ' . $e->getMessage());
        displayPopup("Une erreur interne est survenue. Veuillez réessayer plus tard.");
    }
} else {
    // L'utilisateur n'est pas connecté
    displayPopup("Vous devez être connecté pour accéder à cette page.");
}
?>
