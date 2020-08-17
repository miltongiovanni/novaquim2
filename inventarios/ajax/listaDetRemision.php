<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
$idRemision=$_GET['idRemision'];
spl_autoload_register('cargarClases');
$detRemisionOperador = new DetRemisionesOperaciones();
$detalle = $detRemisionOperador->getTableDetRemisiones($idRemision);
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