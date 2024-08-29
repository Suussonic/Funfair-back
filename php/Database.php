<?php

$user = 'root';
$password = 'root';
$options = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];

try {
    $dbh = new PDO('mysql:host=localhost;dbname=pa', $user, $password, $options);
} catch (PDOException $e) {
}
