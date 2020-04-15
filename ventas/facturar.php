<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css"><head>
<meta charset="utf-8">
<title>Habilitar Pedido para Modificar</title>
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>
	<script >
	document.onkeypress = stopRKey; 
	</script>
	
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>HABILITAR PEDIDO PARA MODIFICAR</strong></div> 

<table border="0" align="center">
<form id="form1" name="form1" method="post" action="hfactura.php">	
  	<tr>
    	<td colspan="2">&nbsp;</td>
  	</tr>
    <tr> 
        <td width="119"><div align="right"><strong>No. de Pedido&nbsp;</strong></div></td>
        <td width="100"><input type="text" name="pedido" size=10 onKeyPress="return aceptaNum(event)"></td>
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td><div align="right"><input type="reset" value="Restablecer"></div></td>
        <td><div align="left"><input type="button" value="  Continuar " onclick="return Enviar(this.form);"></div></td>
    </tr>
</form>    
  	<tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2"><div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div></td></tr>
</table>
</div>
</body>
</html>
