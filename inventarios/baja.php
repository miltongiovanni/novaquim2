<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Baja de Productos</title>
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
<div id="saludo"><strong>BAJA DE PRODUCTOS</strong></div>
<form method="post" action="det_baja.php" name="form1">	
<table align="center">
<tr>
  <td width="93" align="right"><strong>Responsable:</strong></td>
  <td width="380"><input type="text" name="respon" size=40 ></td>
</tr> 
<tr>
  <td align="right"><strong>Fecha: </strong></td>
  <td><input type="text" name="FchBaja" id="sel1" readonly size=20><input type="reset" value=" ... "
    onclick="return showCalendar('sel1', '%Y-%m-%d', '12', true);"></td>
</tr>
<tr>
  <td align="right"><strong>Motivo </strong></td>
  <td><select name="motivo">
    <option value="Uso Empresa">Uso Empresa</option>
    <option value="Uso Personal">Uso Personal</option>
    <option value="Deterioro">Deterioro</option>
  </select></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td><div align="right"><input name="Crear" type="hidden" value="3"><input name="button" type="button" onClick="return Enviar(this.form);" value="Continuar"></div></td>
</tr>
<tr>
    <td colspan="2"><div align="center">&nbsp;</div></td>
</tr>
<tr> 
    <td colspan="2"><div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div></td>
</tr>
</table>
</form> 
</div>
</body>
</html>