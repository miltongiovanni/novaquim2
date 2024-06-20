<?php

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');

$loteColor=$_GET['loteColor'];
$DetOProdColorOperador = new DetOProdColorOperaciones();
$datos = $DetOProdColorOperador->getTableDetOProdColor($loteColor);

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($datos),
    'recordsFiltered' => count($datos),
    'data' => $datos
);
print json_encode($datosRetorno);

?>