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
			$mysqli=conectarServidor();
			echo'<select name="IdPersonal">';
			$result=$mysqli->query("select Id_personal, nom_personal from personal;");
			echo '<option value="">--------------------------------------------</option>';
			while($row=$result->fetch_assoc())
			{
			echo '<option value='.$row['Id_personal'].'>'.utf8_encode($row['nom_personal']).'</option>';
			}
			echo'</select>';
			$result->free();
/* cerrar la conexión */
$mysqli->close();
			?>
			<button class="button" style="vertical-align:middle" onclick="return Enviar1(this.form)"><span>Eliminar</span></button></div>
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
        <div align="center"><button class="button1" id="back" style="vertical-align:middle" onClick="history.back()"> <span>VOLVER</span></button></div>
        </td>
    </tr>
</table>
</div>
</body>
</html>
