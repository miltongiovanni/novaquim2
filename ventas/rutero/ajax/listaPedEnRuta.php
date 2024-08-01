<?php

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$ruteroOperador = new RuteroOperaciones();
$pedidos = $ruteroOperador->getListaPedidosRutero();

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($pedidos),
    'recordsFiltered' => count($pedidos),
    'data' => $pedidos
);


print json_encode($datosRetorno);


?>