<?php
session_start();
require('../includes/fpdf.php');
$idRemision=$_POST['idRemision'];
function cargarClases($classname)
{
	require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$remisionOperador = new RemisionesOperaciones();
$remision = $remisionOperador->getRemisionById($idRemision);
$detRemisionOperador = new DetRemisionesOperaciones();
$detalle = $detRemisionOperador->getTableDetRemisiones($idRemision);

$pdf=new FPDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(40, 20, 20);
$pdf->SetXY(15,10);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(18,4,iconv('UTF-8', 'windows-1252', 'SALIDA:'),0 , 0, 'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(11,4,$remision['idRemision']);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(15,4,'CLIENTE:',0, 0, 'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(80,4,iconv('UTF-8', 'windows-1252', $remision['cliente']),0,0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(12,4,'FECHA:',0 , 0, 'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(20,4,$remision['fechaRemision'],0,0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(12,4,'TOTAL:',0 , 0, 'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(10,4, '$ '.number_format($remision['valor']),0,1);
$pdf->SetMargins(20, 30, 20);
$pdf->SetXY(20,22);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(10,4,'ITEM', 1,0,'C');
$pdf->Cell(25,4,iconv('UTF-8', 'windows-1252', 'CÓDIGO'), 1,0,'C');
$pdf->Cell(110,4,'PRODUCTO', 1,0,'C');
$pdf->Cell(20,4,'CANTIDAD', 1,0,'C');
$pdf->Cell(20,4,'PRECIO', 1,0,'C');
$pdf->SetFont('Arial','',7);
$pdf->SetXY(20,26);
for($i=0; $i<count($detalle); $i++)
{
	$codprod=$detalle[$i]['codProducto'];
	$prod=$detalle[$i]['producto'];
	$cant=$detalle[$i]['cantProducto'];
	$precio=$detalle[$i]['precioProducto'];
	$pdf->Cell(10,3,$i+1,'L',0,'C');
	$pdf->Cell(25,3,$codprod,'L',0,'C');
	$pdf->Cell(110,3,iconv('UTF-8', 'windows-1252', $prod),'LR',0,'L');
	$pdf->Cell(20,3,$cant,'R',0,'C');
	$pdf->Cell(20,3,$precio,'R',0,'C');
	$pdf->Ln(2.3);
}
$i++;
while ($i<41)
	{
		$pdf->Cell(10,3,'','L',0,'C');
		$pdf->Cell(25,3,'','L',0,'C');
		$pdf->Cell(110,3,'','LR',0,'L');
		$pdf->Cell(20,3, '','R',0,'C');
		$pdf->Cell(20,3, '','R',0,'C');
		$pdf->Ln(2.3);
		$i++;
	}
$pdf->Cell(10,3,'','LB',0,'C');
$pdf->Cell(25,3,'','LB',0,'C');
$pdf->Cell(130,3,'','LBR',0,'L');
$pdf->Cell(20,3, '','RB',0,'C');
$pdf->SetFont('Arial','B',7);
$pdf->Ln(2.5);
$pdf->Cell(25,4,'ACEPTADA',0 , 0, 'L');
$pdf->Ln(2.5);
$pdf->SetFont('Arial','',7);
$pdf->Cell(80,4,'FIRMA:____________________________________',0,0, 'R');
$pdf->Cell(50,4,'CC:_________________',0,0, 'L');
$pdf->Cell(50,4,'SELLO:_________________________',0,0, 'L');
$pdf->SetMargins(40, 20, 20);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(15,140);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(18,4,iconv('UTF-8', 'windows-1252', 'SALIDA:'),0 , 0, 'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(11,4,$remision['idRemision'],0,0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(15,4,'CLIENTE:',0, 0, 'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(80,4,iconv('UTF-8', 'windows-1252', $remision['cliente']),0,0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(12,4,'FECHA:',0 , 0, 'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(20,4,$remision['fechaRemision'],0,0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(12,4,'TOTAL:',0 , 0, 'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(10,4, '$ '.number_format($remision['valor']),0,1);
$pdf->SetMargins(20, 30, 20);
$pdf->SetXY(20,152);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(10,4,'ITEM', 1,0,'C');
$pdf->Cell(25,4,iconv('UTF-8', 'windows-1252', 'CÓDIGO'), 1,0,'C');
$pdf->Cell(110,4,'PRODUCTO', 1,0,'C');
$pdf->Cell(20,4,'CANTIDAD', 1,0,'C');
$pdf->Cell(20,4,'PRECIO', 1,0,'C');

$pdf->SetXY(20,156);
$pdf->SetFont('Arial','',7);
for($i=0; $i<count($detalle); $i++)
{
	$codprod=$detalle[$i]['codProducto'];
	$prod=$detalle[$i]['producto'];
	$cant=$detalle[$i]['cantProducto'];
	$precio=$detalle[$i]['precioProducto'];
	$pdf->Cell(10,3,$i+1,'L',0,'C');
	$pdf->Cell(25,3,$codprod,'L',0,'C');
	$pdf->Cell(110,3,iconv('UTF-8', 'windows-1252', $prod),'LR',0,'L');
	$pdf->Cell(20,3,$cant,'R',0,'C');
	$pdf->Cell(20,3,$precio,'R',0,'C');
	$pdf->Ln(2.3);
}
$i++;
while ($i<41)
	{
		$pdf->Cell(10,3,'','L',0,'C');
		$pdf->Cell(25,3,'','L',0,'C');
		$pdf->Cell(110,3,'','LR',0,'L');
		$pdf->Cell(20,3, '','R',0,'C');
		$pdf->Cell(20,3, '','R',0,'C');
		$pdf->Ln(2.3);
		$i++;
	}
$pdf->Cell(10,3,'','LB',0,'C');
$pdf->Cell(25,3,'','LB',0,'C');
$pdf->Cell(130,3,'','LBR',0,'L');
$pdf->Cell(20,3, '','RB',0,'C');
$pdf->SetFont('Arial','B',7);
$pdf->Ln(2.5);
$pdf->Cell(25,4,'ACEPTADA',0 , 0, 'L');
$pdf->Ln(2.5);
$pdf->SetFont('Arial','',7);
$pdf->Cell(80,4,'FIRMA:____________________________________',0,0, 'R');
$pdf->Cell(50,4,'CC:_________________',0,0, 'L');
$pdf->Cell(50,4,'SELLO:_________________________',0,0, 'L');
$pdf->Output();
?>
