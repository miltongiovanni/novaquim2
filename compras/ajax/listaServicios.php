<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$servicioOperador = new ServiciosOperaciones();
$servicios = $servicioOperador->getTableServicios();
$titulo = array(
    'draw' => 0,
    'recordsTotal' => count($servicios),
    'recordsFiltered' => count($servicios)
);
$datosRetorno = array(
    $titulo,
    'data' => $servicios
);


print json_encode($datosRetorno);


?>