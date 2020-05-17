<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="utf-8">
<title>Seleccionar Cliente a Consultar Notas Crédito</title>
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<script  src="../js/validar.js"></script>
<script  src="scripts/ajax.js"></script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>CONSULTA DE NOTAS CRÉDITO POR CLIENTE</strong></div>
<form id="form1" name="form1" method="post" action="listarNotasCClien.php">
<table width="100%" border="0" align="center" summary="cuerpo">
<tr>
    	<td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
  	<tr>
    	<td>
      	<div align="center"><strong>Cliente:</strong><input type="text" id="bus" name="bus" onkeyup="loadXMLDoc()" required /><div id="myDiv"></div>
        <br>
            <input type="submit" name="Submit" value="Continuar" onClick="return Enviar2(this.form);">
      	</div>
        </td>
  	</tr>
    <tr>
    	<td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2"><div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div></td>
    </tr>
</table>
</form>
</div>
</body>
</html>

