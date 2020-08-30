<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');

$codMPrima = $_GET['codMPrima'];
$loteMP = $_GET['loteMP'];
$detOProdOperador = new DetOProdOperaciones();
$mprimas = $detOProdOperador->getDetOrdMPTrazabilidad($codMPrima, $loteMP );

$titulo = array(
    'draw' => 0,
    'recordsTotal' => count($mprimas),
    'recordsFiltered' => count($mprimas)
);
$datosRetorno = array(
    $titulo,
    'data' => $mprimas
);
print json_encode($datosRetorno);

?>