<?php
$user = 'root';
$password = 'root';
$options = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
    PDO::ATTR_EMULATE_PREPARES => false, 
];

try {
    $dbh = new PDO('mysql:host=localhost;dbname=pa', $user, $password, $options);
} catch (PDOException $e) {
    error_log('Erreur de connexion à la base de données : ' . $e->getMessage());
    die('Erreur de connexion à la base de données. Veuillez réessayer plus tard.');
}
?>
