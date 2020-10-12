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
$DetOProdColorOperador = new DetOProdColorOperaciones();
$InvMPrimaOperador = new InvMPrimasOperaciones();
$datos = array($cantMPrima, $loteColor, $codMPrima);
try {
    $DetOProdColorOperador->updateDetOProdColor($datos);
    $invMPrima = $InvMPrimaOperador->getInvMPrimaByLote($codMPrima, $loteMPrima);
    $nvoInvMPrima = $invMPrima + $cantidad_ant - $cantMPrima;
    $datos = array($nvoInvMPrima, $codMPrima, $loteMPrima);
    $InvMPrimaOperador->updateInvMPrima($datos);
    $_SESSION['loteColor'] = $loteColor;
    $ruta = "detO_Prod_col.php";
    $mensaje = "Detalle Orden de Producción de color actualizado correctamente";
} catch (Exception $e) {
    $_SESSION['loteColor'] = $loteColor;
    $ruta = "detO_Prod_col.php";
    $mensaje = "Error al actualizar Orden de Producción de color";
} finally {
    mover_pag($ruta, $mensaje);
}
