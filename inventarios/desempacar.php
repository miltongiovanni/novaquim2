<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Convertir Pacas de Producto a Unidades</title>
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
<div id="saludo"><strong>DESEMPACAR PACAS A UNIDADES</strong></div>
<table width="700" align="center" border="0">
    <?php
		include "includes/conect.php";
		$link=conectarServidor();  
		echo '<form method="post" action="unpack.php" name="form1">
		<tr>
		<td><div align="right"><strong>Producto de Distribuci&oacute;n Empacado:</strong></div></td>
		<td colspan="1" ><div align="left">';
		echo'<select name="cod_paca">';
		$qry="select inv_distribucion.Id_distribucion, Producto from distribucion, rel_dist_emp, inv_distribucion 
		WHERE inv_distribucion.Id_distribucion=Cod_paca and inv_distribucion.Id_distribucion=distribucion.Id_distribucion and inv_dist>0 order by Producto;";
		$result=mysqli_query($link,$qry);
		while($row=mysqli_fetch_array($result))
		{
			echo '<option value='.$row['Id_distribucion'].'>'.$row['Producto'].'</option>';
		}
		echo '</select>';
		mysqli_close($link);
		echo '</div></td>';
		echo '</tr>
			<tr>
				<td><div align="right"><strong>Cantidad:</strong></div></td>
				<td><div align="left"><input name="Unidades" type="text" size="30" onKeyPress="return aceptaNum(event)"></div></td>
			</tr>
			<tr><td></td><td align="right"><input name="button" onclick="return Enviar(this.form)" type="submit" value="Desempacar"></td><input name="Crear" type="hidden" value="0">
			</tr>
			</form>';
	?>
</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
</body>
</html>
	   