<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Eliminar Cliente</title>
<script  src="scripts/validar.js"></script>
<script  src="scripts/ajax.js"></script>
<script  src="scripts/block.js"></script>	
	<script >
	document.onkeypress = stopRKey; 
	</script>

</head>


<body>
<div id="contenedor">
<div id="saludo"><strong>SELECCIONAR CLIENTE A ELIMINAR</strong></div>

<table width="700" border="0" align="center">
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2">
			<form method="post" action="deleteCli.php">
			<div align="center"><strong>Cliente: </strong><input type="text" id="bus" name="bus" onkeyup="loadXMLDoc()" required /><div id="myDiv"></div>
        <br>
			  <input name="button" type="submit" value="Eliminar" onClick="return Enviar2(this.form);"></div>
			<div align="center"></div>
			<div align="right"></div>
			</form>    
		</td>
	</tr>
	<tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2">
        <div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div>
        </td>
    </tr>
</table>
</div>
</body>
</html>
