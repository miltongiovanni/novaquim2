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

$factura = $facturaOperador->getFactura($idFactura);
$idRemision = $factura['idRemision'];
$detalleRemision = $detRemisionOperador->getDetRemisionLote($idRemision);

try {
    for ($i = 0; $i < count($detalleRemision); $i++) {
        $codProducto = $detalleRemision[$i]['codProducto'];
        $cantProducto = $detalleRemision[$i]['cantProducto'];
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
    $detRemisionOperador->deleteDetRemisionFactura($idRemision);
    //CAMBIA EL ESTADO DE LA FACTURA
    $facturaOperador->anularFactura($observaciones, $idFactura);
    $ruta = "listarFacturas.php";
    $mensaje = "Factura anulada con éxito";
}catch (Exception $e){
    $ruta = "anularFactura.php";
    $mensaje = "Error al anular la factura";
} finally
{
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}
