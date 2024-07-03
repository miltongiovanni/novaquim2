<?php
include "../../../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idRemision = $_POST['idRemision'];
$codProducto = $_POST['codProducto'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Eliminación detalle de remisión</title>
    <meta charset="utf-8">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
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
    $ruta = "../detalle-remision/";
    $mensaje = "Detalle de remisión eliminado correctamente";
    $icon = "success";
} catch (Exception $e) {
    $_SESSION['idRemision'] = $idRemision;
    $ruta = "../detalle-remision/";
    $mensaje = "Error al eliminar el detalle de la remisión";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>