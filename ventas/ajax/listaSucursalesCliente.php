<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idCliente= $_GET['idCliente'];
$clienteSucursalOperador = new ClientesSucursalOperaciones();
$sucursales = $clienteSucursalOperador->getTableClienteSucursales($idCliente);
$titulo = array(
    'draw' => 0,
    'recordsTotal' => count($sucursales),
    'recordsFiltered' => count($sucursales)
);
$datosRetorno = array(
    $titulo,
    'data' => $sucursales
);
print json_encode($datosRetorno);

?>