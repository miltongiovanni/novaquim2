<?php
	include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$idCatProd=$_POST['idCatProd'];
$catsProdOperador = new CategoriasProdOperaciones();
try {
	$catsProdOperador->deleteCatProd($idCatProd);
	$ruta = "listarCatProd.php";
	$mensaje =  "Categoría de producto eliminada correctamente";
	
} catch (Exception $e) {
	$ruta = "../menu.php";
	$mensaje = "Error al eliminar la categoría de producto";
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