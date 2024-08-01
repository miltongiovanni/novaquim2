<?php

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$columns = array(
    array('db' => 'idRemision', 'dt' => 'idRemision'),
    array('db' => 'fechaRemision', 'dt' => 'fechaRemision'),
    array('db' => 'nomCliente', 'dt' => 'nomCliente'),
    array('db' => 'nomSucursal', 'dt' => 'nomSucursal'),
    array('db' => 'idPedido', 'dt' => 'idPedido'),
    array('db' => 'fechaPedido', 'dt' => 'fechaPedido'),
);

$bindings = array();
$limit = SSP::limit($_GET, $columns);
$order = SSP::order($_GET, $columns);
$where = SSP::filter($_GET, $columns, $bindings);
$remisionOperador = new RemisionesOperaciones();
$totalRemisiones = $remisionOperador->getTotalTableSalidaRemisiones($where, $bindings);
$remisiones = $remisionOperador->getTableSalidaRemisiones($limit, $order, $where, $bindings);
$detRemisionOperador = new DetRemisionesOperaciones();
for($i=0;$i<count($remisiones); $i++){
    $remisiones[$i]['detRemision']= $detRemisionOperador->getTableDetRemisionFactura($remisiones[$i]['idRemision']);
}

$datosRetorno = array(
    'draw' => isset ( $_GET['draw'] ) ?intval( $_GET['draw'] ) : 0,
    'recordsTotal' => intval($totalRemisiones),
    'recordsFiltered' => intval($totalRemisiones),
    'data' => $remisiones
);
print json_encode($datosRetorno);

?>