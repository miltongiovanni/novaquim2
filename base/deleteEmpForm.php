<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Borrar Empleado</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>	
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ELIMINACI&Oacute;N DE EMPLEADO</strong></div> 
<table width="700" border="0" align="center" summary="cuerpo">
	<tr>
		<td colspan="2">
			<form method="post" action="deleteEmpl.php">
			<div align="center"><strong>Empleado:</strong>
		  	<?php
			include "includes/conect.php";
			$link=conectarServidor();
			echo'<select name="Id_empleado">';
			$result=mysqli_query($link,"select Id_empleado, concat(1apell_emp, ' ', 2apell_emp, ' ', 1nom_emp, ' ', 2nom_emp) as empleado from empleados order by empleado;");
			echo '<option value="">--------------------------------------------</option>';
			while($row=mysqli_fetch_array($result))
			{
			echo '<option value='.$row['Id_empleado'].'>'.$row['empleado'].'</option>';
			}
			echo'</select>';
			mysqli_free_result($result);
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
