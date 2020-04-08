<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Pago de Facturas de Compra y de Gastos</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue">
    <script type="text/javascript" src="scripts/calendar.js"></script>
    <script type="text/javascript" src="scripts/calendar-sp.js"></script>
    <script type="text/javascript" src="scripts/calendario.js"></script>
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body> 
<div id="contenedor">
<div id="saludo1"><strong>COMPROBANTE DE EGRESO POR FACTURAS DE COMPRA Y GASTOS</strong></div>
<?php
include "includes/conect.php";
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
if($Pago==0)
{
	$link=conectarServidor();   
	$qrycam="select MAX(Id_egreso) AS Egreso from egreso;";
	$resultqrycam=mysqli_query($link, $qrycam);
	$row_cam=mysqli_fetch_array($resultqrycam);
	$egreso=$row_cam['Egreso']+1;   
}
if($Pago==3)
{
	$link=conectarServidor();   
	$qrycam="select MAX(Id_egreso) AS Egreso from egreso;";
	$resultqrycam=mysqli_query($link, $qrycam);
	$row_cam=mysqli_fetch_array($resultqrycam);
	$egreso=$row_cam['Egreso'];   
}
if($Pago==4)
{
	$link=conectarServidor();   
	$qryb="select Id_compra, tip_compra, pago, Fecha, descuento_e, form_pago from egreso where Id_egreso=$egreso;";
	$resultb=mysqli_query($link, $qryb);
	$row_b=mysqli_fetch_array($resultb);
	$id_compra=$row_b['Id_compra'];   
	$compra=$row_b['tip_compra'];
}
if($Pago==1)
{
	
	//"EJECUTANDO EL PAGO";
	$link=conectarServidor();   
	/*validacion del valor a pagar"*/
	$qryFact="SELECT total_fact, retencion, ret_ica FROM compras where Id_compra=$id_compra AND compra=$compra
	union
	SELECT total_fact, retencion_g as retencion, ret_ica FROM gastos where Id_gasto=$id_compra AND compra=$compra;";
	$resultfact=mysqli_query($link, $qryFact);
	$rowfact=mysqli_fetch_array($resultfact);
	$total=$rowfact['total_fact'];
	$retencion=$rowfact['retencion'];
	$ret_ica=$rowfact['ret_ica'];
	$qrytot="select sum(pago) as Parcial from egreso where Id_compra=$id_compra and tip_compra=$compra";
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
		$qry="insert into egreso (Id_egreso, Id_compra, tip_compra, pago, Fecha,form_pago, descuento_e) values($Id_Egreso, $id_compra, $compra, $abono, '$fecha', $Form_pago, $descuento)";
		$result=mysqli_query($link, $qry);
   		if($result)
		{
			if(($parcial+$abono)==($total-$retencion-$ret_ica))
			{
				if ($compra==6)
					$qryupt="update gastos set estado=7 where Id_gasto=$id_compra";
				else
					$qryupt="update compras set estado=7 where Id_compra=$id_compra";
				$resulupdate=mysqli_query($link, $qryupt);
			}
			echo' <script >
			alert("Pago Aplicado Correctamente");
			</script>';
			echo '<form id="form7" name="form7" method="post" action="egreso.php">	
                   <input type="text" name="Id_Egreso" value="'.$Id_Egreso.'" >
				   <input type="hidden" name="Pago" value="3">
				   <input name="id_compra" type="hidden" value="'.$id_compra.'"> 
				   <input name="compra" type="hidden" value="'.$compra.'">
                   <td align="left"><input type="button" value="      Continuar      " >
				   </form> ';
					echo'<script >
							document.form7.submit();
							</script>';
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

<form method="post" action="egreso.php" name="form1">
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
	 	$qry="select Id_compra, nit_prov, Num_fact, Fech_comp, Fech_venc, estado, total_fact, compra, Nom_provee, retencion, ret_provee, ret_ica, Subtotal from compras, proveedores
		where Id_compra=$id_compra and compras.nit_prov=proveedores.NIT_provee AND compra<>6 AND compra=$compra
		union
		select Id_gasto as Id_compra, nit_prov, Num_fact, Fech_comp, Fech_venc, estado, total_fact, compra, Nom_provee, retencion_g as retencion, ret_provee, ret_ica, Subtotal_gasto as Subtotal from gastos, proveedores
		where Id_gasto=$id_compra and gastos.nit_prov=proveedores.NIT_provee and compra=6 and compra=$compra;";
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
      <td><div align="left"><?php echo '$ <script  type="text/javascript"> document.write(commaSplit('.$row['total_fact'].'))</script>' ;?> </div></td>
    </tr>
    <tr>
      <td><div align="right"><strong>NIT:</strong></div></td>
      <td><?php echo  $row['nit_prov']?></td>
      <td ><div align="right"><strong>Retefuente:</strong></div></td>
      <td><?php echo '$ <script  type="text/javascript"> document.write(commaSplit('.$retencion.'))</script>' ;?></td>
      
    </tr>
    <tr>
    <td ><div align="right"><strong>Fecha de Factura:</strong></div></td>
      <td><?php echo $row['Fech_comp'];?></td>
      <td ><div align="right"><strong>Retenci&oacute;n Ica:</strong></div></td>
      <td><?php echo '$ <script  type="text/javascript"> document.write(commaSplit('.$ret_ica.'))</script>' ;?></td>
      
    </tr>
    <tr>
      <td ><div align="right"><strong>Fecha Vencimiento: </strong></div></td>
      <td><?php echo $row['Fech_venc'];?></td>
      <td ><div align="right"><strong>Valor Cancelado:</strong></div></td>
      <td><?php echo '$ <script  type="text/javascript"> document.write(commaSplit('.$parcial.'))</script>' ;?></td>
      
    </tr>
    <tr>
    <td><div align="right"><strong>No. de Factura:</strong></div></td>
      <td><?php echo  $row['Num_fact']?></td>
      <td><div align="right"><strong>Valor Pendiente:</strong></div></td>
      <td><div align="left"><?php echo '$ <script  type="text/javascript"> document.write(commaSplit('.$saldo.'))</script>' ;?> </div></td>
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
      	<td><div align="center"><input type="text" name="fecha" id="sel1" readonly size=10><input type="reset" value=" ... " onclick="return showCalendar('sel1', '%Y-%m-%d', '12', true);"></div></td>
      	<td><div align="center"><select name="Form_pago"><option value=0>Efectivo</option>
      	  <option value="1">Transferencia</option>
      	  <option value="2">Nota Cr&eacute;dito</option>
      	  <option value="3">Consignaci&oacute;n</option>
      	  <option value="4">Cheque</option>
        </select></div></td>
     	<td><div align="center"><input name="abono" type="text" size=20 value ="<?php echo $saldo; ?>" onKeyPress="return aceptaNum(event)"></div></td>
        <td><div align="center"><input name="descuento" type="text" size=20 value ="0" onKeyPress="return aceptaNum(event)"></div></td>
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
<div align="center">
<form action="Imp_Egreso.php" method="post" target="_blank"><input name="egreso" type="hidden" value="<?php echo $egreso; ?>"><input name="Submit" type="submit" value="Imprimir" <?php if(($Pago!=3)&&($Pago!=4)) echo "disabled"; ?> ></form></div>

<table border="0" align="center" summary="detalle"> 
<tr>
  <td height="8" colspan="5"><hr></td>
</tr>
<tr>
<td  colspan="5" class="titulo">Detalle de Pagos : </td>
</tr>
<tr>
    <th width="81">No. Pago</th>
    <th width="101">Fecha</th>
    <th width="112">Pago</th>
</tr>
<tr>
	<td colspan="8"><hr></td>
</tr>
<?php
$link=conectarServidor();
$qry="select Id_egreso, Tip_compra, pago, Fecha from egreso where Id_compra=$id_compra and tip_compra=$compra;";
$result=mysqli_query($link, $qry);
$i=1;
while($row=mysqli_fetch_array($result))
{
	//$factura=$row['Id'];
	$abono=$row['pago'];
	$fecha=$row['Fecha'];
	echo'<tr>
	<td><div align="center">'.$i.'</div></td>
	<td><div align="center">'.$fecha.'</div></td>
	<td><div align="center">$ <script  type="text/javascript"> document.write(commaSplit('.$abono.'))</script></div></td>
	</tr>';
	$i++;
}
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
?>
    <tr>
      <td colspan="8"><hr></td>
    </tr>
  </table>

<div align="center"><input type="button" class="resaltado" onClick="window.location='factXpagar.php'" value="Terminar"></div>
</div>
</body>
</html>