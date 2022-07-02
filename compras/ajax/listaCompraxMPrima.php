<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$codMPrima = $_GET['codMPrima'];
$DetCompraOperador = new DetComprasOperaciones();
$productos = $DetCompraOperador->getHistoricoComprasMPrimas($codMPrima);

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($productos),
    'recordsFiltered' => count($productos),
    'data' => $productos
);

print json_encode($datosRetorno);

?>