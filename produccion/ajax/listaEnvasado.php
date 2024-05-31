<?php

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');

$columns = array(
    array('db' => 'lote', 'dt' => 'lote'),
    array('db' => 'fechProd', 'dt' => 'fechProd'),
    array('db' => 'nomProducto', 'dt' => 'nomProducto'),
    array('db' => 'nomFormula', 'dt' => 'nomFormula'),
    array('db' => 'cantidadKg', 'dt' => 'cantidadKg'),
    array('db' => 'nomPersonal', 'dt' => 'nomPersonal'),
    array('db' => 'descEstado', 'dt' => 'descEstado'),
);
$bindings = array();
$limit = SSP::limit($_GET, $columns);
$order = SSP::order($_GET, $columns);
$where = SSP::filter($_GET, $columns, $bindings);

$OProdOperador = new OProdOperaciones();
$EnvasadoOperador = new EnvasadoOperaciones();
$totalOProd = $OProdOperador->getTotalTableOProd($where, $bindings);
$oProds = $OProdOperador->getTableOProd($limit, $order, $where, $bindings);

$datos = [];
for ($i = 0; $i < count($oProds); $i++) {
    $envasado = $EnvasadoOperador->getTableEnvasado($oProds[$i]['lote']);
    $datos[$i]['lote'] = $oProds[$i]['lote'];
    $datos[$i]['fechProd'] = $oProds[$i]['fechProd'];
    $datos[$i]['nomProducto'] = $oProds[$i]['nomProducto'];
    $datos[$i]['nomFormula'] = $oProds[$i]['nomFormula'];
    $datos[$i]['cantidadKg'] = $oProds[$i]['cantidadKg'];
    $datos[$i]['nomPersonal'] = $oProds[$i]['nomPersonal'];
    $datos[$i]['descEstado'] = $oProds[$i]['descEstado'];
    $datos[$i]['envasado'] = $envasado;
}

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => intval($totalOProd),
    'recordsFiltered' => intval($totalOProd),
    'data' => $datos
);
print json_encode($datosRetorno);

?>