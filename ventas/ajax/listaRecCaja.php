<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$recCajaOperador = new RecCajaOperaciones();
$recibos = $recCajaOperador->getTableRecCaja();

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($recibos),
    'recordsFiltered' => count($recibos),
    'data' => $recibos
);


print json_encode($datosRetorno);


?>