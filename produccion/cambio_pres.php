<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ingreso de Compra de Materia Prima</title>
	<meta charset="utf-8">
	<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="scripts/validar.js"></script>
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
<div id="saludo"><strong>CAMBIO DE PRESENTACI&Oacute;N DE PRODUCTO</strong></div>
<form method="post" action="det_cambio_pres.php" name="form1">
	<table  align="center" border="0">
		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>
	  <tr>
		<td width="143" align="right" ><strong>Fecha del Cambio</strong></td>
		<td width="131" colspan="1"><input type="text" name="fecha" id="sel2" readonly size=10><input type="reset" value=" ... " onclick="return showCalendar('sel2', '%Y-%m-%d', '12', true);"></td>
		<td width="87" align="right"><strong>Responsable</strong></td>
		<td width="88">
			<?php
			//include "conect.php";
			//$link=conectarServidor();
			$link=conectarServidor();
			echo'<select name="respon">';
			$result=mysqli_query($link,"select * from personal where area =2 and activo=1");
			echo '<option selected value="">----------------------</option>';
			while($row=mysqli_fetch_array($result)){
				echo '<option value='.$row['Id_personal'].'>'.$row['nom_personal'].'</option>';
			}
			echo'</select>';
			mysqli_free_result($result);
			mysqli_close($link);
			?>		</td>
	  </tr>
		<tr>
			<td colspan="5"></td>
		</tr>
	  <tr>
		<td colspan="5" align="right"><input name="submit" onclick="return Enviar(this.form)" type="submit"  value="Continuar">
	  <input name="Crear" type="hidden" value="0">	  </tr>
  </table>
	
</form>
<table border="0" align="center">
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr> 
        <td><div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Volver"></div></td>
    </tr>
</table> 
</div>
</body>
</html>