<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Eliminar Materias Primas</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>	
<script type="text/javascript">
document.onkeypress = stopRKey; 
</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ELIMINACI&Oacute;N DE MATERIA PRIMA</strong></div>
<form method="post" action="deleteMP.php">
<table width="602" border="0" align="center">
	<tr>
		<td colspan="2">
			<div align="center"><strong>Materia Prima</strong>
<?php
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="IdMP">';
				$result=mysqli_query($link,"select * from mprimas order by Nom_mprima");
				echo '<option selected value="">-----------------------------------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['Cod_mprima'].'>'.$row['Nom_mprima'].'</option>';
				}
				echo'</select>';
				mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
			?>
		  <input name="button" type="submit" value="Borrar" onClick="return Enviar(this.form);"></div>
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
