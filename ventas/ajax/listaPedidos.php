<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$estadoPedido= $_GET['estadoPedido'];
$pedidoOperador = new PedidosOperaciones();
$pedidos = $pedidoOperador->getTablePedidos($estadoPedido);
$detPedidoOperador = new DetPedidoOperaciones();
for($i=0;$i<count($pedidos); $i++){
    $pedidos[$i]['detPedido']= $detPedidoOperador->getDetPedido($pedidos[$i]['idPedido']);
}
$titulo = array(
    'draw' => 0,
    'recordsTotal' => count($pedidos),
    'recordsFiltered' => count($pedidos)
);
$datosRetorno = array(
    $titulo,
    'data' => $pedidos
);
print json_encode($datosRetorno);

?>