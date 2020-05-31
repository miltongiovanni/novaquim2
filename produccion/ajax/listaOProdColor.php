<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');


$OProdColorOperador = new OProdColorOperaciones();
$DetOProdColorOperador = new DetOProdColorOperaciones();
$oProdColors = $OProdColorOperador->getTableOProdColor();
$datos = [];
for ($i = 0; $i < count($oProdColors); $i++) {
    $loteColor = $oProdColors[$i]['loteColor'];
    $detOProdColor = $DetOProdColorOperador->getTableDetOProdColor($loteColor);
    $datos[$i]['loteColor'] = $loteColor;
    $datos[$i]['fechProd'] = $oProdColors[$i]['fechProd'];
    $datos[$i]['nomMPrima'] = $oProdColors[$i]['nomMPrima'];
    $datos[$i]['cantKg'] = $oProdColors[$i]['cantKg'];
    $datos[$i]['nomPersonal'] = $oProdColors[$i]['nomPersonal'];
    $datos[$i]['detOProdColor'] = $detOProdColor;
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