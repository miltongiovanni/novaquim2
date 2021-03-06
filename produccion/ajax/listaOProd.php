<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');


$OProdOperador = new OProdOperaciones();
$DetOProdOperador = new DetOProdOperaciones();
$oProds = $OProdOperador->getTableOProd();

$datos = [];
for ($i = 0; $i < count($oProds); $i++) {
    $detOProd = $DetOProdOperador->getTableDetOProd($oProds[$i]['lote']);
    $datos[$i]['lote'] = $oProds[$i]['lote'];
    $datos[$i]['fechProd'] = $oProds[$i]['fechProd'];
    $datos[$i]['nomProducto'] = $oProds[$i]['nomProducto'];
    $datos[$i]['nomFormula'] = $oProds[$i]['nomFormula'];
    $datos[$i]['cantidadKg'] = $oProds[$i]['cantidadKg'];
    $datos[$i]['nomPersonal'] = $oProds[$i]['nomPersonal'];
    $datos[$i]['descEstado'] = $oProds[$i]['descEstado'];
    $datos[$i]['detOProd'] = $detOProd;
}
$titulo = array(
    'draw' => 0,
    'recordsTotal' => count($datos),
    'recordsFiltered' => count($datos)
);
$datosRetorno = array(
    $titulo,
    'data' => $datos
);
print json_encode($datosRetorno);

?>