<?php
include "../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$idCatMP = $_POST['idCatMP'];
$catsMPOperador = new CategoriasMPOperaciones();
try {
    $catsMPOperador->deleteCatMP($idCatMP);
    $ruta = "listarCatMP.php";
    $mensaje = "Categoría de materia prima eliminada correctamente";

} catch (Exception $e) {
    $ruta = "../menu.php";
    $mensaje = "Error al eliminar la categoría de materia prima";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}


?>
