<?php
include "../includes/valAcc.php";
require '../includes/fpdf.php';
function cargarClases($classname)
{
	require '../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');
$EgresoOperador = new EgresoOperaciones();
$compras = $EgresoOperador->getTableComprasXPagar();
$datos = [];
for ($i = 0; $i < count($compras); $i++) {
	$id = $compras[$i]['id'];
	$tipoCompra = $compras[$i]['tipoCompra'];
	$pago = $EgresoOperador->getPagoXIdTipoCompra($id, $tipoCompra) ;
	$datos[$i]['id'] = $compras[$i]['id'];
	$datos[$i]['tipoCompra'] = $compras[$i]['tipoCompra'];
	$datos[$i]['numFact'] = $compras[$i]['numFact'];
	$datos[$i]['fechComp'] = $compras[$i]['fechComp'];
	$datos[$i]['fechVenc'] = $compras[$i]['fechVenc'];
	$datos[$i]['total'] = "$ ".number_format($compras[$i]['total'],0,".",",");
	$datos[$i]['subtotal'] = "$ ".number_format($compras[$i]['subtotal'],0,".",",");
	$datos[$i]['nomProv'] = $compras[$i]['nomProv'];
	$datos[$i]['retefuente'] = "$ ".number_format($compras[$i]['retefuente'],0,".",",");
	$datos[$i]['reteica'] = "$ ".number_format($compras[$i]['reteica'],0,".",",");
	$datos[$i]['aPagar'] = "$ ".number_format(($compras[$i]['total'] - $compras[$i]['retefuente'] - $compras[$i]['reteica']),0,".",",");
	$datos[$i]['pago'] = "$ ".number_format($pago,0,".",",");
	$datos[$i]['saldo'] = "$ ".number_format(($compras[$i]['total'] - $pago),0,".",",");
}
$pdf=new FPDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(10, 10, 10);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(15,4,'Factura', 1,0,'C');
$pdf->Cell(23,4,'Vencimiento', 1,0,'C');
$pdf->Cell(70,4,'Proveedor', 1,0,'C');
$pdf->Cell(25,4,'Total Factura', 1,0,'C');
$pdf->Cell(25,4,'Valor Pagado', 1,0,'C');
$pdf->Cell(20,4,'Fch Cancel', 1,0,'C');
$pdf->Cell(15,4,'F Pago', 1,0,'C');
$pdf->SetFont('Arial','',10);
for ($i = 0; $i < count($datos); $i++) {
	$pdf->Ln(4);
	$pdf->Cell(15,4,$datos[$i]['numFact'], 1,0,'C');
	$pdf->Cell(23,4,$datos[$i]['fechVenc'], 1,0,'C');
	$pdf->Cell(70,4,$datos[$i]['nomProv'], 1,0,'L');
	$pdf->Cell(25,4, $datos[$i]['aPagar'], 1,0,'R');
	$pdf->Cell(25,4,'', 1,0,'R');
	$pdf->Cell(20,4,'', 1,0,'R');
	$pdf->Cell(15,4,'', 1,0,'R');
}
$pdf->SetXY(20,-34);
$pdf->Output();
?>
