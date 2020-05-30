<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');


$OProdOperador = new OProdOperaciones();
$oProdsA = $OProdOperador->getTableOProdAnuladas();
$titulo = array(
    'draw' => 0,
    'recordsTotal' => count($oProdsA),
    'recordsFiltered' => count($oProdsA)
);
$datosRetorno = array(
    $titulo,
    'data' => $oProdsA
);
print json_encode($datosRetorno);

?>