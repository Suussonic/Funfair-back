<?php
session_start();
include 'Database.php';


$sql = "SELECT id, attractionid, montant, quantity, date, heure, email FROM reservations";
try {
    $stmt = $dbh->query($sql);
    $reservations = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erreur lors de la récupération des données : " . $e->getMessage());
}

// Générer le PDF
require('fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Informations sur les Réservations', 0, 1, 'C');
        $this->Ln(10);
    }

    function reservationTable($header, $data)
    {
       
        $w = array(10, 30, 20, 15, 30, 20, 45);

        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
        }
        $this->Ln();
    
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row['id'], 1);
            $this->Cell($w[1], 6, $row['attractionid'], 1);
            $this->Cell($w[2], 6, $row['montant'], 1);
            $this->Cell($w[3], 6, $row['quantity'], 1);
            $this->Cell($w[4], 6, $row['date'], 1);
            $this->Cell($w[5], 6, $row['heure'], 1);
            $this->Cell($w[6], 6, $row['email'], 1);
            $this->Ln();
        }
    }
}

$pdf = new PDF();
$pdf->AddPage();
$header = array('ID', 'Attraction ID', 'Montant', 'Quantité', 'Date', 'Heure', 'Email');

$pdf->reservationTable($header, $reservations);
$pdf->Output('D', 'reservations_data.pdf');
exit;
?>
