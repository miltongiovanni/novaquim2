<?php

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}
$idNotaC=$_GET['idNotaC'];
spl_autoload_register('cargarClases');
$detNotaCrOperador = new DetNotaCrOperaciones();
$detalle = $detNotaCrOperador->getTableDetNotaCrDev($idNotaC);

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($detalle),
    'recordsFiltered' => count($detalle),
    'data' => $detalle
);


print json_encode($datosRetorno);


?>