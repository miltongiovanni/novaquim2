<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Actualizar Compra de V&aacute;lvulas o Tapas</title>
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>
	<script >
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<p align="center"><img src="images/LogoNova1.JPG" border="0" /></p>
<p align="center">&nbsp;</p>
<p align="center" class="titulo">ACTUALIZACI&Oacute;N DE LA COMPRA DE V&Aacute;LVULAS O TAPAS</p>
<table width="32%" border="0" align="center">
  <tr>
    <td width="86%" class="titulo"><div align="center">V&aacute;lvula o Tapa</div></td>
    <td width="14%" class="titulo"><div align="center">Cantidad</div></td>
  </tr>
  <form action="updateComVal.php" method="post" name="actualiza">
  <?php
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
	$link=conectarServidor();
	$qry="select idCompra, nom_tapa, Codigo, Cantidad FROM det_compras, tapas_val where idCompra=$Factura AND Codigo=$codigo and Codigo=Cod_tapa;";
	$result=mysql_db_query("novaquim",$qry);
	$row=mysql_fetch_array($result);
	$codigo=$row['Codigo'];
	$producto=$row['nom_tapa'];
	$cant_val=$row['Cantidad'];
	echo '<input name="Factura" type="hidden" value="'.$Factura.'"/>';
	echo '<tr>';
	echo '<td align="center">';
 	echo $producto;
	echo '<input name="codigo" type="hidden" value="'.$codigo.'"/>';
 	echo '</td>';	
	echo '<td align="center">';
 	echo'<input size=5 name="cantidad" type="text" align="center" value="'.round($cant_val).'"/>';
 	echo '</td>';	
	echo '<input name="cant_ant" type="hidden" value="'.$cantidad.'"/>';
	echo '</tr>';
	mysql_close($link);
	?>
    <p>&nbsp;</p>
	<tr bordercolor="0">
    	<td>&nbsp;</td>
    	<td>&nbsp;</div></td>
	</tr>
	<tr bordercolor="#33CC99">
   	  <td colspan="2"><div align="center"><input type="submit" name="Submit" value="Cambiar" /></div></td>
	</tr>
  </form>
</table>
</body>
</html>
