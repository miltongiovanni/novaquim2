<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Seleccionar F&oacute;rmula a Actualizar</title>
	<script  src="scripts/validar.js"></script>
	<script  src="scripts/block.js"></script>
	<script >
    document.onkeypress=stopRKey; 
    </script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ENVASADO POR ORDEN DE PRODUCCI&Oacute;N</strong></div>
<form id="form1" name="form1" method="post" action="det_Envasado.php">	
<table border="0" align="center" summary="detalle">
    <tr> 
        <td width="177"><div align="right"><strong>Orden de Producci&oacute;n&nbsp;</strong></div></td>
        <td width="120"><?php
			include "includes/conect.php";
			$link=conectarServidor();
			echo'<select name="Lote" id="combo">';
			$result=mysqli_query($link,"SELECT Lote from ord_prod where Estado='C' or Estado='F';");
			echo '<option selected value="">----------</option>';
			while($row=mysqli_fetch_array($result))
			{
				echo '<option value='.$row['Lote'].'>'.$row['Lote'].'</option>';
			}
			echo'</select>';
			mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
		?></td>
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td align="right"><input type="reset" value="Restablecer"></td>
        <td align="left"><input type="button" value="  Continuar  " onclick="return Enviar(this.form);"></td>
    </tr>
  	<tr>
        <td colspan="2"><div align="center"><input name="Crear" type="hidden" value="0">&nbsp;</div></td>
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
