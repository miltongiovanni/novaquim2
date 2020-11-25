<?php
include "../includes/valAcc.php";
?><?php
require('fpdf.php');
include "includes/conect.php";
include "includes/num_letra.php";
$link=conectarServidor();
$factura=$_POST['factura'];




$qryenc= "select idFactura, idPedido, Nit_cliente, fechaFactura, fechaVenc, idRemision, ordenCompra, nomCliente, telCliente, dirCliente, factura.Estado, 
		Ciudad, nom_personal as vendedor, Observaciones, retFte
		from factura, clientes, personal, ciudades
		where Nit_cliente=nitCliente and codVendedor=Id_personal and ciudadCliente=idCiudad and idFactura=$factura;";
$resultenc=mysqli_query($link,$qryenc);
$rowenc=mysqli_fetch_array($resultenc);
$est=$rowenc['Estado'];
$reten_fte=$rowenc['Ret_fte'];


if ($est!='C')
{
	$qryup= "Update factura set Estado='P' where idFactura=$factura";
	$resultup=mysqli_query($link,$qryup);		
}

$pdf=new FPDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetXY(100,13);
$pdf->SetFont('Arial','',8);
//$pdf->Cell(75,3.5,'Habilita 5700 a 7000 Resol 320001140880 Fecha 13/05/2014',0, 0, R);
$pdf->SetXY(10,30);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,3.5,'CLIENTE:',0, 0, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(110,3.5,($rowenc['Nom_clien']));
$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,3.5,'FECHA:',0 , 0, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(35,3.5,$rowenc['Fech_fact'],0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,3.5,'NIT:',0, 0, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(110,3.5,$rowenc['Nit_cliente']);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,3.5,'VENCIMIENTO:',0, 0, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(35,3.5,$rowenc['Fech_venc'],0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,3.5,'DIRECCIÓN:',0, 0, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(110,3.5,($rowenc['Dir_clien']));
$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,3.5,'REMISIÓN:',0 , 0, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(35,3.5,$rowenc['Id_remision'],0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,3.5,'TELÉFONO:',0, 0, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(110,3.5,$rowenc['Tel_clien']);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,3.5,'ORDEN DE COMPRA:',0 , 0, 'R');
$pdf->SetFont('Arial','',10);
if ($rowenc['Ord_compra']!=0)
	$orden="";
else
$orden=$rowenc['Ord_compra'];
$pdf->Cell(35,3.5,$orden,0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,3.5,'CIUDAD:',0, 0, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(110,3.5,$rowenc['Ciudad']);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,3.5,'FORMA DE PAGO:',0 , 0, 'R');
$pdf->SetFont('Arial','',10);
if ($rowenc['Fech_fact']==$rowenc['Fech_venc'])
	$pago="Contado"; 
else
	$pago="Crédito";
$pdf->Cell(35,3.5,$pago,0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,3.5,'VENDEDOR:',0, 0, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(110,3.5,$rowenc['vendedor']);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,3.5,'PEDIDO:',0 , 0, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(35,3.5,$rowenc['Id_pedido'],0,1);
$pdf->SetXY(10,51);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,4,'CÓDIGO', 1,0,'C');
$pdf->Cell(100,4,'PRODUCTO ', 1,0,'C');
$pdf->Cell(10,4,'CAN ', 1,0,'C');
$pdf->Cell(10,4,'IVA ', 1,0,'C');
$pdf->Cell(22,4,'VR. UNIT ',1,0,'C');
$pdf->Cell(25,4,'SUBTOTAL ', 1,0,'C');
$pdf->SetFont('Arial','',10);
$qry= "select idFactura, codProducto, cantProducto, Nombre as Producto, tasa, Id_tasa, precioProducto, Descuento 
	from det_factura, prodpre, tasa_iva, factura 
	where idFactura=idFactura and idFactura=$factura and codProducto<100000 and codProducto>100 and codProducto=Cod_prese and Cod_iva=Id_tasa order by Producto;";
$result=mysqli_query($link,$qry);
$pdf->SetXY(10,55);
$subtotal_1=0;
$descuento_1=0;
$iva05_1=0;
$iva16_1=0;
while($row=mysqli_fetch_array($result))
{
$codprod=$row['Cod_producto'];
$prod=$row['Producto'];
$cant=$row['Can_producto'];
$Idtasaiva=$row['Id_tasa'];
if (($rowenc['Fech_fact']<FECHA_C)&&($Idtasaiva==3))
$iva=19;
else
$iva=$row['tasa']*100;
$subtotal_1 += $row['Can_producto']*$row['prec_producto'];
$descuento_1 += $row['Can_producto']*$row['prec_producto']*$row['Descuento'] ;
$Prec=number_format($row['prec_producto'], 0, '.', ',');
$tot=number_format($row['prec_producto']*$row['Can_producto'], 0, '.', ',');
if ($row['tasa']==0.05)
	$iva05_1 += $row['Can_producto']*$row['prec_producto']*$row['tasa']*(1-$row['Descuento']);
if ($rowenc['Fech_fact']<FECHA_C)
		{
			if ($row['Id_tasa']==3)
			$iva16_1 += $row['Can_producto']*$row['prec_producto']*0.16*(1-$row['Descuento']);
		}
		else
		{
		if ($row['Id_tasa']==3)
			$iva16_1 += $row['Can_producto']*$row['prec_producto']*$row['tasa']*(1-$row['Descuento']);
		}
$pdf->Cell(25,4,$codprod,0,0,'C');
$pdf->Cell(100,4,$prod,0,0,'L');
$pdf->Cell(10,4,$cant,0,0,'C');
$pdf->Cell(10,4,"$iva %",0,0,'C');
$pdf->Cell(22,4,"$ $Prec",0,0,'R');
$pdf->Cell(25,4,"$ $tot",0,0,'R');
$pdf->Ln(4);
}
$qry= "select idFactura, codProducto, cantProducto, Producto, tasa, Id_tasa, precioProducto, Descuento 
	from det_factura, distribucion, tasa_iva, factura 
	where idFactura=idFactura and idFactura=$factura and codProducto>100000 AND codProducto=Id_distribucion AND Cod_iva=Id_tasa order by Producto;";
$result=mysqli_query($link,$qry);
$subtotal_2=0;
$descuento_2=0;
$iva05_2=0;
$iva16_2=0;
while($row=mysqli_fetch_array($result))
{
$codprod=$row['Cod_producto'];
$prod=$row['Producto'];
$cant=$row['Can_producto'];
$Idtasaiva=$row['Id_tasa'];
if (($rowenc['Fech_fact']<FECHA_C)&&($Idtasaiva==3))
$iva=16;
else
$iva=$row['tasa']*100;
$subtotal_2 += $row['Can_producto']*$row['prec_producto'];
$descuento_2 += $row['Can_producto']*$row['prec_producto']*$row['Descuento'] ;
$Prec=number_format($row['prec_producto'], 0, '.', ',');
$tot=number_format($row['prec_producto']*$row['Can_producto'], 0, '.', ',');
if ($row['tasa']==0.05)
	$iva05_2 += $row['Can_producto']*$row['prec_producto']*$row['tasa']*(1-$row['Descuento']);
	
if ($rowenc['Fech_fact']<FECHA_C)
		{
			if ($row['Id_tasa']==3)
			$iva16_2 += $row['Can_producto']*$row['prec_producto']*0.16*(1-$row['Descuento']);
		}
		else
		{
		if ($row['Id_tasa']==3)
			$iva16_2 += $row['Can_producto']*$row['prec_producto']*$row['tasa']*(1-$row['Descuento']);
		}	
			
$pdf->Cell(25,4,$codprod,0,0,'C');
$pdf->Cell(100,4,$prod,0,0,'L');
$pdf->Cell(10,4,$cant,0,0,'C');
$pdf->Cell(10,4,"$iva %",0,0,'C');
$pdf->Cell(22,4,"$ $Prec",0,0,'R');
$pdf->Cell(25,4,"$ $tot",0,0,'R');
$pdf->Ln(4);
}
$qry= "select idFactura, codProducto, cantProducto, DesServicio as Producto, tasa, precioProducto, Descuento 
	from det_factura, servicios, tasa_iva, factura 
	where idFactura=idFactura and idFactura=$factura and codProducto<100 AND codProducto=IdServicio AND Cod_iva=Id_tasa order by Producto;";
$subtotal_3=0;
$descuento_3=0;
$iva05_3=0;
$iva16_3=0;
$result=mysqli_query($link,$qry);
while($row=mysqli_fetch_array($result))
{
$codprod=$row['Cod_producto'];
$prod=$row['Producto'];
$cant=$row['Can_producto'];
$iva=$row['tasa']*100;
$subtotal_3 += $row['Can_producto']*$row['prec_producto'];
$descuento_3 += $row['Can_producto']*$row['prec_producto']*$row['Descuento'] ;
$Prec=number_format($row['prec_producto'], 0, '.', ',');
$tot=number_format($row['prec_producto']*$row['Can_producto'], 0, '.', ',');
if ($row['tasa']==0.1)
	$iva10_3 += $row['Can_producto']*$row['prec_producto']*$row['tasa']*(1-$row['Descuento']);
if ($row['tasa']==0.16)
	$iva16_3 += $row['Can_producto']*$row['prec_producto']*$row['tasa']*(1-$row['Descuento']);
$pdf->Cell(25,4,$codprod,0,0,'C');
$pdf->Cell(100,4,$prod,0,0,'L');
$pdf->Cell(10,4,$cant,0,0,'C');
$pdf->Cell(10,4,"$iva %",0,0,'C');
$pdf->Cell(22,4,"$ $Prec",0,0,'R');
$pdf->Cell(25,4,"$ $tot",0,0,'R');
$pdf->Ln(4);
}
$Iva_05=number_format($iva05_1+$iva05_2+$iva05_3, 0, '.', ',');
$Iva_16=number_format($iva16_1+$iva16_2+$iva16_3, 0, '.', ',');
$Sub=number_format($subtotal_1+$subtotal_2+$subtotal_3, 0, '.', ',');
$Des=number_format($descuento_1+$descuento_2+$descuento_3, 0, '.', ',');
$descuento=$descuento_1+$descuento_2+$descuento_3;
$subtotal=$subtotal_1+$subtotal_2+$subtotal_3;
$qryf= "select idFactura, Nit_cliente, nomCliente, retIva, retIca, retFte, Subtotal, ciudadCliente, idCatCliente from factura, clientes where idFactura=$factura and Nit_cliente=nitCliente ;";
	$resultf=mysqli_query($link,$qryf);
	$rowf=mysqli_fetch_array($resultf);
	$Ciudad_clien=$rowf['Ciudad_clien'];
	$Id_cat_clien=$rowf['Id_cat_clien'];


	if (($subtotal >= BASE_C))
	{	
		if ($reten_fte==1)
		{
			$retefuente=round(($subtotal-$descuento)*0.025);
			if (($Ciudad_clien==1)&&($Id_cat_clien!=1))
			{
			$reteica=round(($subtotal-$descuento)*0.01104);
			}
			else
			$reteica=0;
		}
		else
		{
			$retefuente=0;
			$reteica=0;
		}
	}
	else
	{
		$retefuente=0;
		$reteica=0;
	}
$Ret=number_format($retefuente, 0, '.', ',');
$Retica=number_format($reteica, 0, '.', ',');
$Total= $subtotal_1+$subtotal_2+$subtotal_3-$descuento_1-$descuento_2-$descuento_3+$iva05_1+$iva05_2+$iva05_3+$iva16_1+$iva16_2+$iva16_3-$retefuente-$reteica;
$Tot=number_format($Total, 0, '.', ',');
$pdf->SetFont('Arial','',10);
$pdf->SetXY(10,-50);
$pdf->Cell(140,16,'',1);
$pdf->SetXY(10,-50);
$pdf->SetFont('Arial','',8);
if ($rowenc['Fech_fact']<FECHA_C)
{
$pdf->Cell(32,4,'BASE GRAVABLE 16%: ');
$base16=($iva16_1+$iva16_2+$iva16_3)/0.16;
$BaseI16=number_format($base16, 0, '.', ',');
$pdf->Cell(16,4,"$ $BaseI16",0,0,'L');
}
else
{
$pdf->Cell(32,4,'BASE GRAVABLE 19%: ');
$base16=($iva16_1+$iva16_2+$iva16_3)/0.19;
$BaseI16=number_format($base16, 0, '.', ',');
$pdf->Cell(16,4,"$ $BaseI16",0,0,'R');
}
$pdf->Cell(27,4,'BASE GRAVABLE 5%: ');
$base5=($iva05_1+$iva05_2+$iva05_3)/0.05;
$BaseI5=number_format($base5, 0, '.', ',');
$pdf->Cell(16,4,"$ $BaseI5",0,0,'R');
$pdf->Cell(26,4,'BASE NO GRAVADA: ');
$base0=round($subtotal-$descuento-$base16-$base5);
$BaseI0=number_format($base0, 0, '.', ',');
$pdf->Cell(16,4,"$ $BaseI0",0,0,'R');
$pdf->SetXY(10,-46);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(33,4,'OBSERVACIONES: ');
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(105,4,$rowenc['Observaciones']);
$pdf->SetXY(10,-34);
$pdf->Cell(140,12,'',1);
$pdf->SetXY(10,-34);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(30,4,'SON:');
$pdf->SetFont('Arial','',10);
$pdf->SetXY(155,-50);
$pdf->Cell(50,28,'',1);
$pdf->SetXY(155,-50);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,4,'SUBTOTAL',0,0,'R');
$pdf->Cell(25,4,"$ $Sub",0,0,'R');
$pdf->SetXY(155,-46);
$pdf->Cell(25,4,'DESCUENTO',0,0,'R');
$pdf->Cell(25,4,"$ $Des",0,0,'R');
$pdf->SetXY(155,-42);
$pdf->Cell(25,4,'RETEFUENTE',0,0,'R');
$pdf->Cell(25,4,"$ $Ret",0,0,'R');
$pdf->SetXY(155,-38);
$pdf->Cell(25,4,'RETEICA',0,0,'R');
$pdf->Cell(25,4,"$ $Retica",0,0,'R');
$pdf->SetXY(155,-34);
$pdf->Cell(25,4,'IVA 5%',0,0,'R');
$pdf->Cell(25,4,"$ $Iva_05",0,0,'R');
$pdf->SetXY(155,-30);
if ($rowenc['Fech_fact']<FECHA_C)
$pdf->Cell(25,4,'IVA 16%',0,0,'R');
else
$pdf->Cell(25,4,'IVA 19%',0,0,'R');
$pdf->Cell(25,4,"$ $Iva_16",0,0,'R');
$pdf->SetXY(155,-26);
$pdf->Cell(25,4,'TOTAL',0,0,'R');
$pdf->Cell(25,4,"$ $Tot",0,0,'R');
$num_letra=numletra(round($Total));
$pdf->SetXY(20,-34);
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(130,4, $num_letra,0,'L');
mysqli_close($link);
$pdf->Output();
?>
