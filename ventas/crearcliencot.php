<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Crear Cotizaci&oacute;n</title>
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
	</script></head>
<body>
<div id="contenedor">
<div id="saludo"><strong>CREAR CLIENTE PARA COTIZACI&Oacute;N</strong></div>
<form method="post" action="makeClienCotForm.php" name="form1">	
  	<table align="center" width="22%">
    <tr>
      	<td width="62%" align="right"><strong></strong></td>
   	  <td width="38%" colspan="3"><input name="crear" value="1"  type="hidden" ></td>
    </tr>
     <tr>
      	<td align="right"><strong>Cliente Existente</strong></td>
      	<td colspan="3">
        <input name="CliExis" type="radio" id="CliExis_0" value="1" checked> 
        Si
        <input type="radio" name="CliExis" value="0" id="CliExis_1"> 
        No</td>
    </tr>
    <tr>
   	  <td colspan="4"><div align="right"><input name="button" type="button" class="formatoBoton1" onClick="return Enviar(this.form);" value="Continuar"></div></td>
    </tr>    
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>

    <tr> 
        <td colspan="4">
        <div align="center"><input type="button" class="formatoBoton1" onClick="history.back()" value="  VOLVER  "></div>        </td>
    </tr>
  </table>
</form> 
</div>
</body>
</html>
