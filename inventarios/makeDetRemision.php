<?php
include "../includes/valAcc.php";
include "../includes/calcularDias.php";
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
$remisionOperador = new RemisionesOperaciones();
$detRemisionOperador = new DetRemisionesOperaciones();


try {
    if ($codProducto > 100000) {
        //PRODUCTOS DE DISTRIBUCIÓN
        $invDistribucionOperador = new InvDistribucionOperaciones();
        $invDistribucion = $invDistribucionOperador->getInvDistribucion($codProducto);
        if ($cantProducto > $invDistribucion) {
            $_SESSION['idRemision'] = $idRemision;
            $ruta = "det_remision.php";
            $mensaje = "No hay inventario suficiente";
        } else {
            $nvoInvDistribucion = $invDistribucion - $cantProducto;
            $datos = array($nvoInvDistribucion, $codProducto);
            $invDistribucionOperador->updateInvDistribucion($datos);
            $datos = array($idRemision, $codProducto, $cantProducto, 0);
            $detRemisionOperador->makeDetRemision($datos);
            $_SESSION['idRemision'] = $idRemision;
            $ruta = "det_remision.php";
            $mensaje = "Detalle de la remisión adicionado con éxito";
        }
    } else {
        //PRODUCTOS DE LA EMPRESA
        $unidades = $cantProducto;
        $invProdTerminadoOperador = new InvProdTerminadosOperaciones();
        $invTotalProdTerminado = $invProdTerminadoOperador->getInvTotalProdTerminado($codProducto);
        if ($cantProducto > $invTotalProdTerminado) {
            $_SESSION['idRemision'] = $idRemision;
            $ruta = "det_remision.php";
            $mensaje = "No hay inventario suficiente";
        } else {
            $invProdTerminado = $invProdTerminadoOperador->getInvProdTerminado($codProducto);
            for ($i = 0; $i < count($invProdTerminado); $i++) {
                $inv = $invProdTerminado[$i]['invProd'];
                $lote = $invProdTerminado[$i]['loteProd'];
                if ($inv >= $unidades) {
                    $nvoInv = $inv - $unidades;
                    $datos = array($idRemision, $codProducto, $unidades, $lote);
                    $detRemisionOperador->makeDetRemisionFactura($datos);
                    $unidades = 0;
                    $datos = array($nvoInv, $codProducto, $lote);
                    $invProdTerminadoOperador->updateInvProdTerminado($datos);
                    break;
                } else {
                    $unidades = $unidades - $inv;
                    $datos = array(0, $codProducto, $lote);
                    $invProdTerminadoOperador->updateInvProdTerminado($datos);
                    $datos = array($idRemision, $codProducto, $inv, $lote);
                    $detRemisionOperador->makeDetRemision($datos);
                }
            }
            $_SESSION['idRemision'] = $idRemision;
            $ruta = "det_remision.php";
            $mensaje = "Detalle de la remisión adicionado con éxito";
        }
    }

} catch (Exception $e) {
    $_SESSION['idRemision'] = $idRemision;
    $ruta = "det_remision.php";
    $ruta = $rutaError;
    $mensaje = "Error al ingresar el detalle de la remisión";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}


?>
