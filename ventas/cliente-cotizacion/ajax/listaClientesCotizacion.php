<?php

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$clienteOperador = new ClientesCotizacionOperaciones();
$clientes = $clienteOperador->getTableClientes();

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($clientes),
    'recordsFiltered' => count($clientes),
    'data' => $clientes
);
print json_encode($datosRetorno);

?>