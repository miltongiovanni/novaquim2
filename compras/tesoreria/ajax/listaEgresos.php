<?php

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$egresoOperador = new EgresoOperaciones();
$egresos = $egresoOperador->getTableEgresos();

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($egresos),
    'recordsFiltered' => count($egresos),
    'data' => $egresos
);


print json_encode($datosRetorno);


?>