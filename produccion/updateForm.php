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
	$Orden=$_POST['Orden'];
	$cod_form=$_POST['IdForm'];
	$cod_mprima=$_POST['mprima'];
	$percent=$_POST['percent']/100;
	$qryinv="update det_formula set porcentaje=$percent, Orden=$Orden where Id_formula=$cod_form and Cod_mprima=$cod_mprima";
	echo'<form action="detFormula.php" method="post" name="formulario">';
	$link=conectarServidor();
	$result=mysqli_query($link,$qryinv);
	echo '<input name="Formula" type="hidden" value="'.$cod_form.'"/>
	<input name="CrearFormula" type="hidden" value="2"/>
	<input type="submit" name="Submit" value="Cambiar" />';
	if($result==1)
	{
		$ruta="menu.php";
		mysqli_close($link);
		mover_pag($ruta,"Formulación Actualizada correctamente");
	}
	echo'</form>';
	function mover_pag($ruta,$nota)
	{
	echo'<script >
	document.formulario.submit();
	</script>';
	}
?>
</body>
</html>