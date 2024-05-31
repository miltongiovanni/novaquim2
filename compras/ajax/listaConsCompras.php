<?php

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');
$fechaIni = $_GET['fechaIni'];
$fechaFin = $_GET['fechaFin'];

$CompraOperador = new ComprasOperaciones();
$compras = $CompraOperador->getTableComprasPorFecha($fechaIni, $fechaFin);

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($compras),
    'recordsFiltered' => count($compras),
    'data' => $compras
);
print json_encode($datosRetorno);

?>