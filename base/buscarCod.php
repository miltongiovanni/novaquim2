<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta charset="utf-8">
<title>Seleccionar C&oacute;digo a Actualizar</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>	
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>SELECCIONAR C&Oacute;DIGO A ACTUALIZAR</strong></div>
<form id="form1" name="form1" method="post" action="updateCodForm.php">
<table width="100%" border="0">
  	<tr>
    	<td>
      	<div align="center"><strong>Producto</strong>
		<?php
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="IdProd" id="combo">';
				$result=mysqli_query($link,"select codigo_ant, producto from precios order by producto");
				echo '<option selected value="">---------------------------------------------------------------------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['codigo_ant'].'>'.$row['producto'].'</option>';
				}
				echo'</select>';
				mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
			?>
            <input type="button" value="Continuar" onClick="return Enviar(this.form);">
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
