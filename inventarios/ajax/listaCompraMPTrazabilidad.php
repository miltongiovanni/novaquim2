<?php

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');

$codMPrima = $_GET['codMPrima'];
$loteMP = $_GET['loteMP'];
$detCompraOperador = new DetComprasOperaciones();
$mprimas = $detCompraOperador->getDetComprasMPTrazabilidad($codMPrima, $loteMP );

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($mprimas),
    'recordsFiltered' => count($mprimas),
    'data' => $mprimas
);
print json_encode($datosRetorno);

?>