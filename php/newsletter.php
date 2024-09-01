<?php
include 'Database.php';
include 'mailer.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $sql = "SELECT email FROM users";
    
    try {
        $stmt = $dbh->query($sql);

        if ($stmt->rowCount() > 0) {
            $errors = [];
            $success = true;

            // Envoyer un email à chaque utilisateur
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $to = $row['email'];
                $subject = 'Important Notification';
                $messageBody = 'Hello, this is an important notification for all users!';

                if (!sendMail($dbh, $to, $subject, $messageBody)) {
                    $errors[] = "Failed to send email to: $to";
                    $success = false;
                }
            }

            // Afficher les messages
            if ($success && empty($errors)) {
                $message = "Emails sent successfully to all users.";
            } else {
                $message = implode("<br>", $errors);
            }
        } else {
            $message = "No users found in the database.";
        }
    } catch (PDOException $e) {
        $message = "Query failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Envoyer Newsletter</title>
</head>
<body>
    <h1>Envoyer la Newsletter</h1>

    <!-- Formulaire avec un bouton -->
    <form method="POST" action="">
        <button type="submit">Envoyer aux utilisateurs</button>
    </form>

    <?php
    // Afficher le message après soumission du formulaire
    if (isset($message)) {
        echo "<p>$message</p>";
    }
    ?>
</body>
</html>
