<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Actualizar Compra de Productos de Distribuci&oacute;n</title>
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>
	<script >
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ACTUALIZACI&Oacute;N DE LA COMPRA DE PRODUCTOS DE DISTRIBUCI&Oacute;N</strong></div>
<table border="0" align="center">
  <tr>
    <td width="481"><div align="center"><strong>Producto</strong></div></td>
    <td width="108"><div align="center"><strong>Cantidad</strong></div></td>
    <td width="77"><div align="center"><strong>Precio</strong></div></td>
  </tr>
  <form action="updateComDist.php" method="post" name="actualiza">
  <?php
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
	$link=conectarServidor();
	$qry="select Codigo, Producto, Cantidad, Precio from det_compras, distribucion WHERE idCompra=$factura and Codigo=$codigo AND 	Codigo=Id_distribucion;";
	$result=mysqli_query($link, $qry);
	$row=mysqli_fetch_array($result);
	$codigo=$row['Codigo'];
	$producto=$row['Producto'];
	$cantidad=$row['Cantidad'];
	$Precio=$row['Precio'];
	echo '<input name="factura" type="hidden" value="'.$factura.'"/>';
	echo '<tr>';
	echo '<td align="center">';
 	echo $producto;
	echo '<input name="codigo" type="hidden" value="'.$codigo.'"/>';
 	echo '</td>';	
	echo '<td align="center">';
 	echo'<input size=8 name="cantidad" type="text" align="center" value="'.round($cantidad).'"/>';
 	echo '</td>';	
	echo '<input name="cant_ant" type="hidden" value="'.$cantidad.'"/>';
	echo '<td align="center">';
 	echo'<input size=8 name="Precio" type="text" align="center" value="'.$Precio.'"/>';
 	echo '</td>';	

	echo '</tr>';
	mysqli_free_result($result);
	mysqli_close($link);
	?>
	<tr >
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
	</tr>
	<tr>
   	  <td colspan="3"><div align="right"><input type="submit" name="Submit" value="Cambiar"></div></td>
	</tr>
  </form>
</table>
</div>
</body>
</html>
