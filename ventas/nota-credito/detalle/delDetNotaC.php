<?php
include "../../../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de la Nota Crédito</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>

</head>
<body>
<?php
$notaCrOperador = new NotasCreditoOperaciones();
$detNotaCrOperador = new DetNotaCrOperaciones();
$notaC = $notaCrOperador->getNotaC($idNotaC);
$facturaOperador = new FacturasOperaciones();
$facturaOrigen = $facturaOperador->getFactura($notaC['facturaOrigen']);
$detRemisionOperador = new DetRemisionesOperaciones();
$detRemision = $detRemisionOperador->getDetRemisionProducto($facturaOrigen['idRemision'], $codProducto);
$detalle = $detNotaCrOperador->getDetProdNotaCr($idNotaC, $codProducto);
$cantProducto = intval($detalle['cantProducto']);
//ESTO ES PARA MIRAR LA CANTIDAD DE PRODUCTO QUE TENÌA LA NOTA
try {
    if ($codProducto > 10000 && $codProducto < 100000) {
        //SI ES PRODUCTO DE LÍNEA
        $invPresentacionOperador = new InvProdTerminadosOperaciones();
        $invProdTerminado = $invPresentacionOperador->getInvProdTerminadoByLote($codProducto, $detRemision['loteProducto']);
        $invProdTerminado = round($invProdTerminado);
        if ($invProdTerminado > 0) { //Update inventario
            $nvoInvProdTerminado = $invProdTerminado - $cantProducto;
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
            $nvoInvProdDistribucion = $invProdDistribucion - $cantProducto;
            $datos = array($nvoInvProdDistribucion, $codProducto);
            $invDistibucionOperador->updateInvDistribucion($datos);

        } else {//Insert inventario
            if ($invDistibucionOperador->existeInvDistribucion($codProducto)) {
                $datos = array($cantProducto, $codProducto);
                $invDistibucionOperador->updateInvDistribucion($datos);
            } else {
                $datos = array($codProducto, $cantProducto);
                $invDistibucionOperador->makeInvDistribucion($datos);
            }
        }
    }
    $datos = array($idNotaC, $codProducto);
    $detNotaCrOperador->deleteDetNotaCr($datos);
    $totalesNotaC = $notaCrOperador->getTotalesNotaC($idNotaC);
    $datos = array($totalesNotaC['subtotal'], $totalesNotaC['totalNotaC'], $totalesNotaC['iva'], $idNotaC);
    $notaCrOperador->updateTotalesNotaC($datos);
    $_SESSION['idNotaC'] = $idNotaC;
    $ruta = "detalleNotaC.php";
    $mensaje = "Detalle de nota crédito eliminado con éxito";
    $icon = "success";
} catch (Exception $e) {
    $_SESSION['idNotaC'] = $idNotaC;
    $ruta = "detalleNotaC.php";
    $mensaje = "Error al eliminar el detalle de nota crédito";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
