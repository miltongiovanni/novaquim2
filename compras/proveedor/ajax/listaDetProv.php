<?php

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}
$idProv=$_GET['idProv'];
spl_autoload_register('cargarClases');
$detProveedorOperador = new DetProveedoresOperaciones();
$detalle = $detProveedorOperador->getTableDetProveedores($idProv);

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($detalle),
    'recordsFiltered' => count($detalle),
    'data' => $detalle
);


print json_encode($datosRetorno);


?>