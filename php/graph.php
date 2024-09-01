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

// Convertir les données pour l'utilisation avec Chart.js
$dates = json_encode(array_keys($logs_par_jour));
$log_counts = json_encode(array_values($logs_par_jour));

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courbe des logs</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="logsChart" width="400" height="200"></canvas>
    <script>
        // Récupération des données PHP
        var dates = <?php echo $dates; ?>;
        var logCounts = <?php echo $log_counts; ?>;

        var ctx = document.getElementById('logsChart').getContext('2d');
        var logsChart = new Chart(ctx, {
            type: 'line', // Type de graphique
            data: {
                labels: dates, // Les dates comme labels
                datasets: [{
                    label: 'Nombre de logs par jour',
                    data: logCounts,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    fill: true, // Remplissage sous la courbe
                    tension: 0.3 // Lissage de la courbe
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Nombre de logs'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
