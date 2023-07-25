<?php
require_once("fpdf/fpdf.php");
 
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Esto es un codigo QR xD');
$pdf->Image('http://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=SoyUnDios&.png',20,20,100,100);
$pdf->Output();
?>