<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Acualizaci&oacute;n</title>
</head>
<body>
<?php
	$cod_form=$_POST['IdForm'];
	$cod_mprima=$_POST['mprima'];
	$percent=$_POST['percent']/100;
	$qryinv="delete from det_formula where Id_formula=$cod_form and Cod_mprima=$cod_mprima";
	echo'<form action="detFormula.php" method="post" name="formulario">';
	$link=conectarServidor();
	$result=mysqli_query($link,$qryinv);
	echo '<input name="Formula" type="hidden" value="'.$cod_form.'"/>
	<input name="CrearFormula" type="hidden" value="2"/>
	<input type="submit" name="Submit" value="Cambiar" />';
	if($result==1)
	{
		$ruta="menu.php";
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