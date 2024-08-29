<?php
// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclure le fichier de connexion à la base de données
include __DIR__ . '/Database.php'; // Chemin absolu pour inclure db.php

if (!$dbh) {
    die("Erreur de connexion : " . var_dump($dbh->errorInfo()));
}
?>