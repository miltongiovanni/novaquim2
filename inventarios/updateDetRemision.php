<?php
include "../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$idRemision = $_POST['idRemision'];
$codProducto = $_POST['codProducto'];
$cantProducto = $_POST['cantProducto'];
$remisionOperador = new RemisionesOperaciones();
$detRemisionOperador = new DetRemisionesOperaciones();
$invProdTerminadoOperador = new InvProdTerminadosOperaciones();
$invDistribucionOperador = new InvDistribucionOperaciones();


try {
    $detalle = $detRemisionOperador->getDetTotalRemision($idRemision, $codProducto);
    $cantProductoAnt = $detalle['cantProducto'];
    if ($codProducto < 100000) {
        //PRODUCTOS DE LA EMPRESA
        $diffCantidad = $cantProducto - $cantProductoAnt;
        if ($diffCantidad > 0) {
            $invTotalProd = $invProdTerminadoOperador->getInvTotalProdTerminado($codProducto);
            if ($diffCantidad > $invTotalProd) {
                $_SESSION['idRemision'] = $idRemision;
                $ruta = "det_remision.php";
                $mensaje = "No hay inventario suficiente";
            } else {
                $unidades = $diffCantidad;
                $invProdTerminado = $invProdTerminadoOperador->getInvProdTerminado($codProducto);
                for ($i = 0; $i < count($invProdTerminado); $i++) {
                    $inv = $invProdTerminado[$i]['invProd'];
                    $lote = $invProdTerminado[$i]['loteProd'];
                    if ($inv >= $unidades) {
                        $nvoInv = $inv - $unidades;
                        $datos = array($idRemision, $codProducto, $unidades, $lote);
                        $detRemisionOperador->makeDetRemision($datos);
                        $unidades = 0;
                        $datos = array($nvoInv, $codProducto, $lote);
                        $invProdTerminadoOperador->updateInvProdTerminado($datos);

                    } else {
                        $unidades -= $inv;
                        $datos = array(0, $codProducto, $lote);
                        $invProdTerminadoOperador->updateInvProdTerminado($datos);
                        $datos = array($idRemision, $codProducto, $inv, $lote);
                        $detRemisionOperador->makeDetRemision($datos);
                    }
                }
                $_SESSION['idRemision'] = $idRemision;
                $ruta = "det_remision.php";
                $mensaje = "Detalle de la remisión actualizado con éxito";
            }
        } else {//problema
            $productos = $detRemisionOperador->getDetRemision($idRemision, $codProducto);
            $cantFinal = count($productos) + $diffCantidad;
            $diff = abs($diffCantidad);
            $nvaCantidad = 0;
            for ($i = (count($productos) - 1); $i > 0; $i--) {
                $loteProducto = $productos[$i]['loteProducto'];
                $cantProducto = $productos[$i]['cantProducto'];
                $codProducto= $productos[$i]['codProducto'];
                $invActual = $invProdTerminadoOperador->getInvByLoteAndProd($codProducto,$loteProducto);
                if ($cantProducto >= $diff) {
                    $nvaCantidad = $cantProducto - $diff;
                    $datos = array($nvaCantidad, $idRemision, $codProducto, $loteProducto);
                    $detRemisionOperador->updateDetRemision($datos);
                    $nvoInv = $invActual + $diff;
                    $datos = array($nvoInv, $codProducto, $loteProducto);
                    $invProdTerminadoOperador->updateInvProdTerminado($datos);
                    break;
                } else {
                    $diff -= $cantProducto;
                    $datos = array($idRemision, $codProducto, $loteProducto);
                    $detRemisionOperador->deleteDetRemision($datos);
                    $nvoInv = $invActual + $diff;
                    $datos = array($nvoInv, $codProducto, $loteProducto);
                    $invProdTerminadoOperador->updateInvProdTerminado($datos);

                }
                $_SESSION['idRemision'] = $idRemision;
                $ruta = "det_remision.php";
                $mensaje = "Detalle de la remisión actualizado con éxito";
            }
        }
    }

} catch (Exception $e) {
    $_SESSION['idRemision'] = $idRemision;
    $ruta = "det_remision.php";
    $mensaje = "Error al actualizar el detalle de la remisión";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}


?>
