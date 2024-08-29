<?php
session_start();

// Enable error display for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('Database.php'); // Make sure this file initializes a PDO connection named $dbh

if (isset($_SESSION['firstname']) && isset($_SESSION['id'])) {
    // If the user is logged in and the ID is set
    $userId = $_SESSION['id'];  // Use 'id' consistently

    try {
        // Prepare a query to retrieve the user's role and verification status
        $stmt = $dbh->prepare('SELECT role, verified FROM users WHERE id = :id');
        $stmt->execute(['id' => $userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if user exists
        if ($user) {
            // If the user is not verified, redirect them to the specified link
            if (!$user['verified']) {
                header('location: https://funfair.ovh');
                exit();
            }
            
            // If the user is admin, allow access
            if ($user['role'] == 'admin') {
                // Admin-specific logic or page content can be placed here
                echo "Welcome, Admin!";
            } else {
                // If the user is not an admin but is verified, handle accordingly
                echo "You are verified but not an admin.";
            }
        } else {
            // If user does not exist in the database, redirect to the specified link
            header('location: https://funfair.ovh');
            exit();
        }
    } catch (PDOException $e) {
        // In case of SQL error, display the error
        echo 'Erreur lors de la requête SQL : ' . $e->getMessage();
    }

} else {
    // If the user is not logged in or the ID is not set
    header('location: https://funfair.ovh');
    exit();
}
?>
