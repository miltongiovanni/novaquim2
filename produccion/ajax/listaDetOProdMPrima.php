<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');

$loteMP=$_GET['loteMP'];
$DetOProdMPrimaOperador = new DetOProdMPrimaOperaciones();
$datos = $DetOProdMPrimaOperador->getTableDetOProdMPrimas($loteMP);

$titulo = array(
    'draw' => 0,
    'recordsTotal' => count($datos),
    'recordsFiltered' => count($datos)
);
$datosRetorno = array(
    $titulo,
    'data' => $datos
);
print json_encode($datosRetorno);

?>