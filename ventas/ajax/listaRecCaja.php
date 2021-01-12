<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$recCajaOperador = new RecCajaOperaciones();
$recibos = $recCajaOperador->getTableRecCaja();
$titulo = array(
    'draw' => 0,
    'recordsTotal' => count($recibos),
    'recordsFiltered' => count($recibos)
);
$datosRetorno = array(
    $titulo,
    'data' => $recibos
);


print json_encode($datosRetorno);


?>