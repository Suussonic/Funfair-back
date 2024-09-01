<?php
include_once('Database.php');

if (!$dbh) {
    die('Connexion à la base de données échouée.');
}

try {

    $query = "SELECT action, ip, date, firstname, email FROM logs ORDER BY date DESC";
    $stmt = $dbh->query($query);

    if (!$stmt) {
        die("Erreur dans la requête SQL : " . var_dump($dbh->errorInfo()));
    }

    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);


    echo "<table border='1'>";
    echo "<tr><th>Action</th><th>IP</th><th>Date</th><th>Prénom</th><th>Email</th></tr>";
    foreach ($logs as $log) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($log['action']) . "</td>";
        echo "<td>" . htmlspecialchars($log['ip']) . "</td>";
        echo "<td>" . htmlspecialchars($log['date']) . "</td>";
        echo "<td>" . htmlspecialchars($log['firstname']) . "</td>";
        echo "<td>" . htmlspecialchars($log['email']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} catch (PDOException $e) {
    die("Erreur lors de la récupération des logs : " . $e->getMessage());
}
?>
