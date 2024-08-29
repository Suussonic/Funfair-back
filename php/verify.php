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

    if (isAdmin($pdo, $userId)) {
        // L'utilisateur est admin, afficher le contenu de la page
        echo "Bienvenue, administrateur!";
        // Ici, tu peux ajouter le contenu de ta page pour les admins
    } else {
        // L'utilisateur n'est pas admin, afficher la popup
        echo '
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Accès Refusé</title>
            <style>
                .popup {
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
                    padding: 20px;
                    border-radius: 5px;
                    text-align: center;
                }
                .popup button {
                    margin-top: 10px;
                }
            </style>
        </head>
        <body>
            <div class="popup">
                <div class="popup-content">
                    <p>Vous n'avez pas l'autorisation pour accéder à cette page.</p>
                    <button onclick="window.location.href=\'https://funfair.ovh\'">Retour à l\'accueil</button>
                </div>
            </div>
        </body>
        </html>';
    }

} else {
    // L'utilisateur n'est pas connecté, afficher la popup
    echo '
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Accès Refusé</title>
        <style>
            .popup {
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
                padding: 20px;
                border-radius: 5px;
                text-align: center;
            }
            .popup button {
                margin-top: 10px;
            }
        </style>
    </head>
    <body>
        <div class="popup">
            <div class="popup-content">
                <p>Vous devez être connecté pour accéder à cette page.</p>
                <button onclick="window.location.href=\'https://funfair.ovh\'">Retour à l\'accueil</button>
            </div>
        </div>
    </body>
    </html>';
}
?>
