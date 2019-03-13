<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css"><head>
<meta charset="utf-8">
<title>Seleccionar Factura a Modificar</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>	
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>INGRESAR FACTURA A MODIFICAR</strong></div> 
<table border="0" align="center">
<form id="form1" name="form1" method="post" action="det_factura.php">	
    <tr> 
        <td width="124"><div align="right"><strong>No. de Factura&nbsp;</strong></div></td>
        <td width="143"><input type="text" name="factura" size=12 onKeyPress="return aceptaNum(event)"></td><input type="hidden" name="Crear" value="6">
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
