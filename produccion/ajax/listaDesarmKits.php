<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');


$DesarmKitOperador = new DesarmKitsOperaciones();
$kitsDesarm = $DesarmKitOperador->getTableDesarmKits();
$titulo = array(
    'draw' => 0,
    'recordsTotal' => count($kitsDesarm),
    'recordsFiltered' => count($kitsDesarm)
);
$datosRetorno = array(
    $titulo,
    'data' => $kitsDesarm
);
print json_encode($datosRetorno);

?>