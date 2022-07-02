<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$RecCajaOperador = new RecCajaOperaciones();
$facturas = $RecCajaOperador->getTableFacturasXcobrar();
$datos = [];

$titulo = array(
);
$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($facturas),
    'recordsFiltered' => count($facturas),
    'data' => $facturas
);
print json_encode($datosRetorno);

?>