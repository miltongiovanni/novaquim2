<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$idCatProv = $_POST['idCatProv'];
$desCatProv = $_POST['desCatProv'];
$datos = array($desCatProv, $idCatProv);
$catsProvOperador = new CategoriasProvOperaciones();

try {
    $catsProvOperador->updateCatProv($datos);
    $ruta = "listarCatProv.php";
    $mensaje = "Categoría de proveedor actualizada correctamente";

} catch (Exception $e) {
    $ruta = "buscarCatProv.php";
    $mensaje = "Error al actualizar la categoría de proveedor";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}



?>
