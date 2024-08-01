<?php

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');
$fechaIni = $_GET['fechaIni'];
$fechaFin = $_GET['fechaFin'];

$salidasOperador = new RemisionesOperaciones();
$salidas = $salidasOperador->getTableSalidasPorFecha($fechaIni, $fechaFin);

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($salidas),
    'recordsFiltered' => count($salidas),
    'data' => $salidas
);
print json_encode($datosRetorno);

?>