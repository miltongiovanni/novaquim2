<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<title>Creaci&oacute;n de Kits de Productos de Distribuci&oacute;n</title>
	<meta charset="utf-8">
	<script  src="scripts/validar.js"></script>
	<script  src="scripts/block.js"></script>
		<script >
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>SELECCIONE EL TIPO DE KIT A CREAR</strong></div>
<form name="form2" method="POST" action="crear_kits2.php">
<table  border="0" align="center" class="table2" width="34%" cellspacing="0">
	<tr>
    	<td width="22%">&nbsp;</td>
    </tr>		
    <tr>
        <td  colspan="2"><div align="center"><select name="Codigo"><option value=1>Producto de Novaquim</option><option value=2>Producto de Distribuci&oacute;n</option></select></div></td>
   	</tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
    <tr> 
        <td colspan="2">
            <div align="center">
              <input type="button" value="Enviar" onClick="return Enviar(this.form);">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="reset" value="Reiniciar">    	
          </div></td>
    </tr>
    
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2">
        <div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div>        </td>
    </tr>
</table>
</form>
</div>
</body>
</html>

