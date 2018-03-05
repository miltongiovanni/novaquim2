<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css"><head>
<meta charset="utf-8">
<title>Seleccionar Factura a Anular</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
	
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>INGRESAR FACTURA A ANULAR</strong></div> 

<table border="0" align="center">
<form id="form1" name="form1" method="post" action="anulaFactura.php">	
  	<tr>
    	<td colspan="2">&nbsp;</td>
  	</tr>
    <tr> 
        <td width="128"><div align="right"><strong>No. de Factura&nbsp;</strong></div></td>
        <td width="257"><input type="text" name="factura" size=10 onKeyPress="return aceptaNum(event)"></td><input type="hidden" name="Crear" value="5">
    </tr>
    <tr>
        <td align="right"><strong>Raz&oacute;n de Anulaci&oacute;n</strong></td>
        <td><textarea name="observa" id="textarea" cols="40" rows="5" ></textarea></td>
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td align="right"></td>
        <td align="left"><input type="reset" value="Restablecer">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="   Anular   " onclick="return Enviar(this.form);" ></td>
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
