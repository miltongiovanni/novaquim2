<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
$idGasto=$_GET['idGasto'];
spl_autoload_register('cargarClases');
$DetGastoOperador = new DetGastosOperaciones();
$detalle = $DetGastoOperador->getTableDetGastos($idGasto);

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($detalle),
    'recordsFiltered' => count($detalle),
    'data' => $detalle
);


print json_encode($datosRetorno);


?>