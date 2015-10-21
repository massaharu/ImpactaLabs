<?php
require('WriteHTML.php');

$pdf=new PDF_HTML();
$pdf->AddPage();
$pdf->SetFont('Arial');
$pdf->WriteHtml($html);
$pdf->Output();
?>