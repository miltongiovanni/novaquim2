<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');


$EnvasadoDistOperador = new EnvasadoDistOperaciones();
$envasadoDist = $EnvasadoDistOperador->getTableEnvasadoDist();
$titulo = array(
    'draw' => 0,
    'recordsTotal' => count($envasadoDist),
    'recordsFiltered' => count($envasadoDist)
);
$datosRetorno = array(
    $titulo,
    'data' => $envasadoDist
);
print json_encode($datosRetorno);

?>