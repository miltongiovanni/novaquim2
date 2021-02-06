<?php
include "../includes/valAcc.php";
$lote=$_POST['lote'];
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$OProdOperador = new OProdOperaciones();
$DetOProdOperador = new DetOProdOperaciones();
$InvMPrimaOperador = new InvMPrimasOperaciones();

try {
    $detalle = $DetOProdOperador->getTableDetOProd($lote);
    for($i=0; $i<count($detalle); $i++){
        $invMPrima = $InvMPrimaOperador->getInvMPrimaByLote($detalle[$i]['codMPrima'], $detalle[$i]['loteMP']);
        $nvoInvMPrima = $invMPrima + $detalle[$i]['cantidadMPrima'];
        $datos = array($nvoInvMPrima, $detalle[$i]['codMPrima'], $detalle[$i]['loteMP']);
        $InvMPrimaOperador->updateInvMPrima($datos);
    }
    $DetOProdOperador->deleteDetOProd($lote);
    $OProdOperador->anulaOProd($lote);
    $ruta = "listarOrProdA.php";
    $mensaje = "Orden de Producción Anulada con Éxito";
}catch (Exception $e){
    $ruta = "../menu.php";
    $mensaje = "Error al anular Orden de Producción";
} finally {
    mover_pag($ruta, $mensaje, $icon);
}

?>
