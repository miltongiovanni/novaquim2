<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$idCatDis=$_POST['idCatDis'];
$catDis=$_POST['catDis'];
$datos = array($catDis, $idCatDis);
$catsDisOperador = new CategoriasDisOperaciones();

try {
	$catsDisOperador->updateCatDis($datos);
	$ruta = "listarCatDis.php";
	$mensaje =  "Categoría producto de distribución actualizada correctamente";
	
} catch (Exception $e) {
	$ruta = "buscarCatDis.php";
	$mensaje = "Error al actualizar categoría producto de distribución";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}


?>
