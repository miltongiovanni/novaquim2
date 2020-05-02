<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Actualizar Compra de Etiquetas</title>
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>
	<script >
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>

<div id="contenedor">
<div id="saludo1"><strong>ACTUALIZACI&Oacute;N DE LA COMPRA DE ETIQUETAS</strong></div> 

<table width="37%" border="0" align="center">
  <tr>
    <td width="80%" class="titulo"><div align="center">Producto</div></td>
    <td width="10%" class="titulo"><div align="center">Cantidad</div></td>
    <td width="10%" class="titulo"><div align="center">Precio</div></td>
  </tr>
  <form action="updateComEtq.php" method="post" name="actualiza">
  <?php
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
	$link=conectarServidor();
	$qry="select Codigo, Nom_etiq, Cantidad, Precio from det_compras, etiquetas where idCompra=$factura and Codigo=$codigo AND Codigo=Cod_etiq;";
	$result=mysqli_query($link,$qry);
	$row=mysqli_fetch_array($result);
	$codigo=$row['Codigo'];
	$Precio=$row['Precio'];
	$producto=$row['Nom_etiq'];
	$cantidad=$row['Cantidad'];
	echo '<input name="factura" type="hidden" value="'.$factura.'"/>';
	echo '<tr>';
	echo '<td align="center">';
 	echo $producto;
	echo '<input name="codigo" type="hidden" value="'.$codigo.'"/>';
 	echo '</td>';	
	echo '<td align="center">';
 	echo'<input size=5 name="cantidad" type="text" align="center" value="'.round($cantidad).'"/>';
 	echo '<input name="cant_ant" type="hidden" value="'.$cantidad.'"/>';
	echo '</td>';	
	echo '<td align="center">';
 	echo'<input size=5 name="Precio" type="text" align="center" value="'.round($Precio).'"/>';
 	echo '</td>';
	echo '</tr>';
	$row=mysqli_fetch_array($result);
	mysqli_close($link);
	?>
	<tr bordercolor="0">
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
        <td>&nbsp;</td>
	</tr>
	<tr bordercolor="#33CC99">
   	  <td colspan="2"><div align="center"><input type="submit" name="Submit" value="Cambiar" /></div></td>
	</tr>
  </form>
</table>
</div>
</body>
</html>
