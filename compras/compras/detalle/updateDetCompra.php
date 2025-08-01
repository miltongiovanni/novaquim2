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
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar compra</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
$CompraOperador = new ComprasOperaciones();
$DetCompraOperador = new DetComprasOperaciones();
$detalle = $DetCompraOperador->getDetCompra($idCompra, $tipoCompra, $codigo);

try {
    if ($tipoCompra == 1) {
        $datos = array($cantidad, $precio, $lote, $idCompra, $codigo);
    } else {
        $datos = array($cantidad, $precio, $idCompra, $codigo);
    }
    $DetCompraOperador->updateDetCompra($tipoCompra, $datos);
    $CompraOperador->updateTotalesCompra($tipoCompra, BASE_C, BASE_C3, $idCompra);
    if ($tipoCompra == 1) {
        $loteAnterior = $detalle['lote'];
        $calMatPrimaOperador = new CalMatPrimaOperaciones();
        $calMatPrimaId = $calMatPrimaOperador->getIdCalMatPrimaToUpdateCompra($codigo, $lote, $idCompra);
        if ($lote == $loteAnterior) {
            $datos = array($lote, $fechLote, $cantidad, $calMatPrimaId );
            $calMatPrimaOperador->updateEncabezadoCalMatPrima($datos);
        } else {
            $calMatPrimaOperador->deleteCalMatPrima($calMatPrimaId);
            $datos_calidad = array($codigo, $lote, $cantidad, $fechLote, $idCompra);
            $calMatPrimaOperador->makeCalMatPrima($datos_calidad);
        }

        //CONTROL DE CALIDAD AQUI
//        $InvMPrimasOperador = new InvMPrimasOperaciones();
//        if ($lote == $loteAnterior) {
//            $invActual = $InvMPrimasOperador->getInvMPrimaByLote($codigo, $lote);
//            $nvoInv = $invActual + $cantidad - $detalle['cantidad'];
//            $datos = array($nvoInv, $codigo, $lote);
//            $InvMPrimasOperador->updateInvMPrima($datos);
//        } else {
//            $InvMPrimasOperador->deleteInvMPrima(array($codigo, $loteAnterior));
//            $InvMPrimasOperador->makeInvMPrima(array($codigo, $lote, $cantidad, $fechLote));
//        }


        $MPrimasOperador = new MPrimasOperaciones();
        $precioActual = $MPrimasOperador->getPrecioMPrima($codigo);
        if ($precio > $precioActual) {
            $datos = array($precio, $codigo);
            $MPrimasOperador->updatePrecioMPrima($datos);
        }
    }
    if ($tipoCompra == 2) {
        if ($codigo < 100) {
            $InvEnvaseOperador = new InvEnvasesOperaciones();
            $invActual = $InvEnvaseOperador->getInvEnvase($codigo);
            $nvoInv = $invActual + $cantidad - $detalle['cantidad'];
            $datos = array($nvoInv, $codigo);
            $InvEnvaseOperador->updateInvEnvase($datos);
            $EnvaseOperador = new EnvasesOperaciones();
            $precioActual = $EnvaseOperador->getPrecioEnvase($codigo);
            if ($precio > $precioActual) {
                $datos = array($precio, $codigo);
                $EnvaseOperador->updatePrecioEnvase($datos);
            }
        } else {
            $InvTapasOperador = new InvTapasOperaciones();
            $invActual = $InvTapasOperador->getInvTapas($codigo);
            $nvoInv = $invActual + $cantidad - $detalle['cantidad'];
            $datos = array($nvoInv, $codigo);
            $InvTapasOperador->updateInvTapas($datos);
            $TapasOperador = new TapasOperaciones();
            $precioActual = $TapasOperador->getPrecioTapa($codigo);
            if ($precio > $precioActual) {
                $datos = array($precio, $codigo);
                $TapasOperador->updatePrecioTapa($datos);
            }
        }
    }
    if ($tipoCompra == 3) {
        $InvEtiquetaOperador = new InvEtiquetasOperaciones();
        $invActual = $InvEtiquetaOperador->getInvEtiqueta($codigo);
        $nvoInv = $invActual + $cantidad - $detalle['cantidad'];
        $datos = array($nvoInv, $codigo);
        $InvEtiquetaOperador->updateInvEtiqueta($datos);
        $EtiquetaOperador = new EtiquetasOperaciones();
        $precioActual = $EtiquetaOperador->getPrecioEtiqueta($codigo);
        if ($precio > $precioActual) {
            $datos = array($precio, $codigo);
            $EtiquetaOperador->updatePrecioEtiqueta($datos);
        }
    }
    if ($tipoCompra == 5) {
        $InvDistribucionOperador = new InvDistribucionOperaciones();
        $invActual = $InvDistribucionOperador->getInvDistribucion($codigo);
        $nvoInv = $invActual + $cantidad - $detalle['cantidad'];
        $datos = array($nvoInv, $codigo);
        $InvDistribucionOperador->updateInvDistribucion($datos);
        $ProdDistribucionOperador = new ProductosDistribucionOperaciones();
        $precioActual = $ProdDistribucionOperador->getPrecioProductoDistribucion($codigo);
        if ($precio > $precioActual) {
            $datos = array($precio, $codigo);
            $ProdDistribucionOperador->updatePrecioCompraProductoDistribucion($datos);
        }
    }
    $_SESSION['idCompra'] = $idCompra;
    $_SESSION['tipoCompra'] = $tipoCompra;
    $ruta = "../detalle/";
    $mensaje = "Detalle de compra actualizado con éxito";
    $icon = "success";
} catch (Exception $e) {
    $_SESSION['idCompra'] = $idCompra;
    $_SESSION['tipoCompra'] = $tipoCompra;
    $ruta = "../detalle/";
    $mensaje = "Error al actualizar el detalle de la factura de compra";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>