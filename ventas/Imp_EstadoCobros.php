<?php
include "../includes/valAcc.php";
require '../includes/fpdf.php';
function cargarClases($classname)
{
	require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$RecCajaOperador = new RecCajaOperaciones();
$facturas = $RecCajaOperador->getTableRecCajas();
//$remision=$_POST['remision'];
$pdf=new FPDF('L','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(10, 10, 10);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(8,3.5,'Fact', 1,0,'C');
$pdf->Cell(17,3.5,'Fch Vmto', 1,0,'C');
$pdf->Cell(70,3.5,'Cliente', 1,0,'C');
$pdf->Cell(45,3.5,utf8_decode('Dirección Cliente'), 1,0,'C');
$pdf->Cell(33,3.5,'Contacto', 1,0,'C');
$pdf->Cell(13,3.5,utf8_decode('Teléfono'), 1,0,'C');
$pdf->Cell(17,3.5,'Celular', 1,0,'C');
$pdf->Cell(17,3.5,'Saldo', 1,0,'C');
$pdf->Cell(15,3.5,'Fch Canc', 1,0,'C');
$pdf->Cell(15,3.5,'Valor', 1,0,'C');
$pdf->Cell(10,3.5,'F Pago', 1,0,'C');
$pdf->SetFont('Arial','',8);
for($i=0; $i<count($facturas); $i++)
{
	$pdf->Ln(3.5);
	$pdf->Cell(8,3.5,$facturas[$i]['idFactura'], 1,0,'C');
	$pdf->Cell(17,3.5,$facturas[$i]['fechaVenc'], 1,0,'C');
	$pdf->Cell(70,3.5,utf8_decode($facturas[$i]['nomCliente']), 1,0,'L');
	$pdf->Cell(45,3.5,utf8_decode($facturas[$i]['dirCliente']), 1,0,'L');
	$pdf->Cell(33,3.5,utf8_decode($facturas[$i]['contactoCliente']), 1,0,'L');
	$pdf->Cell(13,3.5,$facturas[$i]['telCliente'], 1,0,'C');
	$pdf->Cell(17,3.5,$facturas[$i]['celCliente'], 1,0,'C');
	$pdf->Cell(17,3.5,'$ '.$facturas[$i]['saldo'], 1,0,'R');
	$pdf->Cell(15,3.5,'', 1,0,'R');
	$pdf->Cell(15,3.5,'', 1,0,'R');
	$pdf->Cell(10,3.5,'', 1,0,'R');
}
$pdf->SetXY(20,-34);
$pdf->Output();
?>
