<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');
$fecha=$_GET['fecha'];

$InvProdTerminadoOperador = new InvProdTerminadosOperaciones();
$invProdTerminado = $InvProdTerminadoOperador->getTableInvProdTerminadoFecha($fecha);
$datos = [];
for ($i = 0; $i < count($invProdTerminado); $i++) {
    $datos[$i]['codPresentacion'] = $invProdTerminado[$i]['codPresentacion'];
    $datos[$i]['presentacion'] = $invProdTerminado[$i]['presentacion'];
    $datos[$i]['invtotal'] = $invProdTerminado[$i]['invtotal'];
    $datos[$i]['entrada'] = $invProdTerminado[$i]['entradaOProduccion']+$invProdTerminado[$i]['entradaCambio']+$invProdTerminado[$i]['entradaKit'];
    $datos[$i]['salida'] = $invProdTerminado[$i]['salidaVentas'] + $invProdTerminado[$i]['salidaCambios'] + $invProdTerminado[$i]['salidaKits'] + $invProdTerminado[$i]['salidaRemision'];
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