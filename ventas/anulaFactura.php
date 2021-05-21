<?php
include "../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idFactura = $_POST['idFactura'];
$observaciones = $_POST['observaciones'];

$facturaOperador = new FacturasOperaciones();
$detFacturaOperador = new DetFacturaOperaciones();
$detRemisionOperador = new DetRemisionesOperaciones();
$invProdTerminadoOperador = new InvProdTerminadosOperaciones();
$invDistribucionOperador = new InvDistribucionOperaciones();
$remisionOperador = new RemisionesOperaciones();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Anular Factura</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$factura = $facturaOperador->getFactura($idFactura);
$remisiones = explode(',', $factura['idRemision']);
$detalleRemision = $detRemisionOperador->getDetRemisionesFacturaLote($factura['idRemision']);

try {
    for ($i = 0; $i < count($detalleRemision); $i++) {
        $codProducto = $detalleRemision[$i]['codProducto'];
        $cantProducto = $detalleRemision[$i]['cantidadProducto'];
        $loteProducto = $detalleRemision[$i]['loteProducto'];

        /*DESCARGA DEL INVENTARIO*/
        $unidades = $cantProducto;
        if (($codProducto < 100000) && ($codProducto > 1000)) {
            $invProdTerminado = $invProdTerminadoOperador->getInvProdTerminadoByLote($codProducto, $loteProducto);
            $nvoInvProdTerminado = $invProdTerminado + $cantProducto;
            /*SE ACTUALIZA EL INVENTARIO*/
            $datos = array($nvoInvProdTerminado, $codProducto, $loteProducto);
            $invProdTerminadoOperador->updateInvProdTerminado($datos);
        }
        if ($codProducto > 100000) {
            //PRODUCTOS DE DISTRIBUCIÓN
            $invDistribucionOperador = new InvDistribucionOperaciones();
            $invDistribucion = $invDistribucionOperador->getInvDistribucion($codProducto);
            $nvoInvDistribucion = $invDistribucion + $cantProducto;
            /*SE ACTUALIZA EL INVENTARIO*/
            $datos = array($nvoInvDistribucion, $codProducto);
            $invDistribucionOperador->updateInvDistribucion($datos);
        }

    }
    /*SE BORRA EL DETALLE DE LA FACTURA*/
    $detFacturaOperador->deleteAllDetFactura($idFactura);
    /*SE BORRA EL DETALLE DE LA REMISION*/
    foreach ($remisiones as $remision) {
        $detRemisionOperador->deleteDetRemisionFactura($remision);
        $remisionOperador->deleteSalidaRemision($remision);
    }
    //CAMBIA EL ESTADO DE LA FACTURA
    $facturaOperador->anularFactura($observaciones, $idFactura);
    $ruta = "listarFacturas.php";
    $mensaje = "Factura anulada con éxito";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "anularFactura.php";
    $mensaje = "Error al anular la factura";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
