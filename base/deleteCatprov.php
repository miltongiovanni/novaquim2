<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$idCatProv = $_POST['idCatProv'];
$catsProvOperador = new CategoriasProvOperaciones();
try {
    $catsProvOperador->deleteCatProv($idCatProv);
    $ruta = "listarCatProv.php";
    $mensaje = "Categoría de proveedor eliminada correctamente";

} catch (Exception $e) {
    $ruta = "deleteCatProvForm.php";
    $mensaje = "Error al eliminar la categoría de proveedor";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}



?>
