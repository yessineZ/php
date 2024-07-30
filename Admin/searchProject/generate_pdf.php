<?php

require('../fpdf/fpdf.php'); 
include './Functions.php';

session_start();

if(!isset($_SESSION['EmailAdmin'])) {
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

    
        $this->SetY(40); 

    
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


        $this->SetFillColor(200, 220, 255);
        foreach ($header as $col) {
            $this->Cell(30, 10, $col, 1, 0, 'C', true);
        }
        $this->Ln();


        $this->SetFont('Arial', '', 10);
        $this->SetFillColor(255, 255, 255);
        foreach ($references as $row) {
            $this->Cell(30, $cellHeight, getUser($row["id_client"])["username"], 1, 0, 'L', true);
            $this->Cell(30, $cellHeight, getClient1($row["Client_id"])["name"], 1, 0, 'L', true);
            $this->Cell(30, $cellHeight, $row["description"], 1, 0, 'L', true);

            
            $imagePath = '../../images/' . $row['logo'];
            if (file_exists($imagePath) && in_array(mime_content_type($imagePath), ['image/jpeg', 'image/png', 'image/gif'])) {
                $x = $this->GetX();
                $y = $this->GetY();
                $this->Cell(30, $cellHeight, '', 1, 0, 'L', true); 
                $this->Image($imagePath, $x + 1, $y + 1, 18, 18);
            } else {
                $this->Cell(30, $cellHeight, 'No Image', 1, 0, 'L', true);
            }

            $this->Cell(30, $cellHeight, $row["link"], 1, 0, 'L', true);
            $this->Cell(30, $cellHeight, gettType($row["id_type"])["name"], 1, 0, 'L', true);
            $this->Cell(30, $cellHeight, getPays($row["pays"])["name"], 1, 0, 'L', true);
            $this->Cell(30, $cellHeight, $row["annee"], 1, 0, 'L', true);
            $this->Cell(30, $cellHeight, $row["creator"], 1, 0, 'L', true);
            $this->Ln();
        }
    }
}

$pdf = new PDF();
$pdf->AddPage();
$header = array('User', 'Client', 'Description', 'Logo', 'Link', 'Type', 'Country', 'Year', 'Creator');
$pdf->ReferenceTable($header, $references);
$pdf->Output('D', 'References_List.pdf');

?>