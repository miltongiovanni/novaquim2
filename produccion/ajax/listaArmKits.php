<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');


$ArmKitOperador = new ArmKitsOperaciones();
$kitsArm = $ArmKitOperador->getTableArmKits();
$titulo = array(
    'draw' => 0,
    'recordsTotal' => count($kitsArm),
    'recordsFiltered' => count($kitsArm)
);
$datosRetorno = array(
    $titulo,
    'data' => $kitsArm
);
print json_encode($datosRetorno);

?>