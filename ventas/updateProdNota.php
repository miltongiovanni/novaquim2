<?php
include "../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if (is_array($valor)) {
        //echo $nombre_campo.print_r($valor).'<br>';
    } else {
        //echo $nombre_campo . '=' . ${$nombre_campo} . '<br>';
    }
}
$notaCrOperador = new NotasCreditoOperaciones();
$detNotaCrOperador = new DetNotaCrOperaciones();
$notaC = $notaCrOperador->getNotaC($idNotaC);
$facturaOperador = new FacturasOperaciones();
$facturaOrigen = $facturaOperador->getFactura($notaC['facturaOrigen']);
$detRemisionOperador = new DetRemisionesOperaciones();
$detRemision = $detRemisionOperador->getDetRemisionProducto($facturaOrigen['idRemision'], $codProducto);
$cambio = $cantProducto - $cantAnterior;
//ESTO ES PARA MIRAR LA CANTIDAD DE PRODUCTO QUE TENÌA LA NOTA
try {
    if ($codProducto > 10000 && $codProducto < 100000) {
        //SI ES PRODUCTO DE LÍNEA
        $invPresentacionOperador = new InvProdTerminadosOperaciones();
        $invProdTerminado = $invPresentacionOperador->getInvProdTerminadoByLote($codProducto, $detRemision['loteProducto']);
        $invProdTerminado = round($invProdTerminado);
        if ($invProdTerminado > 0) { //Update inventario
            $nvoInvProdTerminado = $invProdTerminado + $cambio;
            $datos = array($nvoInvProdTerminado, $codProducto, $detRemision['loteProducto']);
            $invPresentacionOperador->updateInvProdTerminado($datos);
        } else {//Insert inventario
            if ($invPresentacionOperador->existeInvProdTerminadoByLote($codProducto, $detRemision['loteProducto'])) {
                $datos = array($cantProducto, $codProducto, $detRemision['loteProducto']);
                $invPresentacionOperador->updateInvProdTerminado($datos);
            } else {
                $datos = array($codProducto, $detRemision['loteProducto'], $cantProducto);
                $invPresentacionOperador->makeInvProdTerminado($datos);

            }
        }
    } elseif ($codProducto > 100000) {
        //PRODUCTOS DE DISTRIBUCIÓN
        $invDistibucionOperador = new InvDistribucionOperaciones();
        $invProdDistribucion = $invDistibucionOperador->getInvDistribucion($codProducto);
        $invProdDistribucion = round($invProdDistribucion);
        if ($invProdDistribucion > 0) { //Update inventario
            $nvoInvProdDistribucion = $invProdDistribucion + $cambio;
            $datos = array($nvoInvProdDistribucion, $codProducto);
            $invDistibucionOperador->updateInvDistribucion($datos);

        } else {//Insert inventario
            if($invDistibucionOperador->existeInvDistribucion($codProducto)){
                $datos = array($cantProducto, $codProducto);
                $invDistibucionOperador->updateInvDistribucion($datos);
            }else{
                $datos = array($codProducto, $cantProducto);
                $invDistibucionOperador->makeInvDistribucion($datos);
            }
        }
    }
    $datos = array($cantProducto, $idNotaC, $codProducto);
    $detNotaCrOperador->updateDetNotaCr($datos);
    $totalesNotaC = $notaCrOperador->getTotalesNotaC($idNotaC);
    $datos = array($totalesNotaC['subtotal'], $totalesNotaC['totalNotaC'], $totalesNotaC['iva'], $idNotaC);
    $notaCrOperador->updateTotalesNotaC($datos);
    $_SESSION['idNotaC'] = $idNotaC;
    $ruta = "detalleNotaC.php";
    $mensaje = "Detalle de nota crédito actualizado con éxito";

} catch (Exception $e) {
    $_SESSION['idNotaC'] = $idNotaC;
    $ruta = "detalleNotaC.php";
    $mensaje = "Error al actualizar el detalle de nota crédito";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}

