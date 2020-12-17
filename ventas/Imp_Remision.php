<?php
include "../includes/valAcc.php";
require('../includes/fpdf.php');
$idRemision=$_POST['idRemision'];
function cargarClases($classname)
{
	require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$remisionOperador = new RemisionesOperaciones();
$detRemisionOperador = new DetRemisionesOperaciones();
$remision = $remisionOperador->getRemision($idRemision);
$detalle = $detRemisionOperador->getTableDetRemisionFactura($idRemision);

$pdf=new FPDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(40, 20, 20);
$pdf->Image('../images/LogoNova.jpg',10,4, 30);
$pdf->Image('../images/LogoNova.jpg',10,134, 30);
$pdf->SetFont('Arial','B',8);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(40,10);
$pdf->Cell(43,4,'INDUSTRIAS NOVAQUIM S.A.S.',0,0, 'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(18,4,utf8_decode('REMISIÓN:'),0 , 0, 'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(11,4,$remision['idRemision'],0,0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(15,4,'CLIENTE:',0, 0, 'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(75,4,utf8_decode($remision['nomCliente']),0,1);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(43,4,'Calle 35 C Sur No. 26 F - 40',0,0, 'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(15,4,'ENTREGA:',0, 0, 'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(75,4,utf8_decode($remision['nomSucursal']),0,0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(12,4,'FECHA:',0 , 0, 'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(10,4,$remision['fechaRemision'],0,1);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(43,4,'Tels: 2039484 - 2022912',0,0, 'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(18,4,utf8_decode('DIRECCIÓN:'),0, 0, 'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(60,4,utf8_decode($remision['dirSucursal']), 0,0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(12,4,'CIUDAD:',0, 0, 'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(15,4,utf8_decode($remision['ciudad']), 0, 1);
$pdf->SetMargins(20, 30, 20);
$pdf->SetXY(20,22);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(10,4,'ITEM', 1,0,'C');
$pdf->Cell(25,4,utf8_decode('CÓDIGO'), 1,0,'C');
$pdf->Cell(130,4,'PRODUCTO', 1,0,'C');
$pdf->Cell(20,4,'CANTIDAD', 1,0,'C');
$pdf->SetFont('Arial','',7);
$pdf->SetXY(20,26);
for($i=0; $i<count($detalle); $i++)
{
	$codprod=$detalle[$i]['codProducto'];
	$prod=$detalle[$i]['producto'];
	$cant=$detalle[$i]['cantProducto'];
	$pdf->Cell(10,3,$i+1,'L',0,'C');
	$pdf->Cell(25,3,$codprod,'L',0,'C');
	$pdf->Cell(130,3,utf8_decode($prod),'LR',0,'L');
	$pdf->Cell(20,3,$cant,'R',0,'C');
	$pdf->Ln(2.3);
}
$i++;
while ($i<41)
	{
		$pdf->Cell(10,3,'','L',0,'C');
		$pdf->Cell(25,3,'','L',0,'C');
		$pdf->Cell(130,3,'','LR',0,'L');
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
$pdf->SetXY(40,140);
$pdf->Cell(43,4,'INDUSTRIAS NOVAQUIM S.A.S.',0,0, 'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(18,4,utf8_decode('REMISIÓN:'),0 , 0, 'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(11,4,$remision['idRemision'],0,0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(15,4,'CLIENTE:',0, 0, 'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(75,4,utf8_decode($remision['nomCliente']),0,1);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(43,4,'Calle 35 C Sur No. 26 F - 40',0,0, 'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(15,4,'ENTREGA:',0, 0, 'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(75,4,utf8_decode($remision['nomSucursal']),0,0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(12,4,'FECHA:',0 , 0, 'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(10,4,$remision['fechaRemision'],0,1);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(43,4,'Tels: 2039484 - 2022912',0,0, 'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(18,4,utf8_decode('DIRECCIÓN:'),0, 0, 'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(60,4,$remision['dirSucursal'], 0,0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(12,4,'CIUDAD:',0, 0, 'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(15,4,utf8_decode($remision['ciudad']), 0, 1);
$pdf->SetMargins(20, 30, 20);
$pdf->SetXY(20,152);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(10,4,'ITEM', 1,0,'C');
$pdf->Cell(25,4,utf8_decode('CÓDIGO'), 1,0,'C');
$pdf->Cell(130,4,'PRODUCTO', 1,0,'C');
$pdf->Cell(20,4,'CANTIDAD', 1,0,'C');

$pdf->SetXY(20,156);
$pdf->SetFont('Arial','',7);
for($i=0; $i<count($detalle); $i++)
{
	$codprod=$detalle[$i]['codProducto'];
	$prod=$detalle[$i]['producto'];
	$cant=$detalle[$i]['cantProducto'];
	$pdf->Cell(10,3,$i+1,'L',0,'C');
	$pdf->Cell(25,3,$codprod,'L',0,'C');
	$pdf->Cell(130,3,utf8_decode($prod),'LR',0,'L');
	$pdf->Cell(20,3,$cant,'R',0,'C');
	$pdf->Ln(2.3);
}
$i++;
while ($i<41)
	{
		$pdf->Cell(10,3,'','L',0,'C');
		$pdf->Cell(25,3,'','L',0,'C');
		$pdf->Cell(130,3,'','LR',0,'L');
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
