<?php
function cargarClases($classname)
{
	require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$codEnvase = $_POST['codEnvase'];
$EnvaseOperador = new EnvasesOperaciones();


try {
	$EnvaseOperador->deleteEnvase($codEnvase);
	$ruta = "listarEnv.php";
	$mensaje =  "Envase eliminado correctamente";
	
} catch (Exception $e) {
	$ruta = "../menu.php";
	$mensaje = "Error al eliminar el envase";
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