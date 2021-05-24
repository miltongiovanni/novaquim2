<?php
include "../includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Actualizar Compra de Envase</title>
<script  src="../js/validar.js"></script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ACTUALIZACIÓN DE LA COMPRA DE ENVASE Y TAPAS</strong></div>
<table border="0" align="center">
  <tr>
    <td width="61"><div align="center"><strong>Código</strong></div></td>
    <td width="297"><div align="center"><strong>Producto</strong></div></td>
    <td width="80"><div align="center"><strong>Cantidad</strong></div></td>
    <td width="81"><div align="center"><strong>Precio</strong></div></td>
  </tr>
  <form action="updateComEnv.php" method="post" name="actualiza">
  <?php
	foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
	$link=conectarServidor();
	if($codigo<100)
	{
		$qry="select idCompra, Codigo, Nom_envase, Cantidad, Precio from det_compras, envase where idCompra=$Factura and Codigo=$codigo and Codigo=Cod_envase;";
		$result=mysqli_query($link,$qry);
		$row=mysqli_fetch_array($result);
		$codigo=$row['Codigo'];
		$producto=$row['Nom_envase'];
		$cant_env=$row['Cantidad'];
		$Precio=$row['Precio'];
		echo '<input name="Factura" type="hidden" value="'.$Factura.'">';
		echo '<tr>';
		echo '<td align="center">';
		echo $codigo;
		echo '</td>';
		echo '<td align="center">';
		echo $producto;
		echo '<input name="codigo" type="hidden" value="'.$codigo.'">';
		echo '</td>';	
		echo '<td align="center">';
		echo'<input size=5 name="cantidad" type="text" align="center" value="'.round($cant_env).'">';
		echo '</td>';	
		echo '<input name="cant_ant" type="hidden" value="'.$cantidad.'">';
		echo '<td align="center">';
		echo '<input size=5 name="Precio" type="text" align="center" value="'.$Precio.'">';
		echo '</td>';
		echo '</tr>';
	}
	else
	{
		$qry="select idCompra, nom_tapa, Codigo, Cantidad, Precio FROM det_compras, tapas_val where idCompra=$Factura AND Codigo=$codigo and Codigo=Cod_tapa;";
		$result=mysqli_query($link,$qry);
		$row=mysqli_fetch_array($result);
		$codigo=$row['Codigo'];
		$producto=$row['nom_tapa'];
		$cant_val=$row['Cantidad'];
		$Precio=$row['Precio'];
		echo '<input name="Factura" type="hidden" value="'.$Factura.'">';
		echo '<tr>';
		echo '<td align="center">';
		echo $codigo;
		echo '</td>';
		echo '<td align="center">';
		echo $producto;
		echo '<input name="codigo" type="hidden" value="'.$codigo.'">';
		echo '</td>';	
		echo '<td align="center">';
		echo'<input size=5 name="cantidad" type="text" align="center" value="'.round($cant_val).'">';
		echo '</td>';	
		echo '<input name="cant_ant" type="hidden" value="'.$cantidad.'">';
		echo '<td align="center">';
		echo'<input size=5 name="Precio" type="text" align="center" value="'.$Precio.'">';
		echo '</td>';
		echo '</tr>';
	}
	mysqli_free_result($result);
	mysqli_close($link);
	?>
	<tr>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
	</tr>
	<tr>
   	  <td colspan="3"><div align="center"><input type="submit" name="Submit" value="Cambiar" ></div></td>
	</tr>
  </form>
</table>
</div>
</body>
</html>
