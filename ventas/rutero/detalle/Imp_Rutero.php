<?php
session_start();
require '../../../includes/fpdf.php';

function cargarClases($classname)
{
	require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');


$idRutero=$_POST['idRutero'];
$ruteroOperador = new RuteroOperaciones();
$pedidoOperador = new PedidosOperaciones();
$rutero = $ruteroOperador->getRutero($idRutero);
$pedidos = explode(',', $rutero['listaPedidos']);
$pedidosRutero =[];
foreach ($pedidos as $pedido){
	$pedidosRutero[] = $pedidoOperador->getPedidoRutero($pedido);
}

$pdf=new FPDF('L','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(10, 10, 10);
$pdf->Image('../../../images/LogoNova.jpg',10,4, 30);
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(40,10);
$pdf->Cell(80,4,'INDUSTRIAS NOVAQUIM S.A.S.',0,0, 'C');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(25,4,iconv('UTF-8', 'windows-1252', 'Rutero No. '),0 , 0, 'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(15,4,$idRutero,0,0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(25,4,iconv('UTF-8', 'windows-1252', 'FECHA:'),0 , 0, 'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(20,4,$rutero['fechaRutero'],0,1);
$pdf->SetXY(10,25);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(12,3.5,'Ped', 1,0,'C');
$pdf->Cell(12,3.5,'Fact', 1,0,'C');
$pdf->Cell(12,3.5,iconv('UTF-8', 'windows-1252', 'Rem'), 1,0,'C');
$pdf->Cell(50,3.5,'Cliente', 1,0,'C');
$pdf->Cell(50,3.5,iconv('UTF-8', 'windows-1252', 'Dirección de entrega'), 1,0,'C');
$pdf->Cell(30,3.5,iconv('UTF-8', 'windows-1252', 'Recibido por'), 1,0,'C');
$pdf->Cell(50,3.5,iconv('UTF-8', 'windows-1252', 'Firma y sello'), 1,0,'C');
$pdf->Cell(40,3.5,iconv('UTF-8', 'windows-1252', 'Observaciones'), 1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->Ln(3.5);
for($i=0; $i<count($pedidosRutero); $i++)
{
	$pdf->Cell(12,5,$pedidosRutero[$i]['idPedido'], 'LR',0,'C');
	$pdf->Cell(12,5,$pedidosRutero[$i]['idFactura'], 'LR',0,'C');
	$pdf->Cell(12,5,iconv('UTF-8', 'windows-1252', $pedidosRutero[$i]['idRemision']), 'LR',0,'L');
	$pdf->Cell(50,5,iconv('UTF-8', 'windows-1252', $pedidosRutero[$i]['nomCliente']), 'LR',0,'L');
	$pdf->Cell(50,5,iconv('UTF-8', 'windows-1252', $pedidosRutero[$i]['dirSucursal']), 'LR',0,'L');
	$pdf->Cell(30,5,'', 'LR',0,'R');
	$pdf->Cell(50,5,'', 'LR',0,'R');
	$pdf->Cell(40,5,'', 'LR',0,'R');
	$pdf->Ln(5);
	$pdf->Cell(12,5,'', 'LR',0,'C');
	$pdf->Cell(12,5,'', 'LR',0,'C');
	$pdf->Cell(12,5,'', 'LR',0,'L');
	$pdf->Cell(50,5,iconv('UTF-8', 'windows-1252', $pedidosRutero[$i]['nomSucursal']), 'LR',0,'L');
	$pdf->Cell(50,5,'', 'LR',0,'L');
	$pdf->Cell(30,5,'', 'LR',0,'R');
	$pdf->Cell(50,5,'', 'LR',0,'R');
	$pdf->Cell(40,5,'', 'LR',0,'R');
	$pdf->Ln(5);
	$pdf->Cell(12,5,'', 'LRB',0,'C');
	$pdf->Cell(12,5,'', 'LRB',0,'C');
	$pdf->Cell(12,5,'', 'LRB',0,'L');
	$pdf->Cell(50,5,'', 'LRB',0,'L');
	$pdf->Cell(50,5,'', 'LRB',0,'L');
	$pdf->Cell(30,5,'', 'LRB',0,'R');
	$pdf->Cell(50,5,'', 'LRB',0,'R');
	$pdf->Cell(40,5,'', 'LRB',0,'R');
	$pdf->Ln(5);
}
$pdf->SetXY(20,-34);
$pdf->Output();
?>
