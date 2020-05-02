<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ingresar Orden de Pedido a Anular</title>
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>
	<script >
	document.onkeypress = stopRKey; 
	</script>
	
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>INGRESAR ORDEN DE PEDIDO A ANULAR</strong></div> 

<table border="0" align="center">
<form id="form1" name="form1" method="post" action="anularPedido.php">	
    <tr> 
        <td><div align="right"><strong>Orden de Pedido</strong></div></td>
        <td><input type="text" name="pedido" size=10 onKeyPress="return aceptaNum(event)"></td><input type="hidden" name="Crear" value="5">
    </tr>
   
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td align="right"><input type="reset" value="Restablecer"></td>
        <td align="left"><input type="button" value="   Anular   " onclick="return Enviar(this.form);" /></td>
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
