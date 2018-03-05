<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
	<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<title>Creaci&oacute;n de Proveedores</title>
	<meta charset="utf-8">
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>	
		<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>CREACI&Oacute;N DE PROVEDORES</strong></div>
<form name="form2" method="POST" action="makeProv.php">
<table align="center">
  <tr>
      <td width="59"><div align="right"><strong>Tipo</strong></div></td>
      <td width="221" colspan="2">
      <input name="tipo" type="radio" id="tipo_0" value="1" checked>
      <strong>Nit</strong>&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="radio" name="tipo" value="2" id="tipo_1">
      <strong>C&eacute;dula</strong></td>
  </tr>
  <tr> 
      <td><div align="right"><b>No.</b></div></td>
      <td><input type="text" name="NIT" size=24 onKeyPress="return aceptaNum(event)" id="NIT" maxlength="10"></td>
  </tr>
  <tr> 
      <td height="30">   </td>
      <td>
              <input type="submit" value="  Continuar  ">
              <input type="reset" value="Restablecer">                    
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
      <div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="VOLVER"></div>                    </td>
  </tr>
</table>
</form>
</div>
</body>
</html>

