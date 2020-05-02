<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Seleccionar Categor&iacute;a</title>
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>
	<script >
	document.onkeypress = stopRKey; 
	</script>
	
</head>
<body>
<div id="contenedor">

<div id="saludo"><strong>SELECCI&Oacute;N  DE COTIZACI&Oacute;N&nbsp;</strong></div> 
<form id="form1" name="form1" method="post" action="UpdateCotform.php">
<table border="0" align="center">
  	<tr>
    	<td width="85" align="right"><strong>Cotizaci&oacute;n</strong></td>
		<td width="96">
      	<div align="center"><input type="text" name="cotiza" size=10 onKeyPress="return aceptaNum(event)">
        </div></td>
        <td width="83"><input type="button" value="Continuar" onClick="return Enviar(this.form);"/></td>
	</tr>
    <tr>
    	<td colspan="3"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="3"><div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div></td>
    </tr>
</table> 	
</form>  
</div>
</body>
</html>
