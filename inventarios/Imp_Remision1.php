<?php
include "../includes/valAcc.php";
require '../includes/fpdf.php';
function cargarClases($classname)
{
	require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
include "includes/num_letra.php";
$remisionOperador = new RemisionesOperaciones();
$detRemisionOperador = new DetRemisionesOperaciones();

$link=conectarServidor();
$remision=$_POST['remision'];
$qryenc="SELECT idRemision, Nit_cliente, fechaRemision, Nom_clien, Tel_clien, Dir_clien, Ciudad, Nom_sucursal, Dir_sucursal from remision1, clientes, ciudades, clientes_sucursal where idRemision=$remision AND Nit_cliente=clientes.Nit_clien and ciudad_clien=Id_ciudad and Id_sucurs=Id_sucursal and clientes_sucursal.Nit_clien=Nit_cliente;";
$resultenc=mysqli_query($link,$qryenc);
$rowenc=mysqli_fetch_array($resultenc);
$pdf=new FPDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(50, 30, 20);
$pdf->Image('images/LogoNova.jpg',10,4, 40, 20);
$pdf->Image('images/LogoNova.jpg',10,134, 40, 20);
$pdf->SetFont('Arial','B',9.5);
$pdf->SetFont('Arial','B',9.5);
$pdf->SetXY(50,10);
$pdf->Cell(50,4,'INDUSTRIAS NOVAQUIM S.A.S.',0,0, 'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,4,'REMISIÓN:',0 , 0, 'R');
$pdf->SetFont('Arial','',9);
$pdf->Cell(6,4,$rowenc['Id_remision'],0,0);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,4,'CLIENTE:',0, 0, 'R');
$pdf->SetFont('Arial','',9);
$pdf->Cell(60,4,$rowenc['Nom_clien'],0,1);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(50,4,'Calle 38 Sur No. 30 - 40',0,0, 'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,4,'ENTREGA:',0, 0, 'R');
$pdf->SetFont('Arial','',9);
$pdf->Cell(60,4,$rowenc['Nom_sucursal'],0,0);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(12,4,'FECHA:',0 , 0, 'R');
$pdf->SetFont('Arial','',9);
$pdf->Cell(10,4,$rowenc['Fech_remision'],0,1);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(50,4,'Tels: 2039484 - 2022912',0,0, 'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,4,'DIRECCIÓN:',0, 0, 'R');
$pdf->SetFont('Arial','',9);
$pdf->Cell(60,4,$rowenc['Dir_sucursal'], 0,0);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(12,4,'CIUDAD:',0, 0, 'R');
$pdf->SetFont('Arial','',9);
$pdf->Cell(15,4,$rowenc['Ciudad'], 0, 1);
$pdf->SetMargins(20, 30, 20);
$pdf->SetXY(20,26);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(10,4,'ITEM', 1,0,'C');
$pdf->Cell(25,4,'CÓDIGO', 1,0,'C');
$pdf->Cell(130,4,'PRODUCTO', 1,0,'C');
$pdf->Cell(20,4,'CANTIDAD', 1,0,'C');
$pdf->SetFont('Arial','',7);
$qry="select idRemision, codProducto, Nombre as Producto, sum(cantProducto) as Cantidad FROM det_remision1, prodpre where idRemision=$remision and codProducto<100000 and codProducto=Cod_prese group by Producto
union
select idRemision, codProducto, Producto, cantProducto as Cantidad FROM det_remision1, distribucion where idRemision=$remision and codProducto>100000 and codProducto=Id_distribucion;";
$result=mysqli_query($link,$qry);
$pdf->SetXY(20,30);
$i=1;
while(($row=mysqli_fetch_array($result)))
{
	$codprod=$row['Cod_producto'];
	$prod=$row['Producto'];
	$cant=$row['Cantidad'];
	$pdf->Cell(10,3,$i,'L',0,'C');
	$pdf->Cell(25,3,$codprod,'L',0,'C');
	$pdf->Cell(130,3,$prod,'LR',0,'L');
	$pdf->Cell(20,3,$cant,'R',0,'C');
	$pdf->Ln(2.3);
	$i++;
}
while ($i<40)
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
$pdf->SetMargins(50, 30, 20);
$pdf->SetFont('Arial','B',9.5);
$pdf->SetXY(50,140);
$pdf->Cell(50,4,'INDUSTRIAS NOVAQUIM S.A.S.',0,0, 'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,4,'REMISIÓN:',0 , 0, 'R');
$pdf->SetFont('Arial','',9);
$pdf->Cell(6,4,$rowenc['Id_remision'],0,0);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,4,'CLIENTE:',0, 0, 'R');
$pdf->SetFont('Arial','',9);
$pdf->Cell(60,4,$rowenc['Nom_clien'],0,1);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(50,4,'Calle 38 Sur No. 30 - 40',0,0, 'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,4,'ENTREGA:',0, 0, 'R');
$pdf->SetFont('Arial','',9);
$pdf->Cell(60,4,$rowenc['Nom_sucursal'],0,0);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(12,4,'FECHA:',0 , 0, 'R');
$pdf->SetFont('Arial','',9);
$pdf->Cell(10,4,$rowenc['Fech_remision'],0,1);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(50,4,'Tels: 2039484 - 2022912',0,0, 'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,4,'DIRECCIÓN:',0, 0, 'R');
$pdf->SetFont('Arial','',9);
$pdf->Cell(60,4,$rowenc['Dir_sucursal'], 0,0);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(12,4,'CIUDAD:',0, 0, 'R');
$pdf->SetFont('Arial','',9);
$pdf->Cell(15,4,$rowenc['Ciudad'], 0, 1);
$pdf->SetMargins(20, 30, 20);
$pdf->SetXY(20,156);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(10,4,'ITEM', 1,0,'C');
$pdf->Cell(25,4,'CÓDIGO', 1,0,'C');
$pdf->Cell(130,4,'PRODUCTO', 1,0,'C');
$pdf->Cell(20,4,'CANTIDAD', 1,0,'C');
$pdf->SetFont('Arial','',7);
$qry="select idRemision, codProducto, Nombre as Producto, sum(cantProducto) as Cantidad FROM det_remision, prodpre where idRemision=$remision and codProducto<100000 and codProducto=Cod_prese group by Producto
union
select idRemision, codProducto, Producto, cantProducto as Cantidad FROM det_remision, distribucion where idRemision=$remision and codProducto>100000 and codProducto=Id_distribucion;";
$result=mysqli_query($link,$qry);
$pdf->SetXY(20,160);
$i=1;
while(($row=mysqli_fetch_array($result)))
{
	$codprod=$row['Cod_producto'];
	$prod=$row['Producto'];
	$cant=$row['Cantidad'];
	$pdf->Cell(10,3,$i,'L',0,'C');
	$pdf->Cell(25,3,$codprod,'L',0,'C');
	$pdf->Cell(130,3,$prod,'LR',0,'L');
	$pdf->Cell(20,3,$cant,'R',0,'C');
	$pdf->Ln(2.3);
	$i++;
}
while ($i<40)
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
mysqli_close($link);
$pdf->Output();
?>
