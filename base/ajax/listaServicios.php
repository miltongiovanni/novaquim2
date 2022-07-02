<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$servicioOperador = new ServiciosOperaciones();
$servicios = $servicioOperador->getTableServicios();

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($servicios),
    'recordsFiltered' => count($servicios),
    'data' => $servicios
);


print json_encode($datosRetorno);


?>