<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Eliminar Formulación</title>
<script  src="../js/validar.js"></script>


</head>


<body>
<div id="contenedor">
<div id="saludo"><strong>ELIMINACIÓN DE FORMULACIÓN</strong></div>

<table width="602" border="0" align="center">
	<tr>
		<td width="258">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2">
			<form method="post" action="deleteForm.php">
			<div align="center"><strong>Fórmula</strong>
			<?php
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="IdForm">';
				$result=mysqli_query($link,"select * from formula order by nomFormula");
				echo '<option selected value="">-----------------------------------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['Id_form'].'>'.$row['Nom_form'].'</option>';
				}
				echo'</select>';
				mysqli_free_result($result);
/* cerrar la conexi�n */
mysqli_close($link);
			?>
			  <input name="button" type="submit" value="Reiniciar" onClick="return Enviar(this.form);"></div>
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
        <div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="MENÚ">
        </div>
        </td>
    </tr>
</table>
</div>
</body>
</html>
