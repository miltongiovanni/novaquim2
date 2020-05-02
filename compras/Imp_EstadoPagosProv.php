<?php
include "includes/valAcc.php";
?><?php
require('fpdf.php');
include "includes/conect.php";
$link=conectarServidor();
$Proveedor =$_POST['Proveedor'];
$pdf=new FPDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(10, 10, 10);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(15,4,'Factura', 1,0,'C');
$pdf->Cell(23,4,'Fch Factura', 1,0,'C');
$pdf->Cell(23,4,'Vencimiento', 1,0,'C');
$pdf->Cell(60,4,'Proveedor', 1,0,'C');
$pdf->Cell(25,4,'Total Factura', 1,0,'C');
$pdf->Cell(25,4,'Retención', 1,0,'C');
$pdf->Cell(25,4,'V Pendiente', 1,0,'C');
$pdf->SetFont('Arial','',10);
$qry="select idCompra as Id, Compra, nit_prov as Nit, Num_fact as Factura, Fech_comp, 
	Fech_venc, total_fact as Total, Nom_provee as Proveedor, retencion as Retencion 
	FROM compras, proveedores where estado=3 and nit_prov=nitProv and nit_prov='$Proveedor'
	union
	select idGasto as Id, Compra, nit_prov as Nit, numFact as Factura, fechGasto, 
	fechVenc, totalGasto as Total, Nom_provee as Proveedor, retefuenteGasto as Retencion 
	from gastos, proveedores where estadoGasto=3 and nit_prov=nitProv and nit_prov='$Proveedor' order by Fech_venc;";
$result=mysqli_query($link,$qry);
$i=0;
while($row=mysqli_fetch_array($result))
{
	$pdf->Ln(4);
	$codprod=$row['Factura'];
	//$prod=$row['Nom_clien'];
	//$cant=$row['Contacto'];
	$reten=$row['Retencion'];
	$valor=$row['Total']-$reten;
	$Total=number_format($row['Total'], 0, '.', ',');
	$Retencion=number_format($reten, 0, '.', ',');
	$VTotal=number_format($valor, 0, '.', ',');
	$pdf->Cell(15,4,$row['Factura'], 1,0,'C');
	$pdf->Cell(23,4,$row['Fech_comp'], 1,0,'C');
	$pdf->Cell(23,4,$row['Fech_venc'], 1,0,'C');
	$pdf->Cell(60,4,$row['Proveedor'], 1,0,'L');
	$pdf->Cell(25,4, '$ '.$Total, 1,0,'R');
	$pdf->Cell(25,4, '$ '.$Retencion, 1,0,'R');
	$pdf->Cell(25,4,'$ '.$VTotal, 1,0,'R');
	$i++;
}
$pdf->SetXY(20,-34);
mysqli_close($link);
$pdf->Output();
?>
