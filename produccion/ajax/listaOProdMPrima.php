<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');


$OProdMPrimaOperador = new OProdMPrimaOperaciones();
$DetOProdMPrimaOperador = new DetOProdMPrimaOperaciones();
$oProdColors = $OProdMPrimaOperador->getTableOProdMPrima();
$datos = [];
for ($i = 0; $i < count($oProdColors); $i++) {
    $loteMP = $oProdColors[$i]['loteMP'];
    $detOProdMPrima = $DetOProdMPrimaOperador->getTableDetOProdMPrimas($loteMP);
    $datos[$i]['loteMP'] = $loteMP;
    $datos[$i]['fechProd'] = $oProdColors[$i]['fechProd'];
    $datos[$i]['nomMPrima'] = $oProdColors[$i]['nomMPrima'];
    $datos[$i]['cantKg'] = $oProdColors[$i]['cantKg'];
    $datos[$i]['nomPersonal'] = $oProdColors[$i]['nomPersonal'];
    $datos[$i]['detOProdMPrima'] = $detOProdMPrima;
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