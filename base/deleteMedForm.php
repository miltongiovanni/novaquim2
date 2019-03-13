<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Borrar Presentaci&oacute;n de Productos</title>
</head>


<body>
<div id="contenedor">
<div id="saludo"><strong>ELIMINACI&Oacute;N DE PRESENTACI&Oacute;N DE PRODUCTO</strong></div>
<form method="post" action="deleteMed.php">
<table width="602" border="0" align="center">
	<tr>
		<td colspan="2">
			<div align="center"><strong>Producto</strong>
<?php
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="IdProdPre">';
				$result=mysqli_query($link,"select * from prodpre order by Nombre");
				echo '<option>----------------------------------------------------------------------------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['Cod_prese'].'>'.$row['Nombre'].'</option>';
				}
				echo'</select>';
				mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
			?>
		  <input name="button" type="submit" value="Borrar"></div>
		</td>
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
