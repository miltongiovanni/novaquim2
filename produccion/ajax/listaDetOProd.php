<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');

$lote=$_GET['lote'];
$DetOProdOperador = new DetOProdOperaciones();
$datos = $DetOProdOperador->getTableDetOProd($lote);

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