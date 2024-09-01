<?php
session_start();
include_once('Database.php');


require('../fpdf186/fpdf.php');


$sql = "SELECT id, firstname, lastname, email, gender, role FROM users";

try {
    $stmt = $dbh->query($sql);
    $users = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erreur lors de la récupération des données : " . $e->getMessage());
}


class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'User Information', 0, 1, 'C');
        $this->Ln(10);
    }

    function UserTable($header, $data)
    {
       
        $w = array(10, 30, 30, 50, 20, 30);
       
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
        }
        $this->Ln();
       
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row['id'], 1);
            $this->Cell($w[1], 6, $row['firstname'], 1);
            $this->Cell($w[2], 6, $row['lastname'], 1);
            $this->Cell($w[3], 6, $row['email'], 1);
            $this->Cell($w[4], 6, isset($row['gender']) ? $row['gender'] : '-', 1); 
            $this->Cell($w[5], 6, $row['role'], 1);
            $this->Ln();
        }
    }
}

$pdf = new PDF();
$pdf->AddPage();
$header = array('ID', 'Firstname', 'Lastname', 'Email', 'Gender', 'Role');

$pdf->UserTable($header, $users);
$pdf->Output('D', 'user_data.pdf');
exit;
?>
