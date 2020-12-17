<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
$idFactura=$_GET['idFactura'];
spl_autoload_register('cargarClases');
$detFacturaOperador = new DetFacturaOperaciones();
$detalle = $detFacturaOperador->getDetFactura($idFactura);
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