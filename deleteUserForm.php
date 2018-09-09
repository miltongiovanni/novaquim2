<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Borrar Usuario</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>	

</head>


<body>
<div id="contenedor">

<div id="saludo"><strong>ELIMINACI&Oacute;N DE USUARIOS</strong></div> 
<table width="700" border="0" align="center">
	<tr>
		<td colspan="2">
			<form method="post" name="form2" action="deleteUser.php">
			<div align="center"><strong>Usuario</strong>
			<?php
			include "includes/conect.php";
			$mysqli=conectarServidor();
			$users=$_SESSION['User'];
			echo'<select name="idUsuario" id="combo">';
			$result=$mysqli->query("select IdUsuario, Usuario from tblusuarios");
			echo '<option value="">-----------------------------</option>';
			while($row=$result->fetch_assoc())
			{
			if ($row['Usuario'] !=$users )
			echo '<option value='.$row['IdUsuario'].'>'.$row['Usuario'].'</option>';
			}
			echo'</select>';
			$result->free();
			/* cerrar la conexión */
			$mysqli->close();
			?>
			<button class="button" style="vertical-align:middle" onclick="return Enviar(this.form)"><span>Eliminar</span></button></div>
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
