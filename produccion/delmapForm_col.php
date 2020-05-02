<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Acualizaci&oacute;n</title>
</head>
<body>
<?php
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
	  $asignacion = "\$".$nombre_campo."='".$valor."';"; 
	  //echo $nombre_campo." = ".$valor."<br>";  
	  eval($asignacion); 
	}  
	$percent=$percent/100;
	$qryinv="delete from det_formula_col where Id_formula_color=$IdForm and Cod_mprima=$mprima";
	echo'<form action="detFormula_Col.php" method="post" name="formulario">';
	$link=conectarServidor();
	$result=mysqli_query($link,$qryinv);
	echo '<input name="Formula" type="hidden" value="'.$IdForm.'">
	<input name="CrearFormula" type="hidden" value="2">
	<input type="submit" name="Submit" value="Cambiar" >';
	if($result==1)
	{
		mover_pag($ruta,"Materia Prima eliminada correctamente de la Fórmula");
	}
	echo'</form>';
	function mover_pag($ruta,$nota)
	{
	echo'<script >
	document.formulario.submit();
	</script>';
	}
	mysqli_close($link);
?>
</body>
</html>