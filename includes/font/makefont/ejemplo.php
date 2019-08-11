<? 
define('FPDF_FONTPATH','./');
require('../fpdf.php');
$pdf=new FPDF();
$pdf->AddFont('Baker','','Baker.php');
$pdf->AddPage();
$pdf->SetFont('Baker','',35);
$pdf->Cell(0,10,'Enjoy new fonts with FPDF!');
$pdf->Output();
?>
