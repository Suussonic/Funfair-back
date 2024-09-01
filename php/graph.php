<?php
include_once('Database.php');

// Requête SQL pour regrouper les actions par jour
$sql = "SELECT DATE(date) as log_date, COUNT(*) as log_count FROM logs GROUP BY log_date";

try {
    // Préparation et exécution de la requête
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    // Récupération des résultats
    $logs_par_jour = [];
    while ($row = $stmt->fetch()) {
        $logs_par_jour[$row['log_date']] = $row['log_count'];
    }

} catch (PDOException $e) {
    // Gestion des erreurs SQL
    error_log('Erreur SQL : ' . $e->getMessage());
    die('Erreur lors de la récupération des données. Veuillez réessayer plus tard.');
}
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
