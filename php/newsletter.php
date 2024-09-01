<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'Database.php';
include 'mailer.php';

$messageBody = 'Hello, this is an important notification for all users!'; // Valeur par défaut

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Récupérer le contenu personnalisé du message s'il est envoyé
    if (!empty($_POST['messageBody'])) {
        $messageBody = $_POST['messageBody'];
    }

    $sql = "SELECT email FROM users";
    
    try {
        $stmt = $dbh->query($sql);

        if ($stmt->rowCount() > 0) {
            $errors = [];
            $success = true;

            // Envoyer un email à chaque utilisateur
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $to = $row['email'];
                $subject = 'Funfair Newsletter';

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
    <link rel="stylesheet" href="../css/news.css">
    <title>Envoyer Newsletter</title>
</head>
<body>
    <h1>Envoyer la Newsletter</h1>

    <!-- Formulaire pour personnaliser le message de la newsletter -->
    <form method="POST" action="">
        <label for="messageBody">Message de la Newsletter:</label><br>
        <textarea id="messageBody" name="messageBody" rows="10" cols="50"><?php echo htmlspecialchars($messageBody); ?></textarea><br><br>
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
