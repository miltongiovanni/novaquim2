<?php
include "includes/valAcc.php";
?><?php
require('fpdf.php');
include "includes/conect.php";
$link=conectarServidor();
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
$qry="select Id_compra as Id, Compra, nit_prov as Nit, Num_fact as Factura, Fech_comp, 
				Fech_venc, total_fact as Total, Nom_provee as Proveedor, retencion 
				FROM compras, proveedores where estado=3 and nit_prov=nitProv
				union
				select Id_gasto as Id, Compra, nit_prov as Nit, Num_fact as Factura, Fech_comp, 
				Fech_venc, total_fact as Total, Nom_provee as Proveedor, retencion_g as retencion 
				from gastos, proveedores where estado=3 and nit_prov=nitProv order by Fech_venc;";
$result=mysqli_query($link,$qry);
$i=0;
while($row=mysqli_fetch_array($result))
{
	$pdf->Ln(4);
	$compra=$row['Compra'];	
	$id_compra=$row['Id'];	
	$codprod=$row['Factura'];
	$qry1="select sum(pago) as Parcial from egreso where Id_compra=$id_compra and tip_compra=$compra";
	$resultpago=mysqli_query($link,$qry1);
	$rowpag=mysqli_fetch_array($resultpago);
	if($rowpag['Parcial'])
		$parcial=$rowpag['Parcial'];
	else
		$parcial=0;
	//$prod=$row['Nom_clien'];
	//$cant=$row['Contacto'];
	$retencion=$row['retencion'];
	$Total=number_format($row['Total']-$retencion-$parcial, 0, '.', ',');
	$pdf->Cell(15,4,$row['Factura'], 1,0,'C');
	$pdf->Cell(23,4,$row['Fech_venc'], 1,0,'C');
	$pdf->Cell(70,4,$row['Proveedor'], 1,0,'L');
	$pdf->Cell(25,4, '$ '.$Total, 1,0,'R');
	$pdf->Cell(25,4,'', 1,0,'R');
	$pdf->Cell(20,4,'', 1,0,'R');
	$pdf->Cell(15,4,'', 1,0,'R');
	$i++;
}
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
$pdf->SetXY(20,-34);
$pdf->Output();
?>
