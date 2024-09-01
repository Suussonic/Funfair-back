<?php
// Configuration de la base de données
$servername = "localhost";
$username = "root";  // Remplacez par votre nom d'utilisateur
$password = "";  // Remplacez par votre mot de passe
$dbname = "pa";  // Le nom de votre base de données

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Requête SQL pour regrouper les actions par jour
$sql = "SELECT DATE(date) as log_date, COUNT(*) as log_count FROM logs GROUP BY log_date";
$result = $conn->query($sql);

// Tableau pour stocker les données des logs
$logs_par_jour = [];

if ($result->num_rows > 0) {
    // Remplir le tableau avec les résultats de la requête
    while($row = $result->fetch_assoc()) {
        $logs_par_jour[$row['log_date']] = $row['log_count'];
    }
} else {
    echo "0 résultats";
}

// Fermer la connexion
$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histogramme des logs</title>
    <style>
        .bar {
            width: 20px;
            background-color: #4CAF50;
            margin: 2px;
            display: inline-block;
        }
        .chart {
            display: flex;
            align-items: flex-end;
            height: 200px;
            margin: 20px;
        }
        .label {
            text-align: center;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="chart">
        <?php foreach ($logs_par_jour as $jour => $nombre_logs): ?>
            <div class="bar" style="height: <?= $nombre_logs * 10 ?>px;" title="<?= $nombre_logs ?> logs"></div>
        <?php endforeach; ?>
    </div>
    <div class="labels">
        <?php foreach ($logs_par_jour as $jour => $nombre_logs): ?>
            <div class="label"><?= $jour ?></div>
        <?php endforeach; ?>
    </div>
</body>
</html>
