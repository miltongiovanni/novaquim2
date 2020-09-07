<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Selección del rango de fecha de pagos</title>
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
<div id="saludo"><strong>SELECCIÓN DEL RANGO DE FECHA DE COBROS</strong></div>
<form method="post" action="histo_cobros_Xls.php" name="form1">	
  	<table align="center">
     <tr>
      <td width="111" align="right"><strong>Fecha Inicial</strong></td>
      <td width="216"><input type="text" name="FchIni" id="sel1" readonly size=20><input type="reset" value=" ... "
		onclick="return showCalendar('sel1', '%Y-%m-%d', '12', true);"></td>
    </tr>
    <tr>
      <td align="right"><strong>Fecha Final</strong></td>
      <td><input type="text" name="FchFin" id="sel2" readonly size=20><input type="reset" value=" ... "
		onclick="return showCalendar('sel2', '%Y-%m-%d', '12', true);"></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>   
    <tr>
   	  <td>&nbsp;</td>
   	  <td><div align="right"><input name="button" type="button" onClick="return Enviar(this.form);" value="Continuar"></div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2">
        <div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div>        </td>
    </tr>

  </table>
</form> 
</div>
</body>
</html>