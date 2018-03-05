<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css"><head>
<meta charset="utf-8">
<title>Seleccionar Recibo de Caja a Modiificar</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
	
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>SELECCIONAR RECIBO DE CAJA A MODIFICAR</strong></div> 
<form id="form1" name="form1" method="post" action="recibo_caja2.php">	
<table width="24%" border="0" align="center">
    <tr> 
        <td width="64%"><div align="right"><strong>No. de Recibo de Caja:</strong></div></td>
        <td width="36%"><input type="text" name="recibo_c" size=15 onKeyPress="return aceptaNum(event)"></td><input type="hidden" name="Pago" value="3"><input name="Reten" type="hidden" value="0" >
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td align="right"><input type="reset" value="Restablecer"></td>
        <td align="left"><input type="button" value="      Continuar      " onclick="return Enviar(this.form);" ></td>
    </tr>
   
  	<tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2"><div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div></td></tr>
</table>
</form> 
</div>
</body>
</html>
