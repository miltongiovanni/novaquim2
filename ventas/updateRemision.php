<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Actualizar datos del Pedido</title>
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>
	<script >
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ACTUALIZACI&Oacute;N DEL PRODUCTO EN EL PEDIDO</strong></div>
<table border="0" align="center">
  <tr>
    <td width="359"><div align="center"><strong>Producto</strong></div></td>
    <td width="86"><div align="center"><strong>Cantidad</strong></div></td>
  </tr>
  <form action="updateRem.php" method="post" name="actualiza">
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
		$qry="select Id_remision, Cod_producto as Codigo, Lote_producto, Nombre as Producto, sum(Can_producto) as Cantidad from det_remision1, prodpre where Id_remision=$remision and Cod_producto=$producto and Cod_producto=Cod_prese";
	}
	else
	{
		$qry="SELECT Cod_producto as Codigo, Producto, Can_producto as Cantidad, Lote_producto from det_remision1, distribucion 
		where Cod_producto=Id_distribucion and Id_remision=$remision AND Cod_producto=$producto;";
	}		
	$result=mysqli_query($link,$qry);
	$row=mysqli_fetch_array($result);
	$cod=$row['Codigo'];
	$producto=$row['Producto'];
	$cantidad=$row['Cantidad'];
	$lote=$row['Lote_producto'];
	mysqli_close($link);
	echo '<input name="remision" type="hidden" value="'.$remision.'">';
	echo '<input name="lote" type="hidden" value="'.$lote.'">';
	echo '<input name="cant_ant" type="hidden" value="'.$cantidad.'">';
	echo '<tr>';
	echo '<td align="center">';
 	echo $producto;
	echo '<input name="producto" type="hidden" value="'.$cod.'">';
 	echo '</td>';	
	echo '<td align="center">';
 	echo'<input size=5 name="cantidad" type="text" align="right" value="'.$cantidad.'">';
 	echo '</td>';
	echo '</tr>';
	?>
	<tr >
    	<td>&nbsp;</td>
        <td>&nbsp;</td>
	</tr>
	<tr >
   	  <td colspan="2"><div align="center"><input type="submit" name="Submit" value="Cambiar"></div></td>
	</tr>
  </form>
</table>
</div>
</body>
</html>
