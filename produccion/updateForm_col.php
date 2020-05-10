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
	$cod_form=$_POST['IdForm'];
	$cod_mprima=$_POST['mprima'];
	$percent=$percent/100;
	$qryinv="update det_formula_col set porcentaje=$percent where Id_formula_color=$IdForm and Cod_mprima=$mprima";
	echo'<form action="detFormula_Col.php" method="post" name="formulario">';
	$link=conectarServidor();
	$result=mysqli_query($link,$qryinv);
	echo '<input name="Formula" type="hidden" value="'.$IdForm.'">
	<input name="CrearFormula" type="hidden" value="2">
	<input type="submit" name="Submit" value="Cambiar" >';
	if($result==1)
	{
		$ruta="menu.php";
		mysqli_close($link);
		mover_pag($ruta,"Formulación Actualizada correctamente");
	}
	echo'</form>';
	
?>
</body>
</html>