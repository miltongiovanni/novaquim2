<?php
include "../includes/valAcc.php";
foreach ($_POST as $nombre_campo => $valor) {
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
    //echo $nombre_campo." = ".$valor."<br>";
    eval($asignacion);
}
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$DetOProdOperador = new DetOProdOperaciones();
$InvMPrimaOperador = new InvMPrimasOperaciones();
$datos = array($cantidadMPrima, $lote, $codMPrima);

try {
    $DetOProdOperador->updateDetOProd($datos);
    $invMPrima = $InvMPrimaOperador->getInvMPrimaByLote($codMPrima, $loteMP);
    $nvoInvMPrima = $invMPrima + $cantidad_ant - $cantidadMPrima;
    $datos = array($nvoInvMPrima, $codMPrima, $loteMP);
    $InvMPrimaOperador->updateInvMPrima($datos);
    $_SESSION['lote'] = $lote;
    $ruta = "detO_Prod.php";
    $mensaje = "Detalle Orden de Producción actualizado correctamente";
} catch (Exception $e) {
    $_SESSION['lote'] = $lote;
    $ruta = "detO_Prod.php";
    $mensaje = "Error al actualizar Orden de Producción";
} finally {
    mover_pag($ruta, $mensaje);
}


?>
