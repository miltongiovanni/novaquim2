<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$idCatMP=$_POST['idCatMP'];
$catMP=$_POST['catMP'];
$datos = array($catMP, $idCatMP);
$catsMPOperador = new CategoriasMPOperaciones();

try {
	$catsMPOperador->updateCatMP($datos);
	$ruta = "listarCatMP.php";
	$mensaje =  "Categoría de materia prima actualizada correctamente";
	
} catch (Exception $e) {
	$ruta = "buscarCatMP.php";
	$mensaje = "Error al actualizar la categoría de materia prima";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}


?>
