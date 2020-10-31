<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Seleccionar Cliente a Revisar Estado de Cuenta</title>
<script  src="../js/validar.js"></script>
<script  src="scripts/ajax.js"></script>

</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>SELECCIONAR CLIENTE A REVISAR ESTADO DE CUENTA</strong></div>

<table width="700"  align="center" border="0">
  	<tr>
    	<td >&nbsp;</td>
  	</tr>
  	<tr>
    	<td>
		<form id="form1" name="form1" method="post" action="EstadoCuentaClien.php">
      	<div align="center"><strong>Cliente:</strong><input type="text" id="bus" name="bus" onkeyup="loadXMLDoc()" required /><div id="myDiv"></div>
        <br>
            <input type="button" value="Continuar" onClick="return Enviar2(this.form);">
      	</div>
    	</form>    
        </td>
  	</tr>
    <tr>
    	<td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2"><div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div></td>
    </tr>
</table>
</div>
</body>
</html>

