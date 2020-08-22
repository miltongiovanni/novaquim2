<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$codUnidad = $_POST['codUnidad'];
$unidades = $_POST['unidades'];

$invDistribucionOperador = new InvDistribucionOperaciones();
$invUnidad = $invDistribucionOperador->getInvDistribucion($codUnidad);
$relDisEmpOperador = new RelDisEmpOperaciones();
$paca = $relDisEmpOperador->getPacaByUnidad($codUnidad);
$noPacas = intval($unidades / $paca['cantidad']);

try {
    if ($unidades >= $paca['cantidad']) {
        $invPaca = $invDistribucionOperador->getInvDistribucion($paca['codPaca']);
        $nvoInvUnidades = $invUnidad - $noPacas * $paca['cantidad'];
        $datos = array($nvoInvUnidades, $codUnidad);
        $invDistribucionOperador->updateInvDistribucion($datos);
        $nvoInvPacas = $invPaca + $noPacas;
        $datos = array($nvoInvPacas, $paca['codPaca']);
        $invDistribucionOperador->updateInvDistribucion($datos);
        $ruta = "../menu.php";
        $mensaje = "Empaque de Producto realizado con Éxito";
    } else {
        $ruta = "empacar.php";
        $mensaje = "El número de unidades no completa una paca";
    }

} catch (Exception $e) {
    $ruta = "desempacar.php";
    $mensaje = "Error al desempacar el producto";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}




