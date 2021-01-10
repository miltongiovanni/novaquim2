<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');


$InvProdTerminadoOperador = new InvProdTerminadosOperaciones();
$invProdTerminado = $InvProdTerminadoOperador->getTableInvProdTerminado();

$datos = [];
for ($i = 0; $i < count($invProdTerminado); $i++) {
    $detInvProdTerminado = $InvProdTerminadoOperador->getDetInv($invProdTerminado[$i]['codPresentacion']);
    $datos[$i]['codPresentacion'] = $invProdTerminado[$i]['codPresentacion'];
    $datos[$i]['presentacion'] = $invProdTerminado[$i]['presentacion'];
    $datos[$i]['invtotal'] = $invProdTerminado[$i]['invtotal'];
    $datos[$i]['invL'] = $invProdTerminado[$i]['invL'];
    $datos[$i]['invReal'] = $invProdTerminado[$i]['invReal'];
    $datos[$i]['detInvProdTerminado'] = $detInvProdTerminado;
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