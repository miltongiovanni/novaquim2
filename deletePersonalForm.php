<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Borrar Personal</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>	
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ELIMINACI&Oacute;N DE PERSONAL</strong></div> 
<table width="700" border="0" align="center" summary="cuerpo">
	<tr>
		<td colspan="2">
			<form method="post" action="deletePerson.php">
			<div align="center"><strong>Personal</strong>
		  	<?php
			include "includes/conect.php";
			$link=conectarServidor();
			echo'<select name="IdPersonal">';
			$result=mysqli_query($link,"select Id_personal, nom_personal from personal;");
			echo '<option value="">--------------------------------------------</option>';
			while($row=mysqli_fetch_array($result))
			{
			echo '<option value='.$row['Id_personal'].'>'.$row['nom_personal'].'</option>';
			}
			echo'</select>';
			mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
			?>
			<input name="button" type="submit" value="Eliminar" onClick="return Enviar1(this.form);"></div>
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
