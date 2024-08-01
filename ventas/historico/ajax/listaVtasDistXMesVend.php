<?php

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}
$year=$_GET['year'];
$idPersonal=$_GET['idPersonal'];
spl_autoload_register('cargarClases');
$detFacOperador = new DetFacturaOperaciones();
$detalle = $detFacOperador->getAcumuladoProductosDistribucionPorMesProductoVend($year, $idPersonal);

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($detalle),
    'recordsFiltered' => count($detalle),
    'data' => $detalle
);


print json_encode($datosRetorno);


?>