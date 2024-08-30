<?php
include('Database.php');

function insert_logs($action) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    global $dbh;

    if (!$dbh) {
        die('Connexion à la base de données échouée.');
    }

    $ip = $_SERVER['REMOTE_ADDR'];
    $date_now = date('Y-m-d H:i:s');
    $firstname = isset($_SESSION['firstname']) ? $_SESSION['firstname'] : '';
    $email = isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : '';

    $logs_req = 'INSERT INTO logs (action, ip, date, firstname, email) VALUES (:action, :ip, :date, :firstname, :email)';
    $logs_query = $dbh->prepare($logs_req);

    try {
        $logs_query->execute([
            ':action' => $action,
            ':ip' => $ip,
            ':date' => $date_now,
            ':firstname' => $firstname,
            ':email' => $email
        ]);
    } catch (PDOException $e) {
        die('Erreur lors de l\'insertion du log : ' . $e->getMessage());
    }
}
?>
