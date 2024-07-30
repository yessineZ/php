<?php

require('../fpdf/fpdf.php'); 
include './Functions.php';

session_start();

if (!isset($_SESSION['EmailAdmin'])) {
    header('Location: ../login.php');
    exit;
}

$currentClient = $_POST['client'];
$searchTerm = $_POST['search_term'];

$references = GetReferenceClient($currentClient, $searchTerm);

class PDF extends FPDF
{
    function Header()
    {
        $logoPath = 'mtd1.png'; 
        if (file_exists($logoPath)) {
            $this->Image($logoPath, 10, 10, 30); 
        }

        $this->SetY(50); 

        $this->SetTextColor(255, 0, 0); 
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'References List', 0, 1, 'C');
        $this->Ln(10); 
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    function ReferenceTable($header, $references)
    {
        $this->SetFont('Arial', 'B', 10);
        $cellHeight = 20; 

        // Define column widths
        $widths = [
            'User' => 20, 
            'Client' => 20, 
            'Description' => 30, 
            'Logo' => 30, 
            'Link' => 30, 
            'Type' => 20, 
            'Country' => 20, 
            'Year' => 10, 
            'Creator' => 20
        ];

        // Table header
        $this->SetFillColor(200, 220, 255);
        foreach ($header as $col) {
            $this->Cell($widths[$col], 10, $col, 1, 0, 'C', true);
        }
        $this->Ln();

        // Table body
        $this->SetFont('Arial', '', 10);
        $this->SetFillColor(255, 255, 255);
        foreach ($references as $row) {
            $this->Cell($widths['User'], $cellHeight, getUser($row["id_client"])["username"], 1, 0, 'L', true);
            $this->Cell($widths['Client'], $cellHeight, getClient1($row["Client_id"])["name"], 1, 0, 'L', true);
            $this->Cell($widths['Description'], $cellHeight, $row["description"], 1, 0, 'L', true);

            // Check if the image exists and is a supported type
            $imagePath = '../../images/' . $row['logo'];
            if (file_exists($imagePath) && in_array(mime_content_type($imagePath), ['image/jpeg', 'image/png', 'image/gif'])) {
                $x = $this->GetX();
                $y = $this->GetY();
                $this->Cell($widths['Logo'], $cellHeight, '', 1, 0, 'L', true); // Placeholder cell for image
                $this->Image($imagePath, $x + 1, $y + 1, 18, 18);
            } else {
                $this->Cell($widths['Logo'], $cellHeight, 'No Image', 1, 0, 'L', true);
            }

            $this->Cell($widths['Link'], $cellHeight, $row["link"], 1, 0, 'L', true);
            $this->Cell($widths['Type'], $cellHeight, gettType($row["id_type"])["name"], 1, 0, 'L', true);
            $this->Cell($widths['Country'], $cellHeight, getPays($row["pays"])["name"], 1, 0, 'L', true);
            $this->Cell($widths['Year'], $cellHeight, getYear($row["annee"])["year"], 1, 0, 'L', true); // Calling getYear function
            $this->Cell($widths['Creator'], $cellHeight, $row["creator"], 1, 0, 'L', true);
            $this->Ln();
        }
    }
}

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="References_List.pdf"');


$pdf = new PDF();
$pdf->AddPage();
$header = array('User', 'Client', 'Description', 'Logo', 'Link', 'Type', 'Country', 'Year', 'Creator');
$pdf->ReferenceTable($header, $references);
$pdf->Output('D', 'References_List.pdf');

?>