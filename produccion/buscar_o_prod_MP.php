<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css"><head>
<meta charset="utf-8">
<title>Modificar consumo de Materia Prima por Orden de Producci&oacute;n de Materia Prima</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>	
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>SELECCI&Oacute;N ORDEN DE PRODUCCI&Oacute;N DE MATERIA PRIMA A MODIFICAR</strong></div>
<form id="form1" name="form1" method="post" action="detO_Prod_MP.php">
<table border="0" align="center" summary="cuerpo">
<tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td width="276"><div align="right"><strong>Orden de Producci&oacute;n de Materia Prima&nbsp;</strong></div></td>
        <td width="111"><input type="text" name="Lote" size=10 onKeyPress="return aceptaNum(event)"></td>
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td align="right"><input type="reset" value="Restablecer"></td>
        <td align="left"><input type="button" value="  Continuar  " onclick="return Enviar(this.form);"></td>

    </tr>
    
  	<tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
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