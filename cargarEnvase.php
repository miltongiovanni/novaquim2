<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Cargar Envase como Producto de Distribuci&oacute;n</title>
	<meta charset="utf-8">
	<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>
    <link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue">
    <script type="text/javascript" src="scripts/calendar.js"></script>
    <script type="text/javascript" src="scripts/calendar-sp.js"></script>
    <script type="text/javascript" src="scripts/calendario.js"></script>
    <script type="text/javascript">
		document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>CARGAR ENVASE AL INVENTARIO DE DISTRIBUCI&Oacute;N</strong></div> 
<table width="40%"  align="center" border="0">
    <?php
		include "includes/conect.php";
		$link=conectarServidor();  
		echo '<form method="post" action="charge.php" name="form1">
		 <tr><td width="50%"><div align="right"><strong>Envase:</strong></div></td>
		<td width="50%" ><div align="left">';
		echo'<select name="cod_dist">';
		$qry="select Dist, Producto from rel_env_dis, distribucion WHERE Dist=Id_distribucion;";
		$result=mysqli_query($link,$qry);
		while($row=mysqli_fetch_array($result))
		{
			echo '<option value='.$row['Dist'].'>'.$row['Producto'].'</option>';
		}
		echo '</select>';
		echo '</div></td>';
		echo '</tr>
			  <tr>
				<td><div align="right"><strong>Cantidad:</strong></div></td>
				<td><div align="left"><input name="Unidades" type="text" size="35" onKeyPress="return aceptaNum(event)" ></div></td>
			</tr>
			<tr><td colspan="2"align="right"><input name="button" onclick="return Enviar(this.form)" type="submit"  value="Cargar" /></td><input name="Crear" type="hidden" value="0">
			</tr>
			</form>';
		mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
	?>
</table>
<table width="27%" border="0" align="center">
    <tr> 
        <td><div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
        </div></td>
    </tr>
</table> 
</div>
</body>
</html>
	   