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
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>

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
			$link=conectarServidor();
			$users=$_SESSION['User'];
			echo'<select name="IdUsuario" id="combo">';
			$result=mysqli_query($link,"select IdUsuario, Usuario from tblusuarios");
			echo '<option value="">-----------------------------</option>';
			while($row=mysqli_fetch_array($result))
			{
			if ($row['Usuario'] !=$users )
			echo '<option value='.$row['IdUsuario'].'>'.$row['Usuario'].'</option>';
			}
			echo'</select>';
			mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
			?>
			<input name="button" type="button" value="Eliminar" onClick="return Enviar1(this.form);"></div>
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
