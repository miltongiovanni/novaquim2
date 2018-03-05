<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Actualizar datos de Presentaci&oacute;n de Producto</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ACTUALIZACI&Oacute;N DE FORMULACI&Oacute;N</strong></div> 
<form action="updateForm.php" method="post" name="actualiza">
<table width="34%" border="0" align="center" summary="cuerpo">
  <tr>
    <td width="58%" class="titulo"><div align="center">Materia Prima</div></td>
    <td width="26%" class="titulo"><div align="center">Porcentaje</div></td>
    <td width="26%" class="titulo"><div align="center">Orden</div></td>
  </tr>
  
  <?php
	$link=conectarServidor();
	$IdForm=$_POST['IdForm'];
	$cod_mprima=$_POST['mprima'];
	$percent=$_POST['percent'];
	$qry="SELECT det_formula.Cod_mprima as codigo, Nom_mprima, porcentaje, Orden 
	FROM det_formula, mprimas 
	where Id_formula=$IdForm AND det_formula.Cod_mprima=mprimas.Cod_mprima AND det_formula.Cod_mprima=$cod_mprima;";
	$result=mysqli_query($link,$qry);
	$row=mysqli_fetch_array($result);
	$codmp=$row['codigo'];
	$mprima=$row['Nom_mprima'];
	$percent=$row['porcentaje'];
	$Orden=$row['Orden'];
	echo '<tr><td align="center"><input name="IdForm" type="hidden" value="'.$IdForm.'">';
 	echo $mprima;
	echo '<input name="mprima" type="hidden" value="'.$codmp.'">';
 	echo '</td>';	
	echo '<td align="center">';
 	echo'<input size=5 name="percent" type="text" value="'.$percent*(100).'">';
 	echo '</td>';	
	echo '<td align="center">';
 	echo'<input size=5 name="Orden" type="text" value="'.$Orden.'">';
 	echo '</td>';	
	echo '</tr>';
	mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
	?>
	<tr >
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
	</tr>
	<tr >
   	  <td colspan="3"><div align="center"><input type="submit" name="Submit" value="Cambiar"></div></td>
	</tr>  
</table>
</form>
</div>
</body>
</html>
