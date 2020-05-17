<?php
include "../includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Actualizar Formulación de Color</title>
<script  src="../js/validar.js"></script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ACTUALIZACIÓN DE FORMULACIÓN DE COLOR</strong></div> 
<form action="updateForm_col.php" method="post" name="actualiza">
<table width="34%" border="0" align="center" summary="cuerpo">
  <tr>
    <td width="58%" class="titulo"><div align="center">Materia Prima</div></td>
    <td width="26%" class="titulo"><div align="center">Porcentaje</div></td>
  </tr>
  
  <?php
	$link=conectarServidor();
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
	  $asignacion = "\$".$nombre_campo."='".$valor."';"; 
	  //echo $nombre_campo." = ".$valor."<br>";  
	  eval($asignacion); 
	}  
	$qry="SELECT det_formula_col.Cod_mprima as codigo, Nom_mprima, porcentaje 
	FROM det_formula_col, mprimas 
	where Id_formula_color=$IdForm AND det_formula_col.Cod_mprima=mprimas.Cod_mprima AND det_formula_col.Cod_mprima=$mprima;";
	$result=mysqli_query($link,$qry);
	$row=mysqli_fetch_array($result);
	$codmp=$row['codigo'];
	$mprima=$row['Nom_mprima'];
	$percent=$row['porcentaje'];
	echo '<tr><td align="center"><input name="IdForm" type="hidden" value="'.$IdForm.'">';
 	echo $mprima;
	echo '<input name="mprima" type="hidden" value="'.$codmp.'">';
 	echo '</td>';	
	echo '<td align="center">';
 	echo'<input size=5 name="percent" type="text" value="'.$percent*(100).'">';
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
