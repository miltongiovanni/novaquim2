<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta charset="utf-8">
<title>Seleccionar Cliente a Modificar</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>	
<script type="text/javascript" src="scripts/ajax.js"></script>
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>SELECCIONAR CLIENTE A MODIFICAR</strong></div>
<table border="0" align="center" width="700">
  	<tr>
    	<td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
    	<td>
		<form id="form1" name="form1" method="post" action="updateCliForm.php">
        
      	<div align="center"><strong>Cliente: </strong><input type="text" id="bus" name="bus" onkeyup="loadXMLDoc()" required /><div id="myDiv"></div>
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

