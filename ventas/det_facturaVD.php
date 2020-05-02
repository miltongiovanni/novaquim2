<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Detalle de Factura de Venta</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<script  src="scripts/validar.js"></script>
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
		$bd="novaquim";
		if ($Crear==5)
		{
			$qryup="Update factura set Fech_fact='$FchVta',Fech_venc='$FchVen', Ord_compra=$ord_comp, Descuento=$descuento/100, Observaciones='$observa' where Factura=$factura";
			$resultup=mysql_db_query($bd,$qryup);
			
		}
		$qry="select Factura, Id_pedido, Nit_cliente, Fech_fact, Fech_venc, Id_remision, Ord_compra, Nom_clien, Tel_clien, Dir_clien, 
		Ciudad, nom_personal as vendedor, Observaciones 
		from factura, clientes, personal, ciudades
		where Nit_cliente=Nit_clien and Cod_vend=Id_personal and Ciudad_clien=Id_ciudad  and  Factura=$factura;";
		$result=mysql_db_query($bd,$qry);
		$row=mysql_fetch_array($result);
		$pedido=$row['Id_pedido'];
		$remision=$row['Id_remision']; 
		$Observaciones= $row['Observaciones'];
		mysql_close($link);
	 ?>
<table  align="center" border="0" summary="encabezado">
    <tr>
      <td width="99" class="font2"><div align="right"><strong>No.  FACTURA:</strong> </div></td>
      <td width="134" class="font2"><div align="left"><?php echo $factura;?></div></td>
      <td width="118" class="font2"><div align="right"><strong>NIT:</strong></div></td>
      <td width="77" colspan="1" class="font2"><?php echo $row['Nit_cliente']; ?></td>
      <td width="132" class="font2"><div align="right"><strong>FECHA FACTURA:</strong></div></td>
      <td width="87" class="font2"><?php echo  $row['Fech_fact']?></td>
    </tr>
   
    <tr>
      <td class="font2"><div align="right"><strong>CLIENTE:</strong></div></td>
      <td colspan="3" class="font2"><?php echo  $row['Nom_clien']; ?></td>
      <td class="font2"><div align="right"><strong>VENCIMIENTO:</strong></div></td>
      <td class="font2"><div align="left"><?php echo $row['Fech_venc']; ?> </div></td>
    </tr>
    <tr>
      <td class="font2" ><div align="right"><strong>DIRECCI&Oacute;N:</strong></div></td>
      <td colspan="3" class="font2"><?php echo $row['Dir_clien']; ?></td>
      <td class="font2"><div align="right"><strong>REMISI&Oacute;N:</strong></div></td>
      <td class="font2"><div align="left"><?php echo $row['Id_remision']; ?> </div></td>
    </tr>
    <tr>
      <td class="font2" ><div align="right"><strong>TEL&Eacute;FONO:</strong></div></td>
      <td colspan="1" class="font2"><?php echo $row['Tel_clien']; ?></td>
      <td class="font2" ><div align="right"><strong>CIUDAD:</strong></div></td>
      <td colspan="1" class="font2"><?php echo $row['Ciudad']; ?></td>
      <td class="font2"><div align="right"><strong>ORDEN DE COMPRA:</strong></div></td>
      <td class="font2"><div align="left">
	  <?php if ($row['Ord_compra']!=0)
	  	  	echo $row['Ord_compra']; ?> 
      </div></td>
    </tr>
    <tr>
      <td class="font2" ><div align="right"><strong>VENDEDOR:</strong></div></td>
      <td colspan="1" class="font2"><?php echo $row['vendedor']; ?></td><td class="font2"><div align="right"><strong>FORMA DE PAGO:</strong></div></td>
      <td class="font2"><div align="left">
	  <?php if ($row['Fech_fact']==$row['Fech_venc'])
	  		echo "Contado"; 
		else
			echo "Crédito"; ?> 
      </div></td>
      <td class="font2"><div align="right"><strong>PEDIDO:</strong></div></td>
      <td class="font2"><div align="left"><?php echo $row['Id_pedido']; ?> </div></td>
    </tr>
    </table>
	<table border="0" align="center" summary="detalle">
      <tr>
        <td  colspan="6">&nbsp;</td>
      </tr>
      <tr>
        <th width="53" align="center" class="font2"><strong>C&Oacute;DIGO</strong></th>
        <th width="358" align="center" class="font2"><strong>PRODUCTO</strong></th>
        <th width="50" align="center" class="font2"><strong>CAN </strong></th>
        <th width="47" align="center" class="font2"><strong>IVA </strong></th>
        <th width="80" align="center" class="font2"><strong>VLR. UNIT</strong></th>
        <th width="109" align="center" class="font2"><strong>VLR. TOTAL</strong></th>
      </tr>
      <?php
	include "includes/num_letra.php";
    $link=conectarServidor();
    $bd="novaquim";
    $qry="select Factura, Cod_producto, Can_producto, Nombre as Producto, tasa, prec_producto, Descuento 
	from det_factura, prodpre, tasa_iva, factura 
	where Factura=Id_fact and Factura=$factura and Cod_producto<100000 and Cod_producto=Cod_prese and Cod_iva=Id_tasa order by Producto;";
    $result=mysql_db_query($bd,$qry);
	$subtotal_1=0;
	$descuento_1=0;
	$iva10_1=0;
	$iva16_1=0;
    while($row=mysql_fetch_array($result))
    {
		$subtotal_1 += $row['Can_producto']*$row['prec_producto'];
		$descuento_1 += $row['Can_producto']*$row['prec_producto']*$row['Descuento'] ;
		$Prec=number_format($row['prec_producto'], 0, '.', ',');
		$tot=number_format($row['prec_producto']*$row['Can_producto'], 0, '.', ',');
		if ($row['tasa']==0.1)
			$iva10_1 += $row['Can_producto']*$row['prec_producto']*$row['tasa']*(1-$row['Descuento']);
		if ($row['tasa']==0.16)
			$iva16_1 += $row['Can_producto']*$row['prec_producto']*$row['tasa']*(1-$row['Descuento']);
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
			if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="center">'.($row['tasa']*100).' %</div></td>
			<td class="font2"';
			if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="center">$ '.$Prec.'</div></td>
			<td class="font2"';
			if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="center">$ '.$tot.'</div></td>
			</tr>';
    }
	$qry="select Factura, Cod_producto, Can_producto, Producto, tasa, prec_producto, Descuento 
	from det_factura, distribucion, tasa_iva, factura 
	where Factura=Id_fact and Factura=$factura and Cod_producto>100000 and Cod_producto<1000000 AND Cod_producto=Id_distribucion AND Cod_iva=Id_tasa order by Producto;";
    $result=mysql_db_query($bd,$qry);
	$subtotal_2=0;
	$descuento_2=0;
	$iva10_2=0;
	$iva16_2=0;
    while($row=mysql_fetch_array($result))
    {
		$subtotal_2 += $row['Can_producto']*$row['prec_producto'];
		$descuento_2 += $row['Can_producto']*$row['prec_producto']*$row['Descuento'] ;
		$Prec=number_format($row['prec_producto'], 0, '.', ',');
		$tot=number_format($row['prec_producto']*$row['Can_producto'], 0, '.', ',');
		if ($row['tasa']==0.1)
			$iva10_2 += $row['Can_producto']*$row['prec_producto']*$row['tasa']*(1-$row['Descuento']);
		if ($row['tasa']==0.16)
			$iva16_2 += $row['Can_producto']*$row['prec_producto']*$row['tasa']*(1-$row['Descuento']);
		
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
			if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="center">'.($row['tasa']*100).' %</div></td>
			<td class="font2"';
			if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="center">$ '.$Prec.'</div></td>
			<td class="font2"';
			if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="center">$ '.$tot.'</div></td>
			</tr>';
    }
	$qry="select Factura, Cod_producto, Can_producto, Producto, tasa, prec_producto, Descuento 
	from det_factura, herramientas, tasa_iva, factura 
	where Factura=Id_fact and Factura=$factura and Cod_producto>=1000000 AND Cod_producto=Id_herramienta AND Cod_iva=Id_tasa order by Producto";
    $result=mysql_db_query($bd,$qry);
	$subtotal_3=0;
	$descuento_3=0;
	$iva10_3=0;
	$iva16_3=0;
    while($row=mysql_fetch_array($result))
    {
		$subtotal_3 += $row['Can_producto']*$row['prec_producto'];
		$descuento_3 += $row['Can_producto']*$row['prec_producto']*$row['Descuento'] ;
		$Prec=number_format($row['prec_producto'], 0, '.', ',');
		$tot=number_format($row['prec_producto']*$row['Can_producto'], 0, '.', ',');
		if ($row['tasa']==0.1)
			$iva10_3 += $row['Can_producto']*$row['prec_producto']*$row['tasa']*(1-$row['Descuento']);
		if ($row['tasa']==0.16)
			$iva16_3 += $row['Can_producto']*$row['prec_producto']*$row['tasa']*(1-$row['Descuento']);
		
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
			if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="center">'.($row['tasa']*100).' %</div></td>
			<td class="font2"';
			if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="center">$ '.$Prec.'</div></td>
			<td class="font2"';
			if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
			echo '><div align="center">$ '.$tot.'</div></td>
			</tr>';
    }
	$Iva_10=number_format($iva10_1+$iva10_2+$iva10_3, 0, '.', ',');
	$Iva_16=number_format($iva16_1+$iva16_2+$iva16_3, 0, '.', ',');
	$Sub=number_format($subtotal_1+$subtotal_2+$subtotal_3, 0, '.', ',');
	$Des=number_format($descuento_1+$descuento_2+$descuento_3, 0, '.', ',');
	$Total= $subtotal_1+$subtotal_2+$subtotal_3-$descuento_1-$descuento_2-$descuento_3+$iva10_1+$iva10_2+$iva10_3+$iva16_1+$iva16_2+$iva16_3;
	$Tot=number_format($Total, 0, '.', ',');
	$subtotal=$subtotal_1+$subtotal_2+$subtotal_3;
	$qryf="select Factura, Nit_cliente, Nom_clien, Ret_iva, Ret_ica, Ret_fte from factura, clientes where Factura=$factura and Nit_cliente=Nit_clien ;";
	$resultf=mysql_db_query($bd,$qryf);
	$rowf=mysql_fetch_array($resultf);
	$reten_iva=$rowf['Ret_iva'];
	$reten_ica=$rowf['Ret_ica'];
	$reten_fte=$rowf['Ret_fte'];
	$subtotal=$rowf['Subtotal'];
	if (($subtotal >= BASE_C))
	{	
		if ($reten_fte==1)
			$retefuente=round($subtotal*0.035);
		else
			$retefuente=0;
		if ($reten_iva==1)
			$reteiva=round(($iva10_1+$iva10_2+$iva10_3+$iva16_1+$iva16_2+$iva16_3)*0.5);
		else
			$reteiva=0;
		if ($reten_ica==1)
			$reteica=round($subtotal*0.01104);
		else
			$reteica=0;
	}
	else
	{
		$retefuente=0;$reteiva=0;$reteica=0;
	}
	
	echo'<tr>
		<td class="font2"><div align="left"><strong>SON:</strong></div></td>
		<td colspan="4" class="font2"><div align="right"><strong>SUBTOTAL</strong></div></td>
		<td class="font2"><div align="center"><strong>$ '.$Sub.'</strong></div></td>
		</tr>';
	echo'<tr>
		<td colspan="3" rowspan="2" class="font2"><div align="left"><strong>'.numletra(round($Total)).'</strong></div></td>
		<td colspan="2" class="font2"><div align="right"><strong>DESCUENTO</strong></div></td>
		<td class="font2"><div align="center"><strong>$ '.$Des.'</strong></div></td>
		</tr>';
	echo'<tr>
		<td colspan="2" class="font2"><div align="right"><strong>IVA 10%</strong></div></td>
		<td class="font2"><div align="center"><strong>$ '.$Iva_10.'</strong></div></td>
		</tr>';
	echo'<tr>
		<td class="font2"><div align="left"><strong>OBSERVACIONES:</strong></div></td>
		<td colspan="3" rowspan="2" class="font2"><div align="left">'.$Observaciones.'</div></td>
		<td colspan="1" class="font2"><div align="right"><strong>IVA 16%</strong></div></td>
		<td class="font2"><div align="center"><strong>$ '.$Iva_16.'</strong></div></td>
		</tr>';
	echo'<tr>
		<td colspan="5" class="font2"><div align="right"><strong>TOTAL</strong></div></td>
		<td class="font2"><div align="center"><strong>$ '.$Tot.'</strong></div></td>
		</tr>';
	$sql="update factura 
		SET Total=round($Total),
		Subtotal=round($subtotal_1+$subtotal_2),
		IVA=round($iva10_1+$iva10_2 + $iva16_1+$iva16_2),
		Reten_iva=round($reteiva),
		Reten_ica=round($reteica),
		Reten_fte=round($retefuente)
		where Factura=$factura;";	
	$result=mysql_db_query($bd,$sql);
	mysql_close($link);
    ?>
      <tr>
        <td colspan="2"><form action="Imp_Factura.php" method="post" target="_blank">
        <input name="factura" type="hidden" value="<?php echo $factura; ?>">
            <div align="center"><input type="submit" name="Submit" value="Imprimir Factura" ></div>
        </form></td>
        
        <td colspan="3"><form action="Imp_Remision.php" method="post" target="_blank"><input name="remision" type="hidden" value="<?php echo $remision; ?> ">
            <div align="center"><input type="submit" name="Submit" value="Imprimir Remisi&oacute;n"></div></form>
        </td>
        
        <td><form action="factura2VD.php" method="post"><input name="factura" type="hidden" value="<?php echo $factura; ?>">
            <div align="left"><input type="submit" name="Submit" value="Modificar" ></div></form>
       </td> 
      </tr>
    </table>
<div align="center"><input type="button" onClick="window.location='menu.php'" value="Terminar"></div>
</div>
</body>
</html>