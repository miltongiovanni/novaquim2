<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$columns = array(
    array('db' => 'idFactura', 'dt' => 'idFactura'),
    array('db' => 'idPedido', 'dt' => 'idPedido'),
    array('db' => 'idRemision', 'dt' => 'idRemision'),
    array('db' => 'nomCliente', 'dt' => 'nomCliente'),
    array('db' => 'fechaFactura', 'dt' => 'fechaFactura'),
    array('db' => 'fechaVenc', 'dt' => 'fechaVenc'),
    array('db' => 'totalFactura', 'dt' => 'totalFactura'),
    array('db' => 'estadoFactura', 'dt' => 'estadoFactura'),
);

$bindings = array();
$limit = SSP::limit($_GET, $columns);
$order = SSP::order($_GET, $columns);
$where = SSP::filter($_GET, $columns, $bindings);
$facturaOperador = new FacturasOperaciones();
$total_facturas = $facturaOperador->getTotalNumeroFacturas($where, $bindings);
$facturas = $facturaOperador->getTableFacturas($limit, $order, $where, $bindings);
$detFacturaOperador = new DetFacturaOperaciones();
for ($i = 0; $i < count($facturas); $i++) {
    $facturas[$i]['idPedido'] = str_replace(',', ', ', $facturas[$i]['idPedido']);
    $facturas[$i]['idRemision'] = str_replace(',', ', ', $facturas[$i]['idRemision']);
    $facturas[$i]['detFactura'] = $detFacturaOperador->getDetFactura($facturas[$i]['idFactura']);
}
$datosRetorno = array(
    'draw' => isset ( $request['draw'] ) ?intval( $request['draw'] ) : 0,
    'recordsTotal' => intval($total_facturas),
    'recordsFiltered' => intval($total_facturas),
    'data' => $facturas
);

print json_encode($datosRetorno);

?>