<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');


$KitOperador = new KitsOperaciones();
$DetKitOperador = new DetKitsOperaciones();
$kits = $KitOperador->getTableKits();
$datos = [];
for ($i = 0; $i < count($kits); $i++) {
    $idKit = $kits[$i]['idKit'];
    $detKit = $DetKitOperador->getTableDetKits($idKit);
    $datos[$i]['idKit'] = $idKit;
    $datos[$i]['codigo'] = $kits[$i]['codigo'];
    $datos[$i]['producto'] = $kits[$i]['producto'];
    $datos[$i]['nomEnvase'] = $kits[$i]['nomEnvase'];
    $datos[$i]['detKit'] = $detKit;
}
$titulo = array(
    'draw' => 0,
    'recordsTotal' => count($datos),
    'recordsFiltered' => count($datos)
);
$datosRetorno = array(
    $titulo,
    'data' => $datos
);
print json_encode($datosRetorno);

?>