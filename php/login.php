<?php
error_reporting(E_ALL); 
ini_set("display_errors", 1);
include_once('models/Database.php');

$errorInfo = false;

if (!$dbh) {
    die('Connexion à la base de données échouée.');
}


if (isset($_POST['email']) && isset($_POST['password'])) {
   
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

  
    $loginSql = 'SELECT * FROM users WHERE email = :email';

    try {
        $preparedLoginRequest = $dbh->prepare($loginSql);
        $preparedLoginRequest->execute(['email' => $email]);
    } catch (PDOException $e) {
        die('Erreur lors de l\'exécution de la requête SQL : ' . $e->getMessage());
    }

  
    $user = $preparedLoginRequest->fetch(PDO::FETCH_ASSOC);

  
    if ($user && password_verify($password, $user['password'])) {
        session_start();
     
        $_SESSION['id'] = $user['id'];
        $_SESSION['firstname'] = $user['firstname'];
        $_SESSION['lastname'] = $user['lastname'];
        $_SESSION['user'] = $user;

        header('location:/');
        exit;
    } else {
        $errorInfo = true;
    }
}

require 'views/registration/login.view.php';
?>
