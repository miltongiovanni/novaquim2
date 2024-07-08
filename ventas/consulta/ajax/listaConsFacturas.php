<?php

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');
$fechaIni = $_GET['fechaIni'];
$fechaFin = $_GET['fechaFin'];

$FacturaOperador = new FacturasOperaciones();
$facturas = $FacturaOperador->getTableFacturasPorFecha($fechaIni, $fechaFin);

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($facturas),
    'recordsFiltered' => count($facturas),
    'data' => $facturas
);
print json_encode($datosRetorno);

?>