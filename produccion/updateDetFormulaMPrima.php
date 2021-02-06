<?php
include "../includes/valAcc.php";
$idFormulaMPrima = $_POST['idFormulaMPrima'];
$codMPrima = $_POST['codMPrima'];
$porcentaje = $_POST['porcentaje'];
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$DetFormulaMPrimaOperador = new DetFormulaMPrimaOperaciones();
$datos = array( $porcentaje/100, $idFormulaMPrima, $codMPrima);
try {
    $DetFormulaMPrimaOperador->updateDetFormulaMPrima($datos);
    $_SESSION['idFormulaMPrima'] = $idFormulaMPrima;
    $ruta = "detFormulaMPrima.php";
    $mensaje = "Detalle de fórmula de materia prima actualizado con éxito";
} catch (Exception $e) {
    $_SESSION['idFormulaMPrima'] = $idFormulaMPrima;
    $ruta = "detFormulaMPrima.php";
    $ruta = $rutaError;
    $mensaje = "Error al actualizar el detalle de la fórmula de materia prima";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
