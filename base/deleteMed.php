<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
	require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$codPresentacion = $_POST['codPresentacion'];
$PresentacionOperador = new PresentacionesOperaciones();
try {
	$PresentacionOperador->deletePresentacion($codPresentacion);
	$ruta = "listarmed.php";
	$mensaje = "Presentación eliminada correctamente";
} catch (Exception $e) {
	$ruta = "../menu.php";
	$mensaje = "Error al eliminar la presentación";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}

function mover_pag($ruta, $nota)
{
	echo '<script language="Javascript">
	alert("' . $nota . '")
	self.location="' . $ruta . '"
	</script>';
}
