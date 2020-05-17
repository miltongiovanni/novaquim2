<?php
include "../includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Actualizar Cotización Personalizada</title>
<script  src="../js/validar.js"></script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ACTUALIZACIÓN DEL PRODUCTO EN LA COTIZACIÓN</strong></div>
<form action="updateCotP.php" method="post" name="actualiza">
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
		$qry="SELECT Cod_producto as Codigo, Nombre as Producto, Can_producto as Cantidad, Prec_producto as Precio from det_cot_personalizada, prodpre 
		where Cod_producto=Cod_prese and Id_cot_per=$cotizacion AND Cod_producto=$producto;";
	}
	else
	{
		$qry="SELECT Cod_producto as Codigo, Producto, Can_producto as Cantidad, Prec_producto as Precio from det_cot_personalizada, distribucion 
		where Cod_producto=Id_distribucion and Id_cot_per=$cotizacion AND Cod_producto=$producto;";
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
	echo '<input name="producto" type="hidden" value="'.$cod.'"><input name="cotizacion" type="hidden" value="'.$cotizacion.'">';
 	echo '</td>';	
	echo '<td align="center">';
 	echo'<input size=5 name="cantidad" type="text" align="right" value="'.$cantidad.'">';
 	echo '</td>';
	echo '<td align="center">';
 	echo'<input size=5 name="precio" type="text" align="right" value="'.$prec.'">';
 	echo '</td>';	
	echo '</tr>';
	mysqli_free_result($result);
/* cerrar la conexión */
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
