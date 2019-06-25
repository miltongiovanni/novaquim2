<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
	<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<title>Creaci&oacute;n de Tapas y V&aacute;lvulas</title>
	<meta charset="utf-8">
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>	
    	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>CREACI&Oacute;N DE TAPAS O V&Aacute;LVULAS</strong></div>
<form name="form2" method="POST" action="makeVal.php">
<table width="391"  border="0"  align="center" cellspacing="0" class="table2">
    <tr> 
        <td width="178"><div align="right"><b>Descripci&oacute;n</b></div></td>
        <td colspan="2"><input type="text" name="tapa" size=34 value=""></td>
    </tr>
    <tr> 
        <td><div align="right"><strong>Stock M&iacute;nimo</strong></div></td>

        <td colspan="2"><input type="text" name="min_stock" size=34 onKeyPress="return aceptaNum(event)"></td>
  	</tr>
    <tr>
      <td colspan="3"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> <td></td>
        <td width="104"><div align="center"><input type="button" value="  Crear  " onClick="return Enviar(this.form);"></div></td>
        <td width="103"><div align="center"><input type="reset" value="Reiniciar"></div></td>
    </tr>

	<tr>
      <td colspan="3"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
        <td colspan="3"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="3">
        <div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div>        </td>
    </tr>
</table>
</form>
</div>
</body>
</html>

