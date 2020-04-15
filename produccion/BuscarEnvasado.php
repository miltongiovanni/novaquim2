<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Seleccionar Orden de Produccion a Modificar el Envasado</title>
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>
	<script >
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<table width="24%" border="0" align="center">
<form id="form1" name="form1" method="post" action="det_Envasado.php">	
	<tr>
		<td colspan="2"><p align="center"><img src="images/LogoNova1.JPG" width="393" height="201" /></p></td>
	</tr>
  	<tr>
    	<td colspan="2">&nbsp;</td>
  	</tr>
    <tr> 
        <td width="64%"><div align="right"><strong>Orden de Producci&oacute;n&nbsp;</strong></div></td>
        <td width="36%"><input type="text" name="Lote" size=15 onKeyPress="return aceptaNum(event)"></td>
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td align="right"><input type="reset" value="Restablecer"></td>
        <td align="left"><input type="button" value="      Continuar      " onclick="return Enviar(this.form);" /></td>
    </tr>
  	<tr>
        <td colspan="2"><div align="center"><input name="Crear" type="hidden" value="0">&nbsp;</div></td>
    </tr>
</form>    
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2"><div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div></td>
    </tr>
</table>
</body>
</html>
