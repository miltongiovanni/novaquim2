<?php

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idTapOEnv = $_GET['idTapOEnv'];
$DetCompraOperador = new DetComprasOperaciones();
if($idTapOEnv<100){
    $productos=$DetCompraOperador->getHistoricoComprasEnvases($idTapOEnv);
}
else{
    $productos = $DetCompraOperador->getHistoricoComprasTapas($idTapOEnv);
}

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($productos),
    'recordsFiltered' => count($productos),
    'data' => $productos
);

print json_encode($datosRetorno);

?>