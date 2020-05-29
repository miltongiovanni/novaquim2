<?php
include "../includes/valAcc.php";
$idFormulaMPrima = $_POST['idFormulaMPrima'];
$codMPrima = $_POST['codMPrima'];
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$DetFormulaMPrimaOperador = new DetFormulaMPrimaOperaciones();
$datos = array($idFormulaMPrima, $codMPrima);
try {
    $DetFormulaMPrimaOperador->deleteDetFormulaMPrima($datos);
    $_SESSION['idFormulaMPrima'] = $idFormulaMPrima;
    $ruta = "detFormulaMPrima.php";
    $mensaje = "Detalle de fórmula de materia prima eliminado con éxito";
} catch (Exception $e) {
    $_SESSION['idFormulaMPrima'] = $idFormulaMPrima;
    $ruta = "detFormulaMPrima.php";
    $ruta = $rutaError;
    $mensaje = "Error al eliminar el detalle de la fórmula de materia prima";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}
