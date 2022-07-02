<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');


$OProdOperador = new OProdOperaciones();
$OProdSinEnvasar = $OProdOperador->getTableOProdSinEnvasar();

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($OProdSinEnvasar),
    'recordsFiltered' => count($OProdSinEnvasar),
    'data' => $OProdSinEnvasar
);
print json_encode($datosRetorno);

?>