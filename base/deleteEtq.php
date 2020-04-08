<?php
function cargarClases($classname)
{
	require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$codEtiqueta = $_POST['codEtiqueta'];
$EtiquetaOperador = new EtiquetasOperaciones();


try {
	$EtiquetaOperador->deleteEtiqueta($codEtiqueta);
	$ruta = "listarEtq.php";
	$mensaje =  "Etiqueta eliminada correctamente";
	
} catch (Exception $e) {
	$ruta = "deleteEtqForm.php";
	$mensaje = "Error al eliminar la etiqueta";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}
	
function mover_pag($ruta,$nota)
	{
	echo'<script >
	alert("'.$nota.'")
	self.location="'.$ruta.'"
	</script>';
	}
?>