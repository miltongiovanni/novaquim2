<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Organizar Unidades en Pacas</title>
	<meta charset="utf-8">
	<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="../js/validar.js"></script>
	<script  src="scripts/block.js"></script>
    <link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue">
    <script  src="scripts/calendar.js"></script>
    <script  src="scripts/calendar-sp.js"></script>
    <script  src="scripts/calendario.js"></script>
    <script >
		document.onkeypress = stopRKey; 
	</script>
</head>
<body> 
<div id="contenedor">
<div id="saludo"><strong>ORGANIZAR UNIDADES EN PACAS</strong></div>
<table width="50%"  align="center" border="0">
    <?php
		include "includes/conect.php";
		$link=conectarServidor();  
		echo '<form method="post" action="pack.php" name="form1">
		 <tr><td><div align="right"><strong>Unidades de Producto sin empacar:</strong></div></td>
		<td colspan="1" ><div align="left">';
		echo'<select name="cod_unidad">';
		$qry="select inv_distribucion.Id_distribucion, Producto from distribucion, rel_dist_emp, inv_distribucion 
		WHERE inv_distribucion.Id_distribucion=codUnidad and inv_distribucion.Id_distribucion=distribucion.Id_distribucion and invDistribucion>0 order by Producto;";
		$result=mysqli_query($link,$qry);
		while($row=mysqli_fetch_array($result))
		{
			echo '<option value='.$row['Id_distribucion'].'>'.$row['Producto'].'</option>';
		}
		echo '</select>';
		echo '</div></td>';
		echo '</tr>
			  <tr>
				<td><div align="right"><strong>Cantidad:</strong></div></td>
				<td><div align="left"><input name="Unidades" type="text" size="30" onKeyPress="return aceptaNum(event)"></div></td>
			</tr>
			<tr><td></td><td align="right"><input name="button" onclick="return Enviar(this.form)" type="submit"  value="Empacar"></td><input name="Crear" type="hidden" value="0">
			</tr>
			</form>';
		mysqli_close($link);
	?>
</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div>
</div>
</body>
</html>
	   