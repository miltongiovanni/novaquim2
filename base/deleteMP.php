<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
	require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$codMPrima = $_POST['codMPrima'];
$MPrimaOperador = new MPrimasOperaciones();
try {
	$MPrimaOperador->deleteMPrima($codMPrima);
	$ruta = "listarMP.php";
	$mensaje =  "Materia prima eliminada correctamente";
	
} catch (Exception $e) {
	$ruta = "../menu.php";
	$mensaje = "Error al eliminar la materia prima";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}
	
function mover_pag($ruta,$nota)
{
	echo'<script language="Javascript">
	alert("'.$nota.'")
	self.location="'.$ruta.'"
	</script>';
}
?>
</body>
</html>
