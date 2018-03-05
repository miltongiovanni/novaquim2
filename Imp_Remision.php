<?php
include "includes/valAcc.php";
?>
<?php
require('fpdf.php');
include "includes/conect.php";
include "includes/num_letra.php";
$link=conectarServidor();
$remision=$_POST['remision'];
$qryenc="SELECT Id_remision, Nit_cliente, Fech_remision, Nom_clien, Tel_clien, Dir_clien, Ciudad, Nom_sucursal, Dir_sucursal from remision, clientes, ciudades, clientes_sucursal where Id_remision=$remision AND Nit_cliente=clientes.Nit_clien and ciudad_clien=Id_ciudad and Id_sucurs=Id_sucursal and clientes_sucursal.Nit_clien=Nit_cliente;";
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
$pdf->Cell(50,4,'Calle 35 C Sur No. 26 F - 40',0,0, 'C');
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
$qry1="select Id_remision, Cod_producto, Nombre as Producto, sum(Can_producto) as Cantidad FROM det_remision, prodpre where Id_remision=$remision and Cod_producto<100000 and Cod_producto=Cod_prese group by Producto order by Producto";
$result1=mysqli_query($link,$qry1);
$pdf->SetXY(20,30);
$i=1;
while(($row1=mysqli_fetch_array($result1)))
{
	$codprod=$row1['Cod_producto'];
	$prod=$row1['Producto'];
	$cant=$row1['Cantidad'];
	$pdf->Cell(10,3,$i,'L',0,'C');
	$pdf->Cell(25,3,$codprod,'L',0,'C');
	$pdf->Cell(130,3,$prod,'LR',0,'L');
	$pdf->Cell(20,3,$cant,'R',0,'C');
	$pdf->Ln(2.3);
	$i++;
}
$qry2="select Id_remision, Cod_producto, Producto, Can_producto as Cantidad FROM det_remision, distribucion where Id_remision=$remision and Cod_producto>100000 and Cod_producto<1000000 and Cod_producto=Id_distribucion order by Producto";
$result2=mysqli_query($link,$qry2);
while(($row2=mysqli_fetch_array($result2)))
{
	$codprod=$row2['Cod_producto'];
	$prod=$row2['Producto'];
	$cant=$row2['Cantidad'];
	$pdf->Cell(10,3,$i,'L',0,'C');
	$pdf->Cell(25,3,$codprod,'L',0,'C');
	$pdf->Cell(130,3,$prod,'LR',0,'L');
	$pdf->Cell(20,3,$cant,'R',0,'C');
	$pdf->Ln(2.3);
	$i++;
}
$qry3="select Id_remision, Cod_producto, DesServicio as Producto, Can_producto as Cantidad FROM det_remision, servicios where Id_remision=$remision and Cod_producto<100 and Cod_producto=IdServicio order by Producto";
$result3=mysqli_query($link,$qry3);
while(($row3=mysqli_fetch_array($result3)))
{
	$codprod=$row3['Cod_producto'];
	$prod=$row3['Producto'];
	$cant=$row3['Cantidad'];
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
$pdf->Cell(50,4,'Calle 35 C Sur No. 26 F - 40',0,0, 'C');
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
$qry1="select Id_remision, Cod_producto, Nombre as Producto, sum(Can_producto) as Cantidad FROM det_remision, prodpre where Id_remision=$remision and Cod_producto<100000 and Cod_producto=Cod_prese group by Producto order by Producto";
$result1=mysqli_query($link,$qry1);
$pdf->SetXY(20,160);
$i=1;
while(($row1=mysqli_fetch_array($result1)))
{
	$codprod=$row1['Cod_producto'];
	$prod=$row1['Producto'];
	$cant=$row1['Cantidad'];
	$pdf->Cell(10,3,$i,'L',0,'C');
	$pdf->Cell(25,3,$codprod,'L',0,'C');
	$pdf->Cell(130,3,$prod,'LR',0,'L');
	$pdf->Cell(20,3,$cant,'R',0,'C');
	$pdf->Ln(2.3);
	$i++;
}
$qry2="select Id_remision, Cod_producto, Producto, Can_producto as Cantidad FROM det_remision, distribucion where Id_remision=$remision and Cod_producto>100000 and Cod_producto<1000000 and Cod_producto=Id_distribucion order by Producto";
$result2=mysqli_query($link,$qry2);
while(($row2=mysqli_fetch_array($result2)))
{
	$codprod=$row2['Cod_producto'];
	$prod=$row2['Producto'];
	$cant=$row2['Cantidad'];
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
