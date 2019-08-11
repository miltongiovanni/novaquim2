<? 
//define('FPDF_FONTPATH','./');
require('../fpdf.php');
$pdf=new FPDF();
$pdf->AddFont('ARIALN','','ARIALN.php');
$pdf->AddPage();
$pdf->SetFont('ARIALN','',35);
$pdf->Cell(0,10,'Enjoy new fonts with FPDF!');
$pdf->SetFont('ARIALN','',35);
$pdf->Cell(0,10,'Enjoy new fonts with FPDF!');
$pdf->Output();
?>
