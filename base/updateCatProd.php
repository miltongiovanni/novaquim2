<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$idCatProd=$_POST['idCatProd'];
$catProd=$_POST['catProd'];
$datos = array($catProd, $idCatProd);
$catsProdOperador = new CategoriasProdOperaciones();

try {
	$catsProdOperador->updateCatProd($datos);
	$ruta = "listarCatProd.php";
	$mensaje =  "Categoría de producto actualizada correctamente";
	
} catch (Exception $e) {
	$ruta = "buscarCatProd.php";
	$mensaje = "Error al actualizar la categoría de producto";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}



?>
