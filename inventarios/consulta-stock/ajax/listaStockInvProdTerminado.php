<?php

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');


$InvProdTerminadoOperador = new InvProdTerminadosOperaciones();
$invProdTerminado = $InvProdTerminadoOperador->getTableStockInvProdTerminado();

$datos = [];
for ($i = 0; $i < count($invProdTerminado); $i++) {
    $detInvProdTerminado = $InvProdTerminadoOperador->getDetInv($invProdTerminado[$i]['codPresentacion']);
    $datos[$i]['codPresentacion'] = $invProdTerminado[$i]['codPresentacion'];
    $datos[$i]['presentacion'] = $invProdTerminado[$i]['presentacion'];
    $datos[$i]['invtotal'] = $invProdTerminado[$i]['invtotal'];
    $datos[$i]['stockPresentacion'] = $invProdTerminado[$i]['stockPresentacion'];
    $datos[$i]['detInvProdTerminado'] = $detInvProdTerminado;
}

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($datos),
    'recordsFiltered' => count($datos),
    'data' => $datos
);
print json_encode($datosRetorno);

?>