<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Creaci&oacute;n de Orden de Pedido</title>
    <meta charset="utf-8">
    <link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script  src="scripts/validar.js"></script>
	<script  src="scripts/block.js"></script>
    <link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue">
    <script  src="scripts/calendar.js"></script>
    <script  src="scripts/ajax.js"></script>
    <script  src="scripts/calendar-sp.js"></script>
    <script  src="scripts/calendario.js"></script>
    	<script >
	document.onkeypress = stopRKey; 
	</script>
</head>
<body> 
<div id="contenedor">
<div id="saludo"><strong>CREACI&Oacute;N DE ORDEN DE PEDIDO</strong></div>
<form method="post" action="pedido2.php" name="form1">	
  	<table align="center" width="40%">
    <tr>
   	  <td>&nbsp;</td>
    </tr>
    <tr>
      	<td colspan="2"><div align="center"><strong>Cliente: </strong>
   	  <input type="text" id="bus" name="bus" onkeyup="loadXMLDoc()" required /><div id="myDiv"><br> 
   	  </div>
      	</div></td>
    </tr>
     
    <tr>
      <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>    <input name="Crear" type="hidden" value="3">
    <tr>
   	  <td>&nbsp;</td>
   	  <td><div align="right"><input name="button" type="button" class="formatoBoton1" onClick="return Enviar(this.form);" value="Continuar"></div></td>
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2">
        <div align="center"><input type="button" class="formatoBoton1" onClick="history.back()" value="  VOLVER  "></div>        </td>
    </tr>

  </table>
</form> 
</div>
</body>
</html>