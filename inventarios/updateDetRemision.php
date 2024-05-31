<?php
include "../../../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar detalle de la remisión</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$idRemision = $_POST['idRemision'];
$codProducto = $_POST['codProducto'];
$cantProducto = $_POST['cantProducto'];
$precioProducto = $_POST['precioProducto'];
$remisionOperador = new RemisionesOperaciones();
$detRemisionOperador = new DetRemisionesOperaciones();
$invProdTerminadoOperador = new InvProdTerminadosOperaciones();
$invDistribucionOperador = new InvDistribucionOperaciones();


try {
    $detalle = $detRemisionOperador->getDetTotalRemision($idRemision, $codProducto);
    $cantProductoAnt = $detalle['cantProducto'];
    $diffCantidad = $cantProducto - $cantProductoAnt;
    if ($codProducto < 100000) {
        //PRODUCTOS DE LA EMPRESA
        if ($diffCantidad > 0) {
            $invTotalProd = $invProdTerminadoOperador->getInvTotalProdTerminado($codProducto);
            if ($diffCantidad > $invTotalProd) {
                $_SESSION['idRemision'] = $idRemision;
                $ruta = "det_remision.php";
                $mensaje = "No hay inventario suficiente";
                $icon = "warning";
            } else {
                $unidades = $diffCantidad;
                $invProdTerminado = $invProdTerminadoOperador->getInvProdTerminado($codProducto);
                for ($i = 0; $i < count($invProdTerminado); $i++) {
                    $inv = $invProdTerminado[$i]['invProd'];
                    $lote = $invProdTerminado[$i]['loteProd'];
                    if ($inv >= $unidades) {
                        $nvoInv = $inv - $unidades;
                        $datos = array($idRemision, $codProducto, $unidades, $lote, $precioProducto);
                        $detRemisionOperador->makeDetRemision($datos);
                        $unidades = 0;
                        $datos = array($nvoInv, $codProducto, $lote);
                        $invProdTerminadoOperador->updateInvProdTerminado($datos);

                    } else {
                        $unidades -= $inv;
                        $datos = array(0, $codProducto, $lote);
                        $invProdTerminadoOperador->updateInvProdTerminado($datos);
                        $datos = array($idRemision, $codProducto, $inv, $lote, $precioProducto);
                        $detRemisionOperador->makeDetRemision($datos);
                    }
                }
                $_SESSION['idRemision'] = $idRemision;
                $ruta = "det_remision.php";
                $mensaje = "Detalle de la remisión actualizado con éxito";
                $icon = "success";
            }
        } else {//problema
            $productos = $detRemisionOperador->getDetRemision($idRemision, $codProducto);
            $cantFinal = count($productos) + $diffCantidad;
            $diff = abs($diffCantidad);
            $nvaCantidad = 0;
            for ($i = (count($productos) - 1); $i > 0; $i--) {
                $loteProducto = $productos[$i]['loteProducto'];
                $cantProducto = $productos[$i]['cantProducto'];
                $codProducto = $productos[$i]['codProducto'];
                $invActual = $invProdTerminadoOperador->getInvByLoteAndProd($codProducto, $loteProducto);
                if ($cantProducto >= $diff) {
                    $nvaCantidad = $cantProducto - $diff;
                    $datos = array($nvaCantidad, $precioProducto, $idRemision, $codProducto, $loteProducto);
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
            }
            $_SESSION['idRemision'] = $idRemision;
            $ruta = "det_remision.php";
            $mensaje = "Detalle de la remisión actualizado con éxito";
            $icon = "success";
        }
    } else {
        //PRODUCTOS DE DISTRIBUCIÓN
        $invDistribucionOperador = new InvDistribucionOperaciones();
        $invDistribucion = $invDistribucionOperador->getInvDistribucion($codProducto);
        if ($diffCantidad > $invDistribucion) {
            $_SESSION['idRemision'] = $idRemision;
            $ruta = "det_remision.php";
            $mensaje = "No hay inventario suficiente";
            $icon = "warning";
        } else {
            $nvoInvDistribucion = $invDistribucion - $diffCantidad;
            $datos = array($nvoInvDistribucion, $codProducto);
            $invDistribucionOperador->updateInvDistribucion($datos);
            $datos = array($cantProducto, $precioProducto, $idRemision, $codProducto,0);
            $detRemisionOperador->updateDetRemision($datos);
            $_SESSION['idRemision'] = $idRemision;
            $ruta = "det_remision.php";
            $mensaje = "Detalle de la remisión actualizado con éxito";
            $icon = "success";
        }

    }

} catch (Exception $e) {
    $_SESSION['idRemision'] = $idRemision;
    $ruta = "det_remision.php";
    $mensaje = "Error al actualizar el detalle de la remisión";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}


?>
</body>
</html>