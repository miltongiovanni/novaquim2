<?php

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$estadoPedido= $_GET['estadoPedido'];
$columns = array(
    array('db' => 'idPedido', 'dt' => 'idPedido'),
    array('db' => 'fechaPedido', 'dt' => 'fechaPedido'),
    array('db' => 'fechaEntrega', 'dt' => 'fechaEntrega'),
    array('db' => 'tipoPrecio', 'dt' => 'tipoPrecio'),
    array('db' => 'nomCliente', 'dt' => 'nomCliente'),
    array('db' => 'estadoPedido', 'dt' => 'estadoPedido'),
    array('db' => 'nomSucursal', 'dt' => 'nomSucursal'),
    array('db' => 'dirSucursal', 'dt' => 'dirSucursal'),
);

$bindings = array();
$limit = SSP::limit($_GET, $columns);
$order = SSP::order($_GET, $columns);
$where = SSP::filter($_GET, $columns, $bindings);
$pedidoOperador = new PedidosOperaciones();
$total_pedidos = $pedidoOperador->getTotalTablePedidos($estadoPedido, $where, $bindings);
$pedidos = $pedidoOperador->getTablePedidos($estadoPedido, $limit, $order, $where, $bindings);
$detPedidoOperador = new DetPedidoOperaciones();
for($i=0;$i<count($pedidos); $i++){
    $pedidos[$i]['detPedido']= $detPedidoOperador->getDetPedido($pedidos[$i]['idPedido']);
}

$datosRetorno = array(
    'draw' => isset ( $_GET['draw'] ) ?intval( $_GET['draw'] ) : 0,
    'recordsTotal' => intval($total_pedidos),
    'recordsFiltered' => intval($total_pedidos),
    'data' => $pedidos
);
print json_encode($datosRetorno);

?>