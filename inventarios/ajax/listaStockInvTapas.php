<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');


$InvTapaOperador = new InvTapasOperaciones();
$tapas = $InvTapaOperador->getTableStockInvTapas();

$titulo = array(
    'draw' => 0,
    'recordsTotal' => count($tapas),
    'recordsFiltered' => count($tapas)
);
$datosRetorno = array(
    $titulo,
    'data' => $tapas
);
print json_encode($datosRetorno);

?>