<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');
$fechaIni = $_GET['fechaIni'];
$fechaFin = $_GET['fechaFin'];

$GastoOperador = new GastosOperaciones();
$gastos = $GastoOperador->getTableGastosPorFecha($fechaIni, $fechaFin);

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($gastos),
    'recordsFiltered' => count($gastos),
    'data' => $gastos
);
print json_encode($datosRetorno);

?>