<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Seleccionar Fórmula a Actualizar</title>
	<script  src="../js/validar.js"></script>
	<script  src="scripts/block.js"></script>
	<script >
    document.onkeypress=stopRKey; 
    </script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ENVASADO POR ORDEN DE PRODUCCIÓN</strong></div>
<form id="form1" name="form1" method="post" action="det_cal_produccion.php">	
<table border="0" align="center" summary="detalle">
    <tr> 
        <td width="177"><div align="right"><strong>Orden de Producción&nbsp;</strong></div></td>
        <td width="120"><input type="text" name="Lote" size=15 onKeyPress="return aceptaNum(event)"></td>
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td align="right"><input type="reset" value="Restablecer"></td>
        <td align="left"><input type="button" value="  Continuar  " onclick="return Enviar(this.form);"></td>
    </tr>
  	<tr>
        <td colspan="2"><div align="center"><input name="Crear" type="hidden" value="0">&nbsp;</div></td>
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
