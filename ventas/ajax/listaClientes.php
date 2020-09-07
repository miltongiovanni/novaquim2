<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$clienteOperador = new ClientesOperaciones();
$estadoCliente= $_GET['estadoCliente'];
$clientes = $clienteOperador->getTableClientes($estadoCliente);
$titulo = array(
    'draw' => 0,
    'recordsTotal' => count($clientes),
    'recordsFiltered' => count($clientes)
);
$datosRetorno = array(
    $titulo,
    'data' => $clientes
);
print json_encode($datosRetorno);

?>