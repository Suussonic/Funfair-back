<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include_once('Database.php');

// Include the FPDF library
require('../fpdf186/fpdf.php');

// Retrieve all information from the calculations table
$sql = "SELECT id, q, r FROM captcha";

try {
    $stmt = $dbh->query($sql);
    $captcha = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}

// Generate the PDF
class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'captcha Information', 0, 1, 'C');
        $this->Ln(10);
    }

    function captchaTable($header, $data)
    {
        // Column widths
        $w = array(10, 50, 30);
        // Headers
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
        }
        $this->Ln();
        // Data
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row['id'], 1);
            $this->Cell($w[1], 6, $row['q'], 1);
            $this->Cell($w[2], 6, $row['r'], 1);
            $this->Ln();
        }
    }
}

$pdf = new PDF();
$pdf->AddPage();
$header = array('ID', 'Q', 'R');

$pdf->captchaTable($header, $captcha);
$pdf->Output('D', 'captcha_data.pdf');
exit;
?>
