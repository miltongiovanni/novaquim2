<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');


$CambioOperador = new CambiosOperaciones();
$DetCambioOperador = new DetCambiosOperaciones();
$cambios = $CambioOperador->getCambiosTable();

$datos = [];
for ($i = 0; $i < count($cambios); $i++) {
    $detCambio = $DetCambioOperador->getDetCambiosTable($cambios[$i]['idCambio']);
    $detCambio2 = $DetCambioOperador->getDetCambios2Table($cambios[$i]['idCambio']);
    $datos[$i]['idCambio'] = $cambios[$i]['idCambio'];
    $datos[$i]['fechaCambio'] = $cambios[$i]['fechaCambio'];
    $datos[$i]['nomPersonal'] = $cambios[$i]['nomPersonal'];
    $datos[$i]['motivo_cambio'] = $cambios[$i]['motivo_cambio'];
    $datos[$i]['detCambio'] = $detCambio;
    $datos[$i]['detCambio2'] = $detCambio2;
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