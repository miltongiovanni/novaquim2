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
    <title>Crear Detalle Nota Crédito</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
$notaCrOperador = new NotasCreditoOperaciones();
$detNotaCrOperador = new DetNotaCrOperaciones();
$detRemisionOperador = new DetRemisionesOperaciones();
$invPresentacionOperador = new InvProdTerminadosOperaciones();
$invDistibucionOperador = new InvDistribucionOperaciones();
$notaC = $notaCrOperador->getNotaC($idNotaC);
$facturaOperador = new FacturasOperaciones();
$facturaOrigen = $facturaOperador->getFactura($notaC['facturaOrigen']);
$retFteFactura = round($facturaOrigen['retencionFte']/$facturaOrigen['subtotal'],3);
$retIcaFactura = round($facturaOrigen['retencionIca']/$facturaOrigen['subtotal'], 5);
$retIvaFactura = round($facturaOrigen['retencionIva']/$facturaOrigen['subtotal'], 3);

if(isset($notaC['facturaDestino'])) {
    $facturaDestino = $facturaOperador->getFactura($notaC['facturaDestino']);
}
try {
    if ($motivo == 0) {
        if(isset($allFactura) && $allFactura == 1 ){
            $detalleRemision = $detRemisionOperador->getDetRemisionesFacturaLote($facturaOrigen['idRemision']);
            $serviciosFactura = $facturaOperador->getServiciosByIdFactura($facturaOrigen['idRemision']);
            for ($i = 0; $i < count($detalleRemision); $i++) {
                $codProducto = $detalleRemision[$i]['codProducto'];
                $cantProducto = $detalleRemision[$i]['cantidadProducto'];
                $loteProducto = $detalleRemision[$i]['loteProducto'];

                /*DESCARGA DEL INVENTARIO*/
                $unidades = $cantProducto;
                if (($codProducto < 100000) && ($codProducto > 1000)) {
                    $invProdTerminado = $invPresentacionOperador->getInvProdTerminadoByLote($codProducto, $loteProducto);
                    $nvoInvProdTerminado = $invProdTerminado + $cantProducto;
                    /*SE ACTUALIZA EL INVENTARIO*/
                    if ($invProdTerminado === false){
                        $datos = array( $codProducto, $loteProducto, $nvoInvProdTerminado);
                        $invPresentacionOperador->makeInvProdTerminado($datos);
                    }else{
                        $datos = array($nvoInvProdTerminado, $codProducto, $loteProducto);
                        $invPresentacionOperador->updateInvProdTerminado($datos);

                    }
                    $datos = array($idNotaC, $codProducto, $cantProducto);
                    $detNotaCrOperador->makeDetNotaCr($datos);
                }
                if ($codProducto > 100000) {
                    //PRODUCTOS DE DISTRIBUCIÓN
                    $invDistribucionOperador = new InvDistribucionOperaciones();
                    $invDistribucion = $invDistribucionOperador->getInvDistribucion($codProducto);
                    $nvoInvDistribucion = $invDistribucion + $cantProducto;
                    /*SE ACTUALIZA EL INVENTARIO*/
                    $datos = array($nvoInvDistribucion, $codProducto);
                    $invDistribucionOperador->updateInvDistribucion($datos);
                    $datos = array($idNotaC, $codProducto, $cantProducto);
                    $detNotaCrOperador->makeDetNotaCr($datos);
                }
            }
            if(count($serviciosFactura)>0){
                foreach ($serviciosFactura as $servicio){
                    $datos = array($idNotaC, $servicio['codProducto'], $servicio['cantProducto']);
                    $detNotaCrOperador->makeDetNotaCr($datos);
                }
            }
            $datos = array($facturaOrigen['subtotal'], $facturaOrigen['total'], $facturaOrigen['iva'],$facturaOrigen['retencionFte'], $facturaOrigen['retencionIca'], $facturaOrigen['retencionIva'], $idNotaC);
            $notaCrOperador->updateTotalesNotaC($datos);
            $totalesNotaC = $notaCrOperador->getTotalesNotaC($idNotaC);
            if (isset($facturaDestino)){
                if (abs($facturaDestino['totalR'] - $facturaDestino['retencionFte'] - $facturaDestino['retencionIca'] - $facturaDestino['retencionIva'] - $totalesNotaC['totalNotaC']) < 100) {
                    $facturaOperador->cancelarFactura($notaC['fechaNotaC'], $notaC['facturaDestino']);
                }
            }
        }else{
            $detRemision = $detRemisionOperador->getDetRemisionProducto($facturaOrigen['idRemision'], $codProducto);
            if ($codProducto > 100000) {
                //PRODUCTOS DE DISTRIBUCIÓN
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
            $totalesNotaC['totalNotaC'] = $totalesNotaC['subtotal']+$totalesNotaC['iva']-$totalesNotaC['subtotal']*$retFteFactura-$totalesNotaC['subtotal']* $retIcaFactura-$totalesNotaC['subtotal']*$retIvaFactura;
            $datos = array($totalesNotaC['subtotal'], $totalesNotaC['totalNotaC'], $totalesNotaC['iva'], $totalesNotaC['subtotal']*$retFteFactura, $totalesNotaC['subtotal']* $retIcaFactura, $totalesNotaC['subtotal']*$retIvaFactura, $idNotaC);
            $notaCrOperador->updateTotalesNotaC($datos);
            if (isset($facturaDestino)){
                if (abs($facturaDestino['totalR'] - $facturaDestino['retencionFte'] - $facturaDestino['retencionIca'] - $facturaDestino['retencionIva'] - $totalesNotaC['totalNotaC']) < 100) {
                    $facturaOperador->cancelarFactura($notaC['fechaNotaC'], $notaC['facturaDestino']);
                }
            }
        }

    } else {
        if ($detNotaCrOperador->hasDescNotaCr($idNotaC)) {
            //update
            $datos = array($cantProducto, $idNotaC, 0);
            $detNotaCrOperador->updateDetNotaCr($datos);
            $datos = array($facturaOrigen['subtotal']*($cantProducto/100), $facturaOrigen['total']*($cantProducto/100), $facturaOrigen['iva']*($cantProducto/100),$facturaOrigen['retencionFte']*($cantProducto/100), $facturaOrigen['retencionIca']*($cantProducto/100), $facturaOrigen['retencionIva']*($cantProducto/100), $idNotaC);
            $notaCrOperador->updateTotalesNotaC($datos);
        } else {
            //insert
            $datos = array($idNotaC, 0, $cantProducto);
            $detNotaCrOperador->makeDetNotaCr($datos);
            $datos = array($facturaOrigen['subtotal']*($cantProducto/100), $facturaOrigen['total']*($cantProducto/100), $facturaOrigen['iva']*($cantProducto/100),$facturaOrigen['retencionFte']*($cantProducto/100), $facturaOrigen['retencionIca']*($cantProducto/100), $facturaOrigen['retencionIva']*($cantProducto/100), $idNotaC);
            $notaCrOperador->updateTotalesNotaC($datos);
        }
    }
    $_SESSION['idNotaC'] = $idNotaC;
    $ruta = "../detalle/";
    if(isset($allFactura) && $allFactura == 1 ){
        $mensaje = "Detalles de nota crédito adicionados con éxito";
    }else{
        $mensaje = "Detalle de nota crédito adicionado con éxito";
    }
    $icon = "success";
} catch (Exception $e) {
    $_SESSION['idNotaC'] = $idNotaC;
    $ruta = "../detalle/";
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
