<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');
$fecha=$_GET['fecha'];

$InvProdTerminadoOperador = new InvProdTerminadosOperaciones();
$invProdTerminado = $InvProdTerminadoOperador->getTableInvProdTerminado();

$datos = [];
for ($i = 0; $i < count($invProdTerminado); $i++) {
    $entradaProduccion = $InvProdTerminadoOperador->getEntradaInvProdTerminadoProduccion($invProdTerminado[$i]['codPresentacion'], $fecha);
    $entradaCambio = $InvProdTerminadoOperador->getEntradaInvProdTerminadoCambio($invProdTerminado[$i]['codPresentacion'], $fecha);
    $entradaKit = $InvProdTerminadoOperador->getEntradaInvProdTerminadoKit($invProdTerminado[$i]['codPresentacion'], $fecha);
    $salidaVentas = $InvProdTerminadoOperador->getSalidaInvProdTerminadoVentas($invProdTerminado[$i]['codPresentacion'], $fecha);
    $salidaCambios = $InvProdTerminadoOperador->getSalidaInvProdTerminadoCambios($invProdTerminado[$i]['codPresentacion'], $fecha);
    $salidaKits = $InvProdTerminadoOperador->getSalidaInvProdTerminadoKits($invProdTerminado[$i]['codPresentacion'], $fecha);
    $salidaRemisiones = $InvProdTerminadoOperador->getSalidaInvProdTerminadoRemisiones($invProdTerminado[$i]['codPresentacion'], $fecha);
    $datos[$i]['codPresentacion'] = $invProdTerminado[$i]['codPresentacion'];
    $datos[$i]['presentacion'] = $invProdTerminado[$i]['presentacion'];
    $datos[$i]['invtotal'] = $invProdTerminado[$i]['invtotal'];
    $datos[$i]['entrada'] = $entradaProduccion+$entradaCambio+$entradaKit;
    $datos[$i]['salida'] = $salidaVentas + $salidaCambios + $salidaKits + $salidaRemisiones;
    $datos[$i]['inventario'] = round($datos[$i]['invtotal'] - $datos[$i]['entrada'] + $datos[$i]['salida'], 0);
}
$titulo = array(
    'draw' => 0,
    'recordsTotal' => count($datos),
    'recordsFiltered' => count($datos)
);
$datosRetorno = array(
    $titulo,
    'data' => $datos
);
print json_encode($datosRetorno);

?>