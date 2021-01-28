<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
$year=$_GET['year'];
spl_autoload_register('cargarClases');
$detFacOperador = new DetFacturaOperaciones();
$detalle = $detFacOperador->getAcumuladoProductosEmpresaPorMesProducto($year);
$titulo = array(
    'draw' => 0,
    'recordsTotal' => count($detalle),
    'recordsFiltered' => count($detalle)
);
$datosRetorno = array(
    $titulo,
    'data' => $detalle
);


print json_encode($datosRetorno);


?>