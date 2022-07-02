<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idDistribucion = $_GET['idDistribucion'];
$DetCompraOperador = new DetComprasOperaciones();
$productos = $DetCompraOperador->getHistoricoComprasDistribucion($idDistribucion);

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($productos),
    'recordsFiltered' => count($productos),
    'data' => $productos
);

print json_encode($datosRetorno);

?>