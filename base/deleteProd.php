<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
	require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$codProducto = $_POST['codProducto'];
$ProductoOperador = new ProductosOperaciones();

try {
	$ProductoOperador->deleteProducto($codProducto);
	$ruta = "listarProd.php";
	$mensaje =  "Producto eliminado correctamente";
	
} catch (Exception $e) {
	$ruta = "../menu.php";
	$mensaje = "Error al eliminar el producto";
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
