<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Actualizar datos del Pedido</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ACTUALIZACI&Oacute;N DEL PRODUCTO EN EL PEDIDO</strong></div>
<form action="updatePed.php" method="post" name="actualiza">
<table width="55%" border="0" align="center" summary="cuerpo">
  <tr>
    <td width="69%" class="titulo"><div align="center">Producto</div></td>
    <td width="18%" class="titulo"><div align="center">Cantidad</div></td>
    <td width="13%" class="titulo"><div align="center">Precio</div></td>
  </tr>
  
  <?php
	$link=conectarServidor();
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
	if ($producto < 100000)
	{
		$qry="select Cod_producto as Codigo, DesServicio as Producto, Can_producto as Cantidad, Prec_producto as Precio from det_pedido, servicios where Cod_producto=IdServicio and Id_ped=$pedido AND Cod_producto=$producto;";
	}
	if (($producto < 100000)&&($producto > 100))
	{
		$qry="SELECT Cod_producto as Codigo, Nombre as Producto, Can_producto as Cantidad, Prec_producto as Precio from det_pedido, prodpre 
		where Cod_producto=Cod_prese and Id_ped=$pedido AND Cod_producto=$producto;";
	}
	if ($producto >= 100000)
	{
		$qry="SELECT Cod_producto as Codigo, Producto, Can_producto as Cantidad, Prec_producto as Precio from det_pedido, distribucion 
		where Cod_producto=Id_distribucion and Id_ped=$pedido AND Cod_producto=$producto;";
	}
	$result=mysqli_query($link,$qry);
	$row=mysqli_fetch_array($result);
	$cod=$row['Codigo'];
	$producto=$row['Producto'];
	$cantidad=$row['Cantidad'];
	$prec=$row['Precio'];
	echo '<tr>';
	echo '<td align="center">';
 	echo $producto;
	echo '<input name="producto" type="hidden" value="'.$cod.'"><input name="pedido" type="hidden" value="'.$pedido.'"><input name="sobre" type="hidden" value="'.$sobre.'">';
 	echo '</td>';	
	echo '<td align="center">';
 	echo'<input size=5 name="cantidad" type="text" align="right" value="'.$cantidad.'">';
 	echo '</td>';
	echo '<td align="center">';
 	echo'<input size=5 name="precio" type="text" align="right" value="'.$prec.'">';
 	echo '</td>';	
	echo '</tr>';
	mysqli_close($link);
	?>
	<tr>
    	<td>&nbsp;</td>
        <td>&nbsp;</td>
    	<td>&nbsp;</td>
	</tr>
	<tr>
   	  <td colspan="3"><div align="center"><input type="submit" name="Submit" value="Cambiar"></div></td>
	</tr>
  
</table>
</form>
</div>
</body>
</html>
