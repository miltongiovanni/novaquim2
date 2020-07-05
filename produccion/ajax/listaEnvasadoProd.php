<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');

$codProducto=$_GET['codProducto'];
$OProdOperador = new OProdOperaciones();
$EnvasadoOperador = new EnvasadoOperaciones();
$oProds = $OProdOperador->getOrdenesProdXProd($codProducto);

$datos = [];
for ($i = 0; $i < count($oProds); $i++) {
    $envasado = $EnvasadoOperador->getTableEnvasado($oProds[$i]['lote']);
    $datos[$i]['lote'] = $oProds[$i]['lote'];
    $datos[$i]['fechProd'] = $oProds[$i]['fechProd'];
    $datos[$i]['cantidadKg'] = $oProds[$i]['cantidadKg'];
    $datos[$i]['nomPersonal'] = $oProds[$i]['nomPersonal'];
    $datos[$i]['descEstado'] = $oProds[$i]['descEstado'];
    $datos[$i]['envasado'] = $envasado;
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