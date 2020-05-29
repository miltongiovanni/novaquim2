<?php
include "../includes/valAcc.php";
include "includes/conect.php";
//echo $_SESSION['Perfil'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Actualizar datos de Presentación de Producto</title>
<script  src="../js/validar.js"></script>
<script  src="scripts/block.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ACTUALIZACIÓN DE GASTO DE MATERIA PRIMA</strong></div>
<table width="34%" border="0" align="center">
  <tr>
    <td width="44%"><div align="center"><strong>Materia Prima</strong></div></td>
    <td width="23%"><div align="center"><strong>Lote MP</strong></div></td>
    <td width="33%"><div align="center"><strong>Gasto de MP</strong></div></td>
  </tr>
  <form action="updateOrd.php" method="post" name="actualiza">
  <?php
	$link=conectarServidor();
	$Lote=$_POST['Lote'];
	$cod_mprima=$_POST['mprima'];
	$gasto=$_POST['gasto'];
	$lote_mp=$_POST['lote_mp'];
	$qry="SELECT Nom_mprima, cantidadMPrima, det_ord_prod.codMPrima as codigo, loteMP, Cod_nvo_mprima, alias FROM det_ord_prod, mprimas 
	WHERE Lote=$Lote AND det_ord_prod.codMPrima=mprimas.Cod_mprima and det_ord_prod.codMPrima=$cod_mprima and loteMP='$lote_mp';";
	$result=mysqli_query($link,$qry);
	$row=mysqli_fetch_array($result);
	$codmp=$row['codigo'];
	$mprima=$row['Nom_mprima'];
	$gasto=$row['Can_mprima'];
	$alias=$row['alias'];
	echo '<input name="Lote" type="hidden" value="'.$Lote.'">';
	echo '<tr>';
	echo '<td align="center">';
 	echo $alias;
	echo '<input name="mprima" type="hidden" value="'.$cod_mprima.'">';
 	echo '</td>';	
	echo '<td align="center">';
	echo '<input name="lote_mp" type="hidden" value="'.$lote_mp.'">';
 	echo $lote_mp;
 	echo '</td>';
	echo '<td align="center">';
	echo '<input name="gasto_ant" type="hidden" value="'.$gasto.'">';
 	echo'<input size=10 name="gasto" type="text" value="'.$gasto.'">';
 	echo '</td>';	
	echo '</tr>';
	mysqli_free_result($result);
	/* cerrar la conexión */
	mysqli_close($link);
	?>
	<tr>
	</tr>
	<tr>
   	  <td colspan="3"><div align="center"><input type="submit" name="Submit" value="Cambiar" ></div></td>
	</tr>
  </form>
</table>
</div>
</body>
</html>
