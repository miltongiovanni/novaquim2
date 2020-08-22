<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$codPaca = $_POST['codPaca'];
$cantidadPacas = $_POST['cantidadPacas'];

$invDistribucionOperador = new InvDistribucionOperaciones();
$invPaca = $invDistribucionOperador->getInvDistribucion($codPaca);

try {
    if ($invPaca >= $cantidadPacas) {
        $relDisEmpOperador = new RelDisEmpOperaciones();
        $unidad = $relDisEmpOperador->getUnidadByPaca($codPaca);
        $invUnidad = $invDistribucionOperador->getInvDistribucion($unidad['codUnidad']);
        $cantidad = $unidad['cantidad'];
        $nvoInvUnidades = $invUnidad + $cantidad * $cantidadPacas;
        $datos = array($nvoInvUnidades, $unidad['codUnidad']);
        $invDistribucionOperador->updateInvDistribucion($datos);
        $nvoInvPacas = $invPaca - $cantidadPacas;
        $datos = array($nvoInvPacas, $codPaca);
        $invDistribucionOperador->updateInvDistribucion($datos);
        $ruta = "../menu.php";
        $mensaje = "Desempaque de Producto realizado con Éxito";
    } else {
        $ruta = "desempacar.php";
        $mensaje = "No hay inventario suficiente de Pacas del producto";
    }

} catch (Exception $e) {
    $ruta = "desempacar.php";
    $mensaje = "Error al desempacar el producto";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}

