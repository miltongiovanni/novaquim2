<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css"><head>
<meta charset="utf-8">
<title>Seleccionar Nota de Cr&eacute;dito a  Modificar</title>
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>	
	<script >
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong> NOTA DE CR&Eacute;DITO A MODIFICAR</strong></div> 
<table border="0" align="center">
<form id="form1" name="form1" method="post" action="ModNotaC.php">	
    <tr> 
        <td width="152"><div align="right"><strong>No. de Nota Cr&eacute;dito&nbsp;</strong></div></td>
        <td width="143"><input type="text" name="nota" size=12 onKeyPress="return aceptaNum(event)"></td><input type="hidden" name="crear" value="2">
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td align="right"><input type="reset" value="Restablecer"></td>
        <td align="left"><input type="button" value="   Continuar   " onclick="return Enviar(this.form);"></td>
    </tr>
</form>    
  	<tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2"><div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div></td></tr>
</table>
</div>
</body>
</html>
