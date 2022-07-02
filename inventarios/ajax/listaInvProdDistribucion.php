<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');


$InvProdDistribucionOperador = new InvDistribucionOperaciones();
$productos = $InvProdDistribucionOperador->getTableInvDistribucion();

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($productos),
    'recordsFiltered' => count($productos),
    'data' => $productos
);
print json_encode($datosRetorno);

?>