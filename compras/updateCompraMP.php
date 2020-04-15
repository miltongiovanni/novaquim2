<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Actualizar Compra de Materia Prima</title>
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>
	<script >
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ACTUALIZACI&Oacute;N DE LA COMPRA DE MATERIA PRIMA</strong></div>
<table border="0" align="center">
  <tr>
    <td width="379"><div align="center"><strong>Producto</strong></div></td>
    <td width="62"><div align="center"><strong>Cantidad</strong></div></td>
    <td width="65"><div align="center"><strong>Precio</strong></div></td>
  </tr>
  <form action="updateComMP.php" method="post" name="actualiza">
  <?php
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
	$link=conectarServidor();
	$qry="SELECT Id_compra, Codigo, Nom_mprima, Cantidad, Lote, Precio from det_compras, mprimas where Id_compra=$Factura and Codigo=$codigo and Codigo=Cod_mprima;";
	$result=mysqli_query($link,$qry);
	$row=mysqli_fetch_array($result);
	$codigo=$row['Codigo'];
	$producto=$row['Nom_mprima'];
	$cant_mp=$row['Cantidad'];
	$lote_mp=$row['Lote'];
	$Precio=$row['Precio'];
	echo '<input name="Factura" type="hidden" value="'.$Factura.'"/>';
	echo '<tr>';
	echo '<td align="center">';
 	echo $producto;
	echo '<input name="codigo" type="hidden" value="'.$codigo.'"/>';
	echo '<input name="lote_mp" type="hidden" value="'.$lote_mp.'"/>';
 	echo '</td>';	
	echo '<td align="center">';
 	echo '<input size=10 name="cantidad" type="text" align="center" value="'.$cant_mp.'"/>';
	echo '</td>';
	echo '<input name="cant_ant" type="hidden" value="'.$cantidad.'"/>';
	echo '<td align="center">';
 	echo '<input size=10 name="Precio" type="text" align="center" value="'.$Precio.'"/>';
 	echo '</td>';
	echo '</tr>';
	mysqli_free_result($result);
	mysqli_close($link);
	?>
	<tr bordercolor="0">
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
	</tr>
	<tr bordercolor="#33CC99">
   	  <td colspan="3"><div align="right"><input type="submit" name="Submit" value="Cambiar" /></div></td>
	</tr>
  </form>
</table>
</div>
</body>
</html>
