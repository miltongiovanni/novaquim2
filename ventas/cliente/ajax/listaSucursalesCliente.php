<?php

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idCliente= $_GET['idCliente'];
$clienteSucursalOperador = new ClientesSucursalOperaciones();
$sucursales = $clienteSucursalOperador->getTableClienteSucursales($idCliente);

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($sucursales),
    'recordsFiltered' => count($sucursales),
    'data' => $sucursales
);
print json_encode($datosRetorno);

?>