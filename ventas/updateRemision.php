<?php
include "../includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Actualizar datos del Pedido</title>
<script  src="../js/validar.js"></script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ACTUALIZACIÓN DEL PRODUCTO EN EL PEDIDO</strong></div>
<table border="0" align="center">
  <tr>
    <td width="359"><div align="center"><strong>Producto</strong></div></td>
    <td width="86"><div align="center"><strong>Cantidad</strong></div></td>
  </tr>
  <form action="updateRem.php" method="post" name="actualiza">
  <?php
	$link=conectarServidor();
	foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
	if ($producto < 100000)
	{
		$qry="select idRemision, codProducto as Codigo, loteProducto, Nombre as Producto, sum(cantProducto) as Cantidad from det_remision1, prodpre where idRemision=$remision and codProducto=$producto and codProducto=Cod_prese";
	}
	else
	{
		$qry="SELECT codProducto as Codigo, Producto, cantProducto as Cantidad, loteProducto from det_remision1, distribucion 
		where codProducto=Id_distribucion and idRemision=$remision AND codProducto=$producto;";
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
