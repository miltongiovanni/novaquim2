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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Crear Detalle Nota Crédito</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$notaCrOperador = new NotasCreditoOperaciones();
$detNotaCrOperador = new DetNotaCrOperaciones();
$notaC = $notaCrOperador->getNotaC($idNotaC);
$facturaOperador = new FacturasOperaciones();
$facturaOrigen = $facturaOperador->getFactura($notaC['facturaOrigen']);
$facturaDestino = $facturaOperador->getFactura($notaC['facturaDestino']);

try {
    if ($motivo == 0) {
        $detRemisionOperador = new DetRemisionesOperaciones();
        $detRemision = $detRemisionOperador->getDetRemisionProducto($facturaOrigen['idRemision'], $codProducto);
        if ($codProducto > 100000) {
            //PRODUCTOS DE DISTRIBUCIÓN
            $invDistibucionOperador = new InvDistribucionOperaciones();
            $invProdDistribucion = $invDistibucionOperador->getInvDistribucion($codProducto);
            $invProdDistribucion = round($invProdDistribucion);
            if ($invProdDistribucion > 0) { //Update inventario
                $nvoInvProdDistribucion = $invProdDistribucion + $cantProducto;
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

        } elseif ($codProducto > 10000 && $codProducto < 100000) {
            //PRODUCTOS DE LA EMPRESA
            $invPresentacionOperador = new InvProdTerminadosOperaciones();
            $invProdTerminado = $invPresentacionOperador->getInvProdTerminadoByLote($codProducto, $detRemision['loteProducto']);
            $invProdTerminado = round($invProdTerminado);
            if ($invProdTerminado > 0) { //Update inventario
                $nvoInvProdTerminado = $invProdTerminado + $cantProducto;
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
        }
        $datos = array($idNotaC, $codProducto, $cantProducto);
        $detNotaCrOperador->makeDetNotaCr($datos);
        $totalesNotaC = $notaCrOperador->getTotalesNotaC($idNotaC);
        $datos = array($totalesNotaC['subtotal'], $totalesNotaC['totalNotaC'], $totalesNotaC['iva'], $idNotaC);
        $notaCrOperador->updateTotalesNotaC($datos);
        if (abs($facturaDestino['totalR'] - $facturaDestino['retencionFte'] - $facturaDestino['retencionIca'] - $facturaDestino['retencionIva'] - $totalesNotaC['totalNotaC']) < 100) {
            $facturaOperador->cancelarFactura($notaC['fechaNotaC'], $notaC['facturaDestino']);
        }
    } else {
        if ($detNotaCrOperador->hasDescNotaCr($idNotaC)) {
            //update
            $datos = array($cantProducto, $idNotaC, 0);
            $detNotaCrOperador->updateDetNotaCr($datos);
            $datos = array($facturaOrigen['subtotal']*($cantProducto/100), $facturaOrigen['total']*($cantProducto/100), $facturaOrigen['iva']*($cantProducto/100), $idNotaC);
            $notaCrOperador->updateTotalesNotaC($datos);
        } else {
            //insert
            $datos = array($idNotaC, 0, $cantProducto);
            $detNotaCrOperador->makeDetNotaCr($datos);
            $datos = array($facturaOrigen['subtotal']*($cantProducto/100), $facturaOrigen['total']*($cantProducto/100), $facturaOrigen['iva']*($cantProducto/100), $idNotaC);
            $notaCrOperador->updateTotalesNotaC($datos);
        }
    }
    $_SESSION['idNotaC'] = $idNotaC;
    $ruta = "detalleNotaC.php";
    $mensaje = "Detalle de nota crédito adicionado con éxito";
    $icon = "success";
} catch (Exception $e) {
    $_SESSION['idNotaC'] = $idNotaC;
    $ruta = "detalleNotaC.php";
    $mensaje = "Error al ingresar el detalle de nota crédito";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
