<?php
include "includes/valAcc.php";
?><?php
require('fpdf.php');
include "includes/conect.php";
include "includes/num_letra.php";
$link=conectarServidor();
//$remision=$_POST['remision'];
$pdf=new FPDF('L','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(10, 10, 10);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(8,3.5,'Fact', 1,0,'C');
$pdf->Cell(17,3.5,'Fch Vmto', 1,0,'C');
$pdf->Cell(70,3.5,'Cliente', 1,0,'C');
$pdf->Cell(45,3.5,'Dirección Cliente', 1,0,'C');
$pdf->Cell(33,3.5,'Contacto', 1,0,'C');
$pdf->Cell(13,3.5,'Teléfono', 1,0,'C');
$pdf->Cell(17,3.5,'Celular', 1,0,'C');
$pdf->Cell(17,3.5,'Saldo', 1,0,'C');
$pdf->Cell(15,3.5,'Fch Canc', 1,0,'C');
$pdf->Cell(15,3.5,'Valor', 1,0,'C');
$pdf->Cell(10,3.5,'F Pago', 1,0,'C');
$pdf->SetFont('Arial','',8);
$qry="select Factura, Nom_clien, Contacto, Cargo, Dir_clien, Tel_clien, Cel_clien, Fech_fact, Fech_venc, Total, Reten_iva, Reten_ica, Reten_fte, Subtotal, IVA from factura, clientes WHERE Nit_cliente=Nit_clien and factura.Estado='P';";
$result=mysqli_query($link,$qry);
$i=0;
while($row=mysqli_fetch_array($result))
{
	$pdf->Ln(3.5);
	$fact=$row['Factura'];
	$qryp="select sum(cobro) as Parcial from r_caja where Fact=$fact";
	$resultpago=mysqli_query($link,$qryp);
	$rowpag=mysqli_fetch_array($resultpago);
	if($rowpag['Parcial'])
		$parcial=$rowpag['Parcial'];
	else
		$parcial=0;
	$prod=$row['Nom_clien'];
	$cant=$row['Contacto'];
	$Total=number_format($row['Total'], 0, '.', ',');
	$Cobro=number_format(($row['Total']-$row['Reten_fte']-$row['Reten_iva']-$row['Reten_ica']-$parcial), 0, '.', ',');
	$pdf->Cell(8,3.5,$row['Factura'], 1,0,'C');
	
	$pdf->Cell(17,3.5,$row['Fech_venc'], 1,0,'C');
	$pdf->Cell(70,3.5,$row['Nom_clien'], 1,0,'L');
	$pdf->Cell(45,3.5,$row['Dir_clien'], 1,0,'L');
	$pdf->Cell(33,3.5,$row['Contacto'], 1,0,'L');
	$pdf->Cell(13,3.5,$row['Tel_clien'], 1,0,'C');
	$pdf->Cell(17,3.5,$row['Cel_clien'], 1,0,'C');
	$pdf->Cell(17,3.5,'$ '.$Cobro, 1,0,'R');
	$pdf->Cell(15,3.5,'', 1,0,'R');
	$pdf->Cell(15,3.5,'', 1,0,'R');
	$pdf->Cell(10,3.5,'', 1,0,'R');
	$i++;
}
$pdf->SetXY(20,-34);
mysqli_close($link);
$pdf->Output();
?>
