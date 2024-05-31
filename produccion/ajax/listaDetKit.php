<?php

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}
$idKit=$_GET['idKit'];
spl_autoload_register('cargarClases');
$detKitOperador = new DetKitsOperaciones();
$detalle = $detKitOperador->getTableDetKits($idKit);

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($detalle),
    'recordsFiltered' => count($detalle),
    'data' => $detalle
);


print json_encode($datosRetorno);


?>