<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idRutero=$_GET['idRutero'];
$ruteroOperador = new RuteroOperaciones();
$pedidoOperador = new PedidosOperaciones();
$rutero = $ruteroOperador->getRutero($idRutero);
$pedidos = explode(',', $rutero['listaPedidos']);
$pedidosRutero =[];
foreach ($pedidos as $pedido){
    $pedidosRutero[] = $pedidoOperador->getPedidoRutero($pedido);
}

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($pedidosRutero),
    'recordsFiltered' => count($pedidosRutero),
    'data' => $pedidosRutero
);

print json_encode($datosRetorno);


?>