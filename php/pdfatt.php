<?php
session_start();
include 'Database.php';

$sql = "SELECT id, nom, type, prix, agemin, taillemin, idstripe FROM attractions";
try {
    $stmt = $dbh->query($sql);
    $attractions = $stmt->fetchAll(PDO::FETCH_ASSOC); 
} catch (PDOException $e) {
    die("Erreur lors de la récupération des données : " . $e->getMessage());
}


require('fpdf.php');

class PDF extends FPDF
{
  
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Informations sur les Attractions', 0, 1, 'C');
        $this->Ln(10);
    }

  
    function attractionTable($header, $data)
    {
       
        $w = array(10, 50, 30, 20, 25, 25, 40);
        
      
        foreach ($header as $i => $col) {
            $this->Cell($w[$i], 7, $col, 1, 0, 'C');
        }
        $this->Ln();

       
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row['id'], 1);
            $this->Cell($w[1], 6, $row['nom'], 1);
            $this->Cell($w[2], 6, $row['type'], 1);
            $this->Cell($w[3], 6, $row['prix'], 1);
            $this->Cell($w[4], 6, $row['agemin'], 1);
            $this->Cell($w[5], 6, $row['taillemin'], 1);
            $this->Cell($w[6], 6, $row['idstripe'], 1);
            $this->Ln();
        }
    }
}

$pdf = new PDF();
$pdf->AddPage();
$header = array('ID', 'Nom', 'Type', 'Prix', 'Âge Minimum', 'Taille Minimum', 'ID Stripe');
$pdf->attractionTable($header, $attractions);
$pdf->Output('D', 'attractions_data.pdf');
exit;
?>
