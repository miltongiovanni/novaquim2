<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');


$OProdOperador = new OProdOperaciones();
$OProdSinEnvasar = $OProdOperador->getTableOProdSinEnvasar();
$titulo = array(
    'draw' => 0,
    'recordsTotal' => count($OProdSinEnvasar),
    'recordsFiltered' => count($OProdSinEnvasar)
);
$datosRetorno = array(
    $titulo,
    'data' => $OProdSinEnvasar
);
print json_encode($datosRetorno);

?>