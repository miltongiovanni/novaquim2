<?php
include "../../../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$idRemision = $_POST['idRemision'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Anular Remisión</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
$remisionOperador = new RemisionesOperaciones();
$detRemisionOperador = new DetRemisionesOperaciones();
$invProdTerminadoOperador = new InvProdTerminadosOperaciones();
$invDistribucionOperador = new InvDistribucionOperaciones();

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
    //SE BORRA EL DETALLE DE LA REMISION
    $detRemisionOperador->deleteDetRemisionFactura($idRemision);
    //SE BORRA LA REMISION
    $remisionOperador->deleteSalidaRemision($idRemision);
    $ruta = "listarRemisiones.php";
    $mensaje = "Remisión anulada con éxito";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "anularRemision.php";
    $mensaje = "Error al anular la remisión";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
