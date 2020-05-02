<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Modificacion de Comprobante de Egreso</title>
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
<div id="saludo1"><strong>MODIFICACI&Oacute;N DE COMPROBANTE DE EGRESO</strong></div>
<?php
include "includes/conect.php";
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
if($Pago==4)
{
	$link=conectarServidor();   
	$qryb="select Id_compra, tip_compra, pago, Fecha, descuento_e, form_pago, forma_pago from egreso, form_pago where form_pago=Id_fpago and Id_egreso=$egreso;";
	$resultb=mysqli_query($link, $qryb);
	$row_b=mysqli_fetch_array($resultb);
	$id_compra=$row_b['Id_compra'];   
	$compra=$row_b['tip_compra'];
	$form_pago=$row_b['form_pago'];
	$fecha_e=$row_b['Fecha'];
	$forma_pago=$row_b['forma_pago'];
	$descuento_e=$row_b['descuento_e'];
	$pago=$row_b['pago'];
}
if($Pago==1)
{
	
	//"EJECUTANDO EL PAGO";
	$link=conectarServidor();   
	/*validacion del valor a pagar"*/
	$qryFact="SELECT totalCompra, retefuenteCompra, reteicaCompra FROM compras where idCompra=$id_compra AND tipoCompra=$compra
	union
	SELECT total_fact, retencion_g as retencion, ret_ica FROM gastos where Id_gasto=$id_compra AND compra=$compra;";
	$resultfact=mysqli_query($link, $qryFact);
	$rowfact=mysqli_fetch_array($resultfact);
	$total=$rowfact['total_fact'];
	$retencion=$rowfact['retencion'];
	$ret_ica=$rowfact['ret_ica'];
	$qrytot="select sum(pago) as Parcial from egreso where Id_compra=$id_compra and tip_compra=$compra AND Id_egreso<>$Id_Egreso";
	$resultot=mysqli_query($link, $qrytot);
	$rowtot=mysqli_fetch_array($resultot);
	$parcial=$rowtot['Parcial'];
	$ValTopagar=$parcial + $abono;
	if($ValTopagar>($total-$retencion-$ret_ica))
   	{
		mover_pag("factXpagar.php","El pago sobrepasa el valor de la factura");
   	}
	else
	{
		$qry="update egreso set pago=$abono, Fecha='$fecha', form_pago=$Form_pago, descuento_e=$descuento where Id_egreso=$Id_Egreso";
		$result=mysqli_query($link, $qry);
   		if($result)
		{
			if(($parcial+$abono)==($total-$retencion-$ret_ica))
			{
				if ($compra==6)
					$qryupt="update gastos set estado=7 where Id_gasto=$id_compra";
				else
					$qryupt="update compras set estadoCompra=7 where idCompra=$id_compra";
				$resulupdate=mysqli_query($link, $qryupt);
			}	
			mover_pag("histo_pagos.php", "Pago Aplicado Correctamente");		
		}
		else 
		{
		   	mover_pag("factXpagar.php","Pago No APlicado");
   
   		}
   	}
	mysqli_free_result($resultfact);
	mysqli_free_result($resultot);
	/* cerrar la conexión */
	mysqli_close($link);
   }
  function mover_pag($ruta,$nota)
	{	
	//Funcion que permite el redireccionamiento de los usuarios a otra pagina 
	echo' <script >
	alert("'.$nota.'")
	self.location="'.$ruta.'"
	</script>';
	}
?>

<form method="post" action="egreso1.php" name="form1">
  <table  align="center" border="0" summary="cuerpo">
   <tr>
      <td width="150">&nbsp;</td>
      <td width="233">&nbsp;</td>
      <td width="148">&nbsp;</td>
      <td width="144">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="1"><div align="right"><strong>No. Comprobante:</strong></div></td>
      <td><?php if($Pago==3){ echo $Id_Egreso;} else{ ?>
      <input name="Id_Egreso" type="text" readonly="true" value="<?php echo $egreso; ?>" size="5"> <?php } ?> </td>
      <td><div align="right"><strong>No. de Compra:</strong> </div></td>
      <td><div align="left"><?php echo $id_compra; ?></div></td>
    </tr>
    <tr>
      <td colspan="5"><hr></td>
    </tr>
    <?php
	  	$link=conectarServidor();
	 	$qry="select idCompra, nit_prov, numFact, fechComp, fechVenc, estadoCompra, totalCompra, tipoCompra, Nom_provee, retefuenteCompra, ret_provee, reteicaCompra, subtotalCompra from compras, proveedores
		where idCompra=$id_compra and compras.nit_prov=proveedores.nitProv AND tipoCompra<>6 AND tipoCompra=$compra
		union
		select Id_gasto as Id_compra, nit_prov, Num_fact, Fech_comp, Fech_venc, estado, total_fact, compra, Nom_provee, retencion_g as retencion, ret_provee, ret_ica, Subtotal_gasto as Subtotal from gastos, proveedores
		where Id_gasto=$id_compra and gastos.nit_prov=proveedores.nitProv and compra=6 and compra=$compra;";
		$result=mysqli_query($link, $qry);
		$row=mysqli_fetch_array($result);
		$nit=$row['nit_prov'];
		$qry3="select sum(pago) as Parcial from egreso where Id_compra=$id_compra and tip_compra=$compra";
		$result3=mysqli_query($link, $qry3);
		$row3=mysqli_fetch_array($result3);
		$valTot=$row['total_fact'];
		$retencion=$row['retencion'];
		$ret_ica=$row['ret_ica'];
		$Subtotal=$row['Subtotal'];
		$ret_provee=$row['ret_provee'];
		$valPag=$valTot-$retencion;
		if($row3['Parcial'])
			$parcial=$row3['Parcial'];
		else
			$parcial=0;
		$saldo=$valPag-$parcial-$ret_ica;
		mysqli_free_result($result);
		/* cerrar la conexión */
		mysqli_close($link);
	 ?>
    <tr>
      <td><div align="right"><strong>Proveedor:</strong></div></td>
      <td><?php echo  $row['Nom_provee']?></td>
      <td><div align="right"><strong>Valor Factura:</strong></div></td>
      <td><div align="left"><?php echo '$ <script  > document.write(commaSplit('.$row['total_fact'].'))</script>' ;?> </div></td>
    </tr>
    <tr>
      <td><div align="right"><strong>NIT:</strong></div></td>
      <td><?php echo  $row['nit_prov']?></td>
      <td ><div align="right"><strong>Retefuente:</strong></div></td>
      <td><?php echo '$ <script  > document.write(commaSplit('.$retencion.'))</script>' ;?></td>
      
    </tr>
    <tr>
    <td ><div align="right"><strong>Fecha de Factura:</strong></div></td>
      <td><?php echo $row['Fech_comp'];?></td>
      <td ><div align="right"><strong>Retenci&oacute;n Cree:</strong></div></td>
      <td><?php echo '$ <script  > document.write(commaSplit('.$ret_ica.'))</script>' ;?></td>
      
    </tr>
    <tr>
      <td ><div align="right"><strong>Fecha Vencimiento: </strong></div></td>
      <td><?php echo $row['Fech_venc'];?></td>
      <td ><div align="right"><strong>Valor Cancelado:</strong></div></td>
      <td><?php echo '$ <script  > document.write(commaSplit('.$parcial.'))</script>' ;?></td>
      
    </tr>
    <tr>
    <td><div align="right"><strong>No. de Factura:</strong></div></td>
      <td><?php echo  $row['Num_fact']?></td>
      <td><div align="right"><strong>Valor Pendiente:</strong></div></td>
      <td><div align="left"><?php echo '$ <script  > document.write(commaSplit('.$saldo.'))</script>' ;?> </div></td>
    </tr>
    <tr>
      <td colspan="4"><hr></td>
    </tr>
    <tr>
    	<td><div align="center"><strong>Fecha del Pago</strong></div></td>
        <td><div align="center"><strong>Forma de Pago</strong></div></td>
      	<td><div align="center"><strong>Valor a Cancelar</strong></div></td>
        <td><div align="center"><strong>Descuento</strong></div></td>
    </tr>
       <tr>
      	<td><div align="center"><input type="text" name="fecha" id="sel1" readonly size=10 value="<?php echo $fecha_e; ?>"><input type="reset" value=" ... " onclick="return showCalendar('sel1', '%Y-%m-%d', '12', true);"></div></td>
      	<td><div align="center">
        	<?php
			$link=conectarServidor();
			echo'<select name="Form_pago" id="combo">';
			$result=mysqli_query($link, "select Id_fpago, forma_pago from form_pago where Id_fpago<>2;");
			echo '<option selected value='.$form_pago.'>'.$forma_pago.'</option>';
			while($row=mysqli_fetch_array($result))
			{	
				if($row['Id_fpago']!=$form_pago)
				echo '<option value='.$row['Id_fpago'].'>'.$row['forma_pago'].'</option>';
			}
			echo'</select>';
			mysqli_close($link);
		?> 
        </div></td>
     	<td><div align="center"><input name="abono" type="text" size=20 value ="<?php echo $pago; ?>" onKeyPress="return aceptaNum(event)"></div></td>
        <td><div align="center"><input name="descuento" type="text" size=20 value ="<?php echo $descuento_e; ?>" onKeyPress="return aceptaNum(event)"></div></td>
    </tr>
    <tr><td colspan="4"><div align="right"><input name="submit"  onClick="return Enviar(this.form)" type="submit"  value="Continuar" <?php if($Pago==3) echo "disabled"; ?>></div> <input name="Pago" type="hidden" value="1">
	<?php 
	echo'<input name="id_compra" type="hidden" value="'.$id_compra.'">'; 
	echo'<input name="compra" type="hidden" value="'.$compra.'">'; 
	?></td></tr>
    <tr>
      <td colspan="5" align="right">
           </td>
    </tr>
   
 
  </table>
</form>

<p></p>
</div>
</body>
</html>