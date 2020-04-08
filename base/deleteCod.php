<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
	require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$codigoGen = $_POST['codigoGen'];

$PrecioOperador = new PreciosOperaciones();

try {
	$PrecioOperador->deletePrecio($codigoGen);
	$ruta = "listarCod.php";
	$mensaje =  "Código genérico eliminado correctamente";
	
} catch (Exception $e) {
	$ruta = "../menu.php";
	$mensaje = "Error al eliminar el código genérico";
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
</body>
</html>
