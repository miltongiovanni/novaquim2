<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$egresoOperador = new EgresoOperaciones();
$egresos = $egresoOperador->getTableEgresos();
$titulo = array(
    'draw' => 0,
    'recordsTotal' => count($egresos),
    'recordsFiltered' => count($egresos)
);
$datosRetorno = array(
    $titulo,
    'data' => $egresos
);


print json_encode($datosRetorno);


?>