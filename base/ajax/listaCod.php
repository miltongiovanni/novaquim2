<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$precioSinIva = $_GET['precioSinIva'];
$PreciosOperador = new PreciosOperaciones();
$precios = $precioSinIva == 0 ? $PreciosOperador->getTablePreciosHTML() : $PreciosOperador->getTablePreciosHTMLSinIva();

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($precios),
    'recordsFiltered' => count($precios),
    'data' => $precios
);

print json_encode($datosRetorno);

?>