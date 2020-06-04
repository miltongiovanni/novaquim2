<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');

$loteColor=$_GET['loteColor'];
$DetOProdColorOperador = new DetOProdColorOperaciones();
$datos = $DetOProdColorOperador->getTableDetOProdColor($loteColor);

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