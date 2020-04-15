<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css"><head>
<meta charset="utf-8">
<title>Seleccionar Compra de Materia Prima a Modificar</title>
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>
	<script >
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>SELECCIONAR COMPRA DE MATERIAS PRIMAS</strong></div>
<form id="form1" name="form1" method="post" action="compramp2.php">	
<table border="0" align="center">
    <tr> 
        <td width="124"><div align="right"><strong>No. de Compra&nbsp;</strong></div></td>
        <td width="123"><input type="text" name="Factura" size=13 onKeyPress="return aceptaNum(event)"></td><input type="hidden" name="CrearFactura" value="5">
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td align="right"><input type="reset" value="Restablecer"></td>
        <td align="left"><input type="button" value="    Continuar    " onclick="return Enviar(this.form);"></td>
    </tr>
  
  	<tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2"><div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div></td></tr>
</table>
</form>  
</div>
</body>
</html>
