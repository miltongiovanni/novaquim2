<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css"><head>
<meta charset="utf-8">
<title>Modificar consumo de Materia Prima por Orden de Producci&oacute;n</title>
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>
	<script >
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>SELECCI&Oacute;N ORDEN DE PRODUCCI&Oacute;N A MODIFICAR</strong></div>
<form id="form1" name="form1" method="post" action="detO_Prod.php">
<table border="0" align="center">
    <tr> 
        <td width="173"><div align="right"><strong>Orden de Producci&oacute;n&nbsp;</strong></div></td>
        <td width="111"><input type="text" name="Lote" size=10 onKeyPress="return aceptaNum(event)"></td>
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td align="right"><input type="reset" value="Restablecer"></td>
        <td align="left"><input type="button" value="  Continuar  " onclick="return Enviar(this.form);"></td>

    </tr>
    
  	<tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
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
