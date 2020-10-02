<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Detalle de Factura de Venta</title>
<meta charset="utf-8">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<script  src="../js/validar.js"></script>
<script  src="scripts/block.js"></script>
	<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue">
<script  src="scripts/calendar.js"></script>
<script  src="scripts/calendar-sp.js"></script>
<script  src="scripts/calendario.js"></script>
<script >
document.onkeypress = stopRKey; 
</script>
</head>
<body> 
<div id="contenedor">
<div id="saludo1"><strong>DETALLE DE FACTURA DE VENTA</strong></div> 
<?php
include "includes/conect.php";
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
?>
 <?php
		$link=conectarServidor();
		if ($Crear==5)
		{
			$qryup="Update factura set fechaFactura='$FchVta',fechaVenc='$FchVen', ordenCompra=$ord_comp, Descuento=$descuento/100, Observaciones='$observa' where Factura=$factura";
			$resultup=mysqli_query($link,$qryup);
			
		}
		$qry="select Factura, idPedido, Nit_cliente, fechaFactura, fechaVenc, idRemision, ordenCompra, nomCliente, telCliente, dirCliente, 
		Ciudad, nom_personal as vendedor, Observaciones, factura.Estado  
		from factura, clientes, personal, ciudades
		where Nit_cliente=nitCliente and codVendedor=Id_personal and ciudadCliente=idCiudad  and  Factura=$factura;";
		$result=mysqli_query($link,$qry);
		$rowe=mysqli_fetch_array($result);
		$pedido=$rowe['Id_pedido'];
		$remision=$rowe['Id_remision']; 
		$Observaciones= $rowe['Observaciones'];
		$est=$rowe['Estado'];
		if ($rowe['Estado']=='A')
	  	$estado='Anulada';
		if ($rowe['Estado']=='E')
	  	$estado='En Proceso';
		if ($rowe['Estado']=='P')
	  	$estado='Pendiente';
		if ($rowe['Estado']=='C')
	  	$estado='Cancelada';
		mysqli_close($link);
	 ?>
<table  align="center" border="0" summary="encabezado">
    <tr>
      <td width="99" class="font2"><div align="right"><strong>No.  FACTURA:</strong> </div></td>
      <td width="134" class="font2"><div align="left"><?php echo $factura;?></div></td>
      <td width="118" class="font2"><div align="right"><strong>NIT:</strong></div></td>
      <td width="77" colspan="1" class="font2"><?php echo $rowe['Nit_cliente']; ?></td>
      <td width="132" class="font2"><div align="right"><strong>FECHA FACTURA:</strong></div></td>
      <td width="87" class="font2"><?php echo  $rowe['Fech_fact']?></td>
    </tr>
   
    <tr>
      <td class="font2"><div align="right"><strong>CLIENTE:</strong></div></td>
      <td colspan="3" class="font2"><?php echo  utf8_encode($rowe['Nom_clien']); ?></td>
      <td class="font2"><div align="right"><strong>FECH VENCIMIENTO:</strong></div></td>
      <td class="font2"><div align="left"><?php echo $rowe['Fech_venc']; ?> </div></td>
    </tr>
    <tr>
      <td class="font2" ><div align="right"><strong>DIRECCIÓN:</strong></div></td>
      <td colspan="3" class="font2"><?php echo utf8_encode($rowe['Dir_clien']); ?></td>
      <td class="font2"><div align="right"><strong>REMISIÓN:</strong></div></td>
      <td class="font2"><div align="left"><?php echo $rowe['Id_remision']; ?> </div></td>
    </tr>
    <tr>
      <td class="font2" ><div align="right"><strong>TELÉFONO:</strong></div></td>
      <td colspan="1" class="font2"><?php echo $rowe['Tel_clien']; ?></td>
      <td class="font2" ><div align="right"><strong>CIUDAD:</strong></div></td>
      <td colspan="1" class="font2"><?php echo utf8_encode($rowe['Ciudad']); ?></td>
      <td class="font2"><div align="right"><strong>ORDEN DE COMPRA:</strong></div></td>
      <td class="font2"><div align="left">
	  <?php if ($rowe['Ord_compra']!=0)
	  	  	echo $rowe['Ord_compra']; ?> 
      </div></td>
    </tr>
    <tr>
      <td class="font2" ><div align="right"><strong>VENDEDOR:</strong></div></td>
      <td colspan="1" class="font2"><?php echo $rowe['vendedor']; ?></td><td class="font2"><div align="right"><strong>FORMA DE PAGO:</strong></div></td>
      <td class="font2"><div align="left">
	  <?php if ($rowe['Fech_fact']==$rowe['Fech_venc'])
	  		echo "Contado"; 
		else
			echo utf8_encode("Crédito"); ?> 
      </div></td>
      <td class="font2"><div align="right"><strong>PEDIDO:</strong></div></td>
      <td class="font2"><div align="left"><?php echo $rowe['Id_pedido']; ?> </div></td>
    </tr>
    </table>
	<table border="0" align="center" summary="detalle">
      <tr>
        <td  colspan="6">&nbsp;</td>
      </tr>
      <tr>
        <th width="53" align="center" class="font2"><strong>CÓDIGO</strong></th>
        <th width="358" align="center" class="font2"><strong>PRODUCTO</strong></th>
        <th width="50" align="center" class="font2"><strong>CAN </strong></th>
        <th width="47" align="center" class="font2"><strong>IVA </strong></th>
        <th width="80" align="center" class="font2"><strong>VLR. UNIT</strong></th>
        <th width="109" align="center" class="font2"><strong>VLR. TOTAL</strong></th>
      </tr>
      <?php
	include "includes/num_letra.php";
    $link=conectarServidor();
    $qry="select Factura, Cod_producto, Can_producto, Nombre as Producto, tasa, Id_tasa, prec_producto, Descuento 
	from det_factura, prodpre, tasa_iva, factura 
	where Factura=Id_fact and Factura=$factura and Cod_producto<100000 and Cod_producto>100 and Cod_producto=Cod_prese and Cod_iva=Id_tasa order by Producto;";
    $result=mysqli_query($link,$qry);
	$subtotal_1=0;
	$descuento_1=0;
	$iva05_1=0;
	$iva16_1=0;
	$a=0;
    while($row=mysqli_fetch_array($result))
    {
		$subtotal_1 += $row['Can_producto']*$row['prec_producto'];
		$descuento_1 += $row['Can_producto']*$row['prec_producto']*$row['Descuento'] ;
		$Prec=number_format($row['prec_producto'], 0, '.', ',');
		$tot=number_format($row['prec_producto']*$row['Can_producto'], 0, '.', ',');
		if ($row['tasa']==0.05)
			$iva05_1 += $row['Can_producto']*$row['prec_producto']*$row['tasa']*(1-$row['Descuento']);
		if ($rowe['Fech_fact']<FECHA_C)
		{
			if ($row['Id_tasa']==3)
			$iva16_1 += $row['Can_producto']*$row['prec_producto']*0.16*(1-$row['Descuento']);
		}
		else
		{
		if ($row['Id_tasa']==3)
			$iva16_1 += $row['Can_producto']*$row['prec_producto']*$row['tasa']*(1-$row['Descuento']);
		}
		echo'<tr>
			<td class="font2"';
			if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="center">'.$row['Cod_producto'].'</div></td>
			<td class="font2"';
			if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="left">'.utf8_encode($row['Producto']).'</div></td>
			<td class="font2"';
			if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="center">'.$row['Can_producto'].'</div></td>
			<td class="font2"';
			if ($rowe['Fech_fact']<FECHA_C)
		    {	
			if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="center">16 %</div></td>
			<td class="font2"';
			}
			else
			{
				if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="center">'.($row['tasa']*100).' %</div></td>
			<td class="font2"';
			}
			
			
			
			if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="center">$ '.$Prec.'</div></td>
			<td class="font2"';
			if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="center">$ '.$tot.'</div></td>
			</tr>';
    }
	$qry="select Factura, Cod_producto, Can_producto, Producto, tasa, Id_tasa, prec_producto, Descuento 
	from det_factura, distribucion, tasa_iva, factura 
	where Factura=Id_fact and Factura=$factura and Cod_producto>100000 AND Cod_producto=Id_distribucion AND Cod_iva=Id_tasa order by Producto;";
    $result=mysqli_query($link,$qry);
	$subtotal_2=0;
	$descuento_2=0;
	$iva05_2=0;
	$iva16_2=0;
    while($row=mysqli_fetch_array($result))
    {
		$subtotal_2 += $row['Can_producto']*$row['prec_producto'];
		$descuento_2 += $row['Can_producto']*$row['prec_producto']*$row['Descuento'] ;
		$Prec=number_format($row['prec_producto'], 0, '.', ',');
		$tot=number_format($row['prec_producto']*$row['Can_producto'], 0, '.', ',');
		if ($row['tasa']==0.05)
			$iva05_2 += $row['Can_producto']*$row['prec_producto']*$row['tasa']*(1-$row['Descuento']);
		if ($rowe['Fech_fact']<FECHA_C)
		{
			if ($row['Id_tasa']==3)
			$iva16_2 += $row['Can_producto']*$row['prec_producto']*0.16*(1-$row['Descuento']);
		}
		else
		{
		if ($row['Id_tasa']==3)
			$iva16_2 += $row['Can_producto']*$row['prec_producto']*$row['tasa']*(1-$row['Descuento']);
		}	
			
		
		echo'<tr>
			<td class="font2"';
			if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="center">'.$row['Cod_producto'].'</div></td>
			<td class="font2"';
			if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="left">'.$row['Producto'].'</div></td>
			<td class="font2"';
			if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="center">'.$row['Can_producto'].'</div></td>
			<td class="font2"';
			if ($rowe['Fech_fact']<FECHA_C)
		    {	
			if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="center">16 %</div></td>
			<td class="font2"';
			}
			else
			{
				if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="center">'.($row['tasa']*100).' %</div></td>
			<td class="font2"';
			}
			
			if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="center">$ '.$Prec.'</div></td>
			<td class="font2"';
			if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="center">$ '.$tot.'</div></td>
			</tr>';
    }
	$qry="select Factura, Cod_producto, Can_producto, DesServicio as Producto, tasa, prec_producto, Descuento 
	from det_factura, servicios, tasa_iva, factura 
	where Factura=Id_fact and Factura=$factura and Cod_producto<100 AND Cod_producto=IdServicio AND Cod_iva=Id_tasa order by Producto;";
    $result=mysqli_query($link,$qry);
	$subtotal_3=0;
	$descuento_3=0;
	$iva05_3=0;
	$iva16_3=0;
    while($row=mysqli_fetch_array($result))
    {
		$subtotal_3 += $row['Can_producto']*$row['prec_producto'];
		$descuento_3 += $row['Can_producto']*$row['prec_producto']*$row['Descuento'] ;
		$Prec=number_format($row['prec_producto'], 0, '.', ',');
		$tot=number_format($row['prec_producto']*$row['Can_producto'], 0, '.', ',');
		if ($row['tasa']==0.05)
			$iva05_3 += $row['Can_producto']*$row['prec_producto']*$row['tasa']*(1-$row['Descuento']);
			
		if ($rowe['Fech_fact']<FECHA_C)
		{
			if ($row['Id_tasa']==3)
			$iva16_3 += $row['Can_producto']*$row['prec_producto']*0.16*(1-$row['Descuento']);
		}
		else
		{
		if ($row['Id_tasa']==3)
			$iva16_3 += $row['Can_producto']*$row['prec_producto']*$row['tasa']*(1-$row['Descuento']);
		}	
				
		echo'<tr>
			<td class="font2"';
			if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="center">'.$row['Cod_producto'].'</div></td>
			<td class="font2"';
			if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="left">'.$row['Producto'].'</div></td>
			<td class="font2"';
			if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="center">'.$row['Can_producto'].'</div></td>
			<td class="font2"';
			if ($rowe['Fech_fact']<FECHA_C)
		    {	
			if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="center">16 %</div></td>
			<td class="font2"';
			}
			else
			{
				if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="center">'.($row['tasa']*100).' %</div></td>
			<td class="font2"';
			}
			if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="center">$ '.$Prec.'</div></td>
			<td class="font2"';
			if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="center">$ '.$tot.'</div></td>
			</tr>';
    }
	$Iva_05=number_format($iva05_1+$iva05_2+$iva05_3, 0, '.', ',');
	$Iva_16=number_format($iva16_1+$iva16_2+$iva16_3, 0, '.', ',');
	$Sub=number_format($subtotal_1+$subtotal_2+$subtotal_3, 0, '.', ',');
	$descuento=$descuento_1+$descuento_2+$descuento_3;
	$Des=number_format($descuento, 0, '.', ',');
	
	$subtotal=$subtotal_1+$subtotal_2+$subtotal_3;
	$qryf="select Factura, Nit_cliente, nomCliente, retIva, retIca, retFte, Subtotal, ciudadCliente, idCatCliente from factura, clientes where Factura=$factura and Nit_cliente=nitCliente ;";
	$resultf=mysqli_query($link,$qryf);
	$rowf=mysqli_fetch_array($resultf);
	$Ciudad_clien=$rowf['Ciudad_clien'];
	$Id_cat_clien=$rowf['Id_cat_clien'];
	$reten_iva=$rowf['Ret_iva'];
	$reten_ica=$rowf['Ret_ica'];
	$reten_fte=$rowf['Ret_fte'];
	$subtotal=$rowf['Subtotal'];
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
		if ($reten_iva==1)
			$reteiva=round(($iva05_1+$iva05_2+$iva05_3+$iva16_1+$iva16_2+$iva16_3)*0.15);
		else
			$reteiva=0;
	}
	else
	{
		$retefuente=0;$reteiva=0;$reteica=0;
	}
	$Ret=number_format($retefuente, 0, '.', ',');
	$Retica=number_format($reteica, 0, '.', ',');
	$Total= $subtotal_1+$subtotal_2+$subtotal_3-$descuento_1-$descuento_2-$descuento_3+$iva05_1+$iva05_2+$iva05_3+$iva16_1+$iva16_2+$iva16_3-$retefuente-$reteica;
	$Tot=number_format($Total, 0, '.', ',');
	echo'<tr>
		<td class="font2"><div align="left"><strong>SON:</strong></div></td>
		<td colspan="4" class="font2"><div align="right"><strong>SUBTOTAL</strong></div></td>
		<td class="font2"><div align="center"><strong>$ '.$Sub.'</strong></div></td>
		</tr>';
	echo'<tr>
		<td colspan="3" rowspan="4" class="font2"><div align="left"><strong>'.numletra(round($Total)).'</strong></div></td>
		<td colspan="2" class="font2"><div align="right"><strong>DESCUENTO</strong></div></td>
		<td class="font2"><div align="center"><strong>$ '.$Des.'</strong></div></td>
		</tr>
		<tr>
		<td colspan="2" class="font2"><div align="right"><strong>RETEFUENTE</strong></div></td>
		<td class="font2"><div align="center"><strong>$ '.$Ret.'</strong></div></td>
		</tr>
		<tr>
		<td colspan="2" class="font2"><div align="right"><strong>RETEICA</strong></div></td>
		<td class="font2"><div align="center"><strong>$ '.$Retica.'</strong></div></td>
		</tr>';
	echo'<tr>
		<td colspan="2" class="font2"><div align="right"><strong>IVA 5%</strong></div></td>
		<td class="font2"><div align="center"><strong>$ '.$Iva_05.'</strong></div></td>
		</tr>';
	echo'<tr>
		<td class="font2"><div align="left"><strong>OBSERVACIONES:</strong></div></td>
		<td colspan="3" rowspan="2" class="font2"><div align="left">'.$Observaciones.'</div></td>
		<td colspan="1" class="font2"><div align="right"><strong>';
	if ($rowe['Fech_fact']<FECHA_C)
			echo 'IVA 16%';
	else
		echo 'IVA 19%';
			
	echo'</strong></div></td>
		<td class="font2"><div align="center"><strong>$ '.$Iva_16.'</strong></div></td>
		</tr>';
	echo'<tr>
		<td colspan="5" class="font2"><div align="right"><strong>TOTAL</strong></div></td>
		<td class="font2"><div align="center"><strong>$ '.$Tot.'</strong></div></td>
		</tr>';
	$sql="update factura 
		SET Total=round($Total),
		Subtotal=round($subtotal_1+$subtotal_2+$subtotal_3),
		IVA=round($iva05_1+$iva05_2+$iva05_3+$iva16_1+$iva16_2+$iva16_3),
		totalR=round(Subtotal+IVA-$descuento),
		retencionIva=round($reteiva),
		retencionIca=round($reteica),
		retencionFte=round($retefuente)
		where Factura=$factura;";	
	$result=mysqli_query($link,$sql);
	mysqli_close($link);
    ?>
      <tr>
        <td colspan="2"><form action="Imp_Factura.php" method="post" target="_blank">
        <input name="factura" type="hidden" value="<?php echo $factura; ?>">
            <div align="center"><input name="Submit" type="submit" class="formatoBoton1" value="Imprimir Factura" ></div>
        </form></td>
        
        <td colspan="3"><form action="Imp_Remision.php" method="post" target="_blank"><input name="remision" type="hidden" value="<?php echo $remision; ?> ">
            <div align="center"><input name="Submit" type="submit" class="formatoBoton1"  value="Imprimir Remisión"></div></form>
        </td>
        
        <td><form action="factura2.php" method="post"><input name="factura" type="hidden" value="<?php echo $factura; ?>">
            <div align="left"><input name="Submit" type="submit" class="formatoBoton1"
            <?php
			if ($est!='E')
			echo 'disabled';
			?>
            
             value="Modificar" ></div></form>
       </td> 
      </tr>
    </table>
<div align="center"><input type="button" class="formatoBoton1" onClick="window.location='menu.php'" value="Terminar"></div>
</div>
</body>
</html>