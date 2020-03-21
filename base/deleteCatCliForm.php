<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Eliminar Tipo de Cliente</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>	
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>

</head>


<body>

<table width="51%" border="0" align="center">
<tr>
		<td><div align="center"><img src="images/LogoNova1.JPG"/></div></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
		<div align="center">
		<p align="center" class="titulo">ELIMINACIÓN DE TIPO DE CLIENTE</p>
		</div>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2">
			<form method="post" action="deleteCat_Cli.php">
			<label>
			<div align="center">Categoría
			  <?php
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="IdCat" id="combo">';
				$result=mysqli_query($link,"select * from cat_clien");
				echo '<option selected value="">-----------------------------------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['Id_cat_cli'].'>'.$row['Des_cat_cli'].'</option>';
				}
				echo'</select>';
				mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
			?>
			<input name="button" type="submit" value="Eliminar" onClick="return Enviar(this.form);"></div>
			</label>
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

</body>
</html>
