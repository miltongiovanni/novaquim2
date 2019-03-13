<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Eliminaci&oacute;n de C&oacute;digo Gen&eacute;rico</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>	
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ELIMINACI&Oacute;N DE C&Oacute;DIGO GEN&Eacute;RICO</strong></div>
<form method="post" action="deleteCod.php">
<table width="602" border="0" align="center">
	<tr>
		<td width="258">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2">
			<div align="center"><strong>Producto</strong>
<?php
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="IdProd">';
				$result=mysqli_query($link,"select codigo_ant, producto from precios order by producto;");
				echo '<option selected value="">------------------------------------------------------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['codigo_ant'].'>'.$row['producto'].'</option>';
				}
				echo'</select>';
				mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
			?>
      <input name="button" type="submit" value=" Eliminar " onClick="return Enviar(this.form);"></div>
			<div align="center"></div>
			<div align="right"></div>
			   
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
</form> 
</div>
</body>
</html>
