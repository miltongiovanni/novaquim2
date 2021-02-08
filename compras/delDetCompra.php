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
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Eliminar detalle compra</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$CompraOperador = new ComprasOperaciones();
$DetCompraOperador = new DetComprasOperaciones();
$detalle = $DetCompraOperador->getDetCompra($idCompra, $tipoCompra, $codigo);
$lote=$detalle['lote'];
try {
    $datos = array($idCompra, $codigo);
    $DetCompraOperador->deleteDetCompra( $datos);
    $CompraOperador->updateTotalesCompra($tipoCompra, BASE_C, $idCompra);
    if ($tipoCompra == 1) {
        $InvMPrimasOperador = new InvMPrimasOperaciones();
        $invActual = $InvMPrimasOperador->getInvMPrimaByLote($codigo, $lote);
        $nvoInv = $invActual - $detalle['cantidad'];
        $datos = array($nvoInv, $codigo, $lote);
        $InvMPrimasOperador->updateInvMPrima($datos);
    }
    if ($tipoCompra == 2) {
        if($codigo < 100){
            $InvEnvaseOperador = new InvEnvasesOperaciones();
            $invActual = $InvEnvaseOperador->getInvEnvase($codigo);
            $nvoInv = $invActual - $detalle['cantidad'];
            $datos = array($nvoInv, $codigo);
            $InvEnvaseOperador->updateInvEnvase($datos);
        }
        else{
            $InvTapasOperador = new InvTapasOperaciones();
            $invActual = $InvTapasOperador->getInvTapas($codigo);
            $nvoInv = $invActual - $detalle['cantidad'];
            $datos = array($nvoInv, $codigo);
            $InvTapasOperador->updateInvTapas($datos);
        }
    }
    if ($tipoCompra == 3) {
        $InvEtiquetaOperador = new InvEtiquetasOperaciones();
        $invActual = $InvEtiquetaOperador->getInvEtiqueta($codigo);
        $nvoInv = $invActual - $detalle['cantidad'];
        $datos = array($nvoInv, $codigo);
        $InvEtiquetaOperador->updateInvEtiqueta($datos);
    }
    if ($tipoCompra == 5) {
        $InvDistribucionOperador = new InvDistribucionOperaciones();
        $invActual = $InvDistribucionOperador->getInvDistribucion($codigo);
        $nvoInv = $invActual - $detalle['cantidad'];
        $datos = array($nvoInv, $codigo);
        $InvDistribucionOperador->updateInvDistribucion($datos);
    }
    $_SESSION['idCompra'] = $idCompra;
    $_SESSION['tipoCompra'] = $tipoCompra;
    $ruta = "detCompra.php";
    $mensaje = "Detalle de compra eliminado con éxito";
    $icon = "success";
} catch (Exception $e) {
    $_SESSION['idCompra'] = $idCompra;
    $_SESSION['tipoCompra'] = $tipoCompra;
    $ruta = "detCompra.php";
    $mensaje = "Error al eliminar el detalle de la factura de compra";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>