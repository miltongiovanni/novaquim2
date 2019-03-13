<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Eliminar Proveedor</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
	
</head>


<body>
<div id="contenedor">
<div id="saludo"><strong>ELIMINACI&Oacute;N DE PROVEEDOR</strong></div>
<table width="602" border="0" align="center">
	<tr>
		<td colspan="2">
			<form method="post" action="deleteProv.php">
			<div align="center"><strong>Proveedor</strong>
<?php
			include "includes/conect.php";
			$link=conectarServidor();
			echo'<select name="Proveedor" id="combo">';
			$result=mysqli_query($link,"select NIT_provee, Nom_provee from proveedores order by Nom_provee");
			echo '<option value="">-----------------------------------------------------------------</option>';
			while($row=mysqli_fetch_array($result))
			{
				echo '<option value='.$row['NIT_provee'].'>'.$row['Nom_provee'].'</option>';
			}
			echo'</select>';
			mysqli_free_result($result);
			mysqli_close($link);
			?>
			<input name="button" type="submit" value="Eliminar" onClick="return Enviar2(this.form);"></div>
			<div align="center"></div>
			<div align="right"></div>
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
