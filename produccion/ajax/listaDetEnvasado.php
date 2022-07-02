<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');

$lote=$_GET['lote'];
$EnvasadoOperador = new EnvasadoOperaciones();
$datos = $EnvasadoOperador->getTableEnvasado($lote);

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($datos),
    'recordsFiltered' => count($datos),
    'data' => $datos
);
print json_encode($datosRetorno);

?>