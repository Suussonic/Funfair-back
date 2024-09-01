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

// Convertir les données pour l'utilisation en JavaScript
$dates = json_encode(array_keys($logs_par_jour));
$log_counts = json_encode(array_values($logs_par_jour));
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courbe des logs</title>
    <style>
        canvas {
            border: 1px solid #000;
        }
    </style>
</head>
<body>
    <canvas id="logsChart" width="600" height="400"></canvas>
    <script>
        // Récupération des données PHP
        var dates = <?php echo $dates; ?>;
        var logCounts = <?php echo $log_counts; ?>;

        // Récupérer le canevas
        var canvas = document.getElementById('logsChart');
        var ctx = canvas.getContext('2d');

        // Dimensions du canevas
        var width = canvas.width;
        var height = canvas.height;
        var padding = 40; // Pour l'espace entre la courbe et les bords

        // Calcul des espacements entre les points
        var maxLogCount = Math.max(...logCounts);
        var xStep = (width - 2 * padding) / (dates.length - 1);
        var yRatio = (height - 2 * padding) / maxLogCount;

        // Dessiner les axes
        ctx.beginPath();
        ctx.moveTo(padding, padding);
        ctx.lineTo(padding, height - padding);
        ctx.lineTo(width - padding, height - padding);
        ctx.stroke();

        // Dessiner la courbe
        ctx.beginPath();
        ctx.moveTo(padding, height - padding - logCounts[0] * yRatio);
        for (var i = 1; i < dates.length; i++) {
            var x = padding + i * xStep;
            var y = height - padding - logCounts[i] * yRatio;
            ctx.lineTo(x, y);
        }
        ctx.strokeStyle = 'blue';
        ctx.stroke();

        // Ajouter les points sur la courbe
        for (var i = 0; i < dates.length; i++) {
            var x = padding + i * xStep;
            var y = height - padding - logCounts[i] * yRatio;
            ctx.beginPath();
            ctx.arc(x, y, 3, 0, 2 * Math.PI);
            ctx.fillStyle = 'red';
            ctx.fill();
        }

        // Ajouter les labels
        ctx.fillStyle = 'black';
        ctx.font = '12px Arial';
        for (var i = 0; i < dates.length; i++) {
            var x = padding + i * xStep;
            ctx.fillText(dates[i], x - 20, height - padding + 20);
        }
    </script>
</body>
</html>
