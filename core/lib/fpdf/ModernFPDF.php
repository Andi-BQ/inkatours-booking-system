<?php
require_once('fpdf.php');

class ModernFPDF extends FPDF {
    private $companyName = 'InkaTours';
    private $companyAddress = 'Cusco, Peru';
    private $companyPhone = '+51 987 654 321';
    private $companyEmail = 'contacto@inkatours.com';

    // Page header
    function Header() {
        // Text Logo
        $this->SetFont('Helvetica', 'B', 24);
        $this->SetTextColor(34, 43, 54);
        $this->Cell(40, 10, 'InkaTours', 0, 0, 'L');
        
        // Company details
        $this->SetFont('Helvetica', '', 9);
        $this->SetTextColor(85, 85, 85);
        $this->Cell(0, 5, utf8_decode($this->companyAddress), 0, 1, 'R');
        $this->Cell(0, 5, $this->companyPhone, 0, 1, 'R');
        $this->Cell(0, 5, $this->companyEmail, 0, 1, 'R');

        // Line break
        $this->Ln(15);

        // Header line
        $this->SetFillColor(230, 81, 0); // Naranja InkaTours
        $this->Rect(10, 35, 190, 1, 'F');
        $this->Ln(5);
    }

    // Page footer
    function Footer() {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        
        // Footer line
        $this->SetFillColor(221, 221, 221);
        $this->Rect(10, $this->GetY() - 2, 190, 0.5, 'F');
        
        $this->SetFont('Helvetica', 'I', 8);
        $this->SetTextColor(128);
        
        // Page number
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
        
        $this->SetX(10);
        $this->Cell(0, 10, utf8_decode('Gracias por elegir InkaTours'), 0, 0, 'L');
        
        $this->SetX(-50);
        $this->Cell(0, 10, date('d/m/Y H:i'), 0, 0, 'R');
    }

    // Title
    function ChapterTitle($label) {
        $this->SetFont('Helvetica', 'B', 16);
        $this->SetTextColor(34, 43, 54);
        $this->Cell(0, 10, utf8_decode($label), 0, 1, 'L');
        $this->Ln(4);
    }
    
    // Section Title
    function SectionTitle($label) {
        $this->SetFont('Helvetica', 'B', 12);
        $this->SetTextColor(52, 73, 94);
        $this->Cell(0, 8, utf8_decode($label), 0, 1, 'L');
        $this->SetDrawColor(221, 221, 221);
        $this->Line($this->GetX(), $this->GetY(), $this->GetX() + 190, $this->GetY());
        $this->Ln(4);
    }

    // Body content
    function BodyText($text) {
        $this->SetFont('Helvetica', '', 11);
        $this->SetTextColor(85, 85, 85);
        $this->MultiCell(0, 6, utf8_decode($text));
        $this->Ln();
    }
    
    // Key-Value pair info
    function InfoCell($label, $value) {
        $this->SetFont('Helvetica', 'B', 11);
        $this->SetTextColor(34, 43, 54);
        $this->Cell(50, 7, utf8_decode($label), 0, 0);
        
        $this->SetFont('Helvetica', '', 11);
        $this->SetTextColor(85, 85, 85);
        $this->Cell(0, 7, utf8_decode($value), 0, 1);
    }

    // Participants table
    function ParticipantsTable($header, $data) {
        $this->Ln(2);
        $this->SetFont('Helvetica', 'B', 11);
        $this->SetFillColor(242, 242, 242);
        $this->SetTextColor(34, 43, 54);
        $w = array(15, 95, 80); // Anchos de las columnas
        for($i=0; $i<count($header); $i++) {
            $this->Cell($w[$i], 8, utf8_decode($header[$i]), 1, 0, 'C', true);
        }
        $this->Ln();
        
        $this->SetFont('Helvetica', '', 10);
        $this->SetTextColor(85, 85, 85);
        $this->SetFillColor(255);
        $fill = false;
        $count = 1;
        foreach($data as $row) {
            $this->Cell($w[0], 7, $count++, 'LR', 0, 'C', $fill);
            $this->Cell($w[1], 7, utf8_decode($row['nombre']), 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 7, utf8_decode(ucfirst($row['tipo_documento'])), 'LR', 0, 'L', $fill);
            $this->Ln();
            $fill = !$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
        $this->Ln(10);
    }

    // Totals section
    function Totals($subtotal, $paid, $pending, $currency) {
        $this->SetFont('Helvetica', '', 11);
        $this->SetTextColor(34, 43, 54);

        $this->Cell(130, 8, 'Subtotal:', 0, 0, 'R');
        $this->Cell(60, 8, '$' . number_format($subtotal, 2) . ' ' . $currency, 0, 1, 'R');

        $this->Cell(130, 8, 'Pagado (50%):', 0, 0, 'R');
        $this->Cell(60, 8, '$' . number_format($paid, 2) . ' ' . $currency, 0, 1, 'R');

        $this->SetFont('Helvetica', 'B', 12);
        $this->SetFillColor(242, 242, 242);
        $this->Cell(130, 10, 'Monto Pendiente:', 'T', 0, 'R', true);
        $this->Cell(60, 10, '$' . number_format($pending, 2) . ' ' . $currency, 'T', 1, 'R', true);
        $this->Ln(5);
    }
    
    function FinalTotal($total, $currency) {
        $this->Ln(5);
        $this->SetFont('Helvetica', 'B', 14);
        $this->SetFillColor(230, 81, 0);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(130, 12, 'TOTAL PAGADO:', 0, 0, 'R', true);
        $this->Cell(60, 12, '$' . number_format($total, 2) . ' ' . $currency, 0, 1, 'R', true);
        $this->Ln(10);
    }
}
?>