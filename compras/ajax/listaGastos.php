<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');


$GastoOperador = new GastosOperaciones();
$DetGastoOperador = new DetGastosOperaciones();
$gastos = $GastoOperador->getTableGastos();

$datos = [];
for ($i = 0; $i < count($gastos); $i++) {
    $detGasto = $DetGastoOperador->getTableDetGastos($gastos[$i]['idGasto']);
    $datos[$i]['idGasto'] = $gastos[$i]['idGasto'];
    $datos[$i]['nitProv'] = $gastos[$i]['nitProv'];
    $datos[$i]['nomProv'] = $gastos[$i]['nomProv'];
    $datos[$i]['numFact'] = $gastos[$i]['numFact'];
    $datos[$i]['fechGasto'] = $gastos[$i]['fechGasto'];
    $datos[$i]['fechVenc'] = $gastos[$i]['fechVenc'];
    $datos[$i]['descEstado'] = $gastos[$i]['descEstado'];
    $datos[$i]['totalGasto'] = $gastos[$i]['totalGasto'];
    $datos[$i]['retefuenteGasto'] = $gastos[$i]['retefuenteGasto'];
    $datos[$i]['reteicaGasto'] = $gastos[$i]['reteicaGasto'];
    $datos[$i]['vreal'] = $gastos[$i]['vreal'];
    $datos[$i]['detGasto'] = $detGasto;
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