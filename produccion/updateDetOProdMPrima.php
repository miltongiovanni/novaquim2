<?php
include "../includes/valAcc.php";
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$DetOProdMPrimaOperador = new DetOProdMPrimaOperaciones();
$InvMPrimaOperador = new InvMPrimasOperaciones();
$datos = array($cantMPrima, $loteMP, $idMPrima);
try {
    $DetOProdMPrimaOperador->updateDetOProdMPrimas($datos);
    $invMPrima = $InvMPrimaOperador->getInvMPrimaByLote($idMPrima, $loteMPrima);
    $nvoInvMPrima = $invMPrima + $cantidad_ant - $cantMPrima;
    $datos = array($nvoInvMPrima, $idMPrima, $loteMPrima);
    $InvMPrimaOperador->updateInvMPrima($datos);
    $_SESSION['loteMP'] = $loteMP;
    $ruta = "detO_Prod_MP.php";
    $mensaje = "Detalle orden de producción de materia prima actualizado correctamente";
} catch (Exception $e) {
    $_SESSION['loteMP'] = $loteMP;
    $ruta = "detO_Prod_MP.php";
    $mensaje = "Error al actualizar el detalle orden de producción de materia prima";
} finally {
    mover_pag($ruta, $mensaje, $icon);
}
