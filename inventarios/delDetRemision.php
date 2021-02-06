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

$remisionOperador = new RemisionesOperaciones();
$detRemisionOperador = new DetRemisionesOperaciones();
$invProdTerminadoOperador = new InvProdTerminadosOperaciones();
$invDistribucionOperador = new InvDistribucionOperaciones();
try {
    //REVISA EL INVENTARIO DE PRODUCTO
    if ($codProducto < 100000) {//PRODUCTOS DE LA EMPRESA
        $productos = $detRemisionOperador->getDetRemision($idRemision, $codProducto);
        for ($i = 0; $i < count($productos); $i++) {
            $loteProducto = $productos[$i]['loteProducto'];
            $cantProducto = $productos[$i]['cantProducto'];
            $invProducto = $invProdTerminadoOperador->getInvByLoteAndProd($codProducto, $loteProducto);
            $nvoInv = $invProducto + $cantProducto;
            $datos = array($nvoInv, $codProducto, $loteProducto);
            $invProdTerminadoOperador->updateInvProdTerminado($datos);
            $datos = array($idRemision, $codProducto, $loteProducto);
            $detRemisionOperador->deleteDetRemision($datos);
        }
    } else {
        $productos = $detRemisionOperador->getDetTotalRemision($idRemision, $codProducto);
        $cantProducto = $productos['cantProducto'];
        $invProducto = $invDistribucionOperador->getInvDistribucion($codProducto);
        $nvoInv = $invProducto + $cantProducto;
        $datos = array($nvoInv, $codProducto);
        $invDistribucionOperador->updateInvDistribucion($datos);
        $loteProducto =0;
        $datos = array($idRemision, $codProducto, $loteProducto);
        $detRemisionOperador->deleteDetRemision($datos);
    }
//ELIMINA EL PRODUCTO DE LA REMISION
    $_SESSION['idRemision'] = $idRemision;
    $ruta = "det_remision.php";
    $mensaje = "Detalle de remisión eliminado correctamente";
} catch (Exception $e) {
    $_SESSION['idRemision'] = $idRemision;
    $ruta = "det_remision.php";
    $mensaje = "Error al eliminar el detalle de la remisión";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}


?>
