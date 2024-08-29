<?php
session_start();

// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('Database.php'); // Assurez-vous que ce fichier initialise une connexion PDO nommée $pdo

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
            body {
                margin: 0;
                font-family: Arial, sans-serif;
            }
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
                overflow: hidden;
            }
            .popup-content {
                background: #fff;
                padding: 20px;
                border-radius: 8px;
                text-align: center;
                width: 90%;
                max-width: 400px;
            }
            .popup h1 {
                margin-top: 0;
                font-size: 18px;
                color: #333;
            }
            .popup p {
                color: #666;
                margin: 10px 0;
            }
            .popup button {
                background-color: #007bff;
                border: none;
                color: white;
                padding: 10px 20px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin-top: 20px;
                cursor: pointer;
                border-radius: 5px;
                transition: background-color 0.3s;
            }
            .popup button:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>
        <div class="popup-overlay">
            <div class="popup-content">
                <h1>Accès Refusé</h1>
                <p>' . htmlspecialchars($message) . '</p>
                <button onclick="window.location.href=\'https://funfair.ovh\'">Retour à l\'accueil</button>
            </div>
        </div>
    </body>
    </html>';
}

// Débogage : vérifier le contenu de la session
var_dump($_SESSION);

if (isset($_SESSION['firstname']) && isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];  // Utiliser 'id' pour récupérer l'identifiant utilisateur

    try {
        // Préparer une requête pour récupérer le rôle de l'utilisateur
        $stmt = $pdo->prepare('SELECT role FROM users WHERE id = :id');
        $stmt->execute(['id' => $userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Débogage : vérifier le rôle retourné
        var_dump($user);

        if ($user && $user['role'] === 'admin') {
            // Si l'utilisateur est un admin, envoyer un message dans la console
            echo '<script>console.log("Tu es bien admin");</script>';
        } else {
            // Si l'utilisateur n'est pas admin, afficher la popup
            displayPopup("Vous n'avez pas l'autorisation pour accéder à cette page.");
            exit; // S'assurer que rien d'autre n'est exécuté
        }

    } catch (PDOException $e) {
        // En cas d'erreur SQL, afficher l'erreur
        echo 'Erreur lors de la requête SQL : ' . $e->getMessage();
        exit; // S'assurer que rien d'autre n'est exécuté en cas d'erreur
    }

} else {
    // Si l'utilisateur n'est pas connecté ou si l'ID n'est pas défini, afficher la popup
    displayPopup("Vous devez être connecté pour accéder à cette page.");
    exit; // S'assurer que rien d'autre n'est exécuté
}
?>
